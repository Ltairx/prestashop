from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.common.keys import Keys
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.wait import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import random
import string
import time


def get_random_string(length):
    letters = string.ascii_lowercase
    result_str = ''.join(random.choice(letters) for i in range(length))
    return result_str

browser = webdriver.Firefox()

# dodawanie produktow
def addProduct(url):
    num = 0
    prod = 0

    while prod < 5:
        browser.get(url)
        all = browser.find_elements("class name", "quick-view")

        browser.execute_script("arguments[0].click();", all[prod+num])
        time.sleep(1)

        c = browser.find_element("class name", "touchspin-up")
        time.sleep(1)
        for _ in range(0, random.randint(1, 10)):
            c.click()

        time.sleep(5)
        if len(browser.find_elements("class name", "product-unavailable")) == 1: 
            num += 1
            continue

        b = browser.find_element("class name", "add-to-cart")
        b.click()
        prod += 1

addProduct('https://127.0.0.1/prestashop/index.php?id_category=47&controller=category')
addProduct('https://127.0.0.1/prestashop/index.php?id_category=46&controller=category')

# odpalenie koszyka

browser.get('https://127.0.0.1/prestashop/index.php?controller=cart&action=show')

b = browser.find_element("class name", "remove-from-cart")
b.click()

time.sleep(1)

b = browser.find_element("class name", "btn-primary")
b.click()

# uzupelnianie pol do zamowienia

element = WebDriverWait(browser, 1000).until(
        EC.presence_of_element_located((By.ID, "field-id_gender-1"))
    )

b = browser.find_element("id", "field-id_gender-1")
b.click()

b = browser.find_element("id", "field-firstname")
b.send_keys(get_random_string(random.randint(3, 10)))

b = browser.find_element("id", "field-lastname")
b.send_keys(get_random_string(random.randint(3, 10)))

b = browser.find_element("id", "field-email")
#b.send_keys("prestanabe@wp.pl")
b.send_keys(f"{get_random_string(random.randint(3, 10))}@wp.pl")

b = browser.find_element("id", "field-password")
password = get_random_string(random.randint(10, 20))
print(password)
b.send_keys(password)

b = browser.find_element("id", "field-birthday")
b.send_keys(f"{random.randint(1960, 2015)}-{random.randint(10, 12)}-{random.randint(10, 31)}")

b = browser.find_element("name", "customer_privacy")
b.click()

b = browser.find_element("name", "psgdpr")
b.click()

time.sleep(1)
b = browser.find_element("class name", "continue")
b.click()



element = WebDriverWait(browser, 1000).until(
        EC.presence_of_element_located((By.ID, "field-address1"))
    )

b = browser.find_element("id", "field-address1")
b.send_keys(f"{get_random_string(random.randint(3, 10))} {random.randint(1, 200)}")

b = browser.find_element("id", "field-postcode")
b.send_keys(f"80-{random.randint(100, 999)}")

b = browser.find_element("id", "field-city")
b.send_keys(get_random_string(random.randint(3, 10)))

b = browser.find_elements("class name", "continue")
for i in b:
    if i.is_displayed():
        break

i.click()




b = browser.find_element("id", "delivery_option_6")
b.click()

b = browser.find_elements("class name", "continue")
for i in b:
    if i.is_displayed():
        break

i.click()


element = WebDriverWait(browser, 1000).until(
        EC.presence_of_element_located((By.ID, "payment-option-2"))
    )
b = browser.find_element("id", "payment-option-2")
b.click()

b = browser.find_element("id", "conditions_to_approve[terms-and-conditions]")
b.click()

b = browser.find_elements("class name", "btn-primary")
for i in b:
    if i.is_displayed():
        break

i.click()


browser.get('https://127.0.0.1/prestashop/index.php?controller=history')

b = browser.find_elements("class name", "label")
for i in b:
    if i.is_displayed():
        break

print(i.text)

browser.quit()
