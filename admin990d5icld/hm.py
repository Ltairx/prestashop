from bs4 import BeautifulSoup
import requests
import csv
import random

def scrapDes(prodUrl):
    url = "https://www2.hm.com" + prodUrl
    print(url)
    response = requests.get(url, timeout=25, headers=headers)
    content = BeautifulSoup(response.content, "html.parser")
    ele = content.find('p', attrs={"class": "pdp-description-text"})

    t = content.find('div', attrs={"class": "product-detail-main-image-container"})
    t = t.findChild()

    return (ele.text, t['src'])

def scrap(category, url):

    response = requests.get(url, timeout=5, headers=headers)
    content = BeautifulSoup(response.content, "html.parser")
    j = len(woman) - 1 
    i = j

    for ele in content.findAll('h3', attrs={"class": "item-heading"}):
        a = ele.findChild()
        woman.append([a.text])

    for ele in content.findAll('span', attrs={"class": "price regular"}):
        woman[i].append(ele.text)
        i = i + 1

    i = j

    for ele in content.findAll('div', attrs={"class": "image-container"}):
        a = ele.findChild()
        b = scrapDes(a['href'])
        woman[i].append('https:'+b[1])
        woman[i].append(random.randint(0, 100))
        woman[i].append(b[0])
        i = i + 1

    for w in woman:
        if len(w) < 6:
            w.insert(0, category)


    print('tak')


woman = []
url1 = 'https://www2.hm.com/pl_pl/ona/produkty/view-all.html?sort=stock&image-size=small&image=model&offset=0&page-size=170'
url2 = 'https://www2.hm.com/pl_pl/ona/produkty/sukienki.html?sort=stock&image-size=small&image=model&offset=0&page-size=170'
url3 = 'https://www2.hm.com/pl_pl/ona/produkty/bluzy.html?sort=stock&image-size=small&image=model&offset=0&page-size=170'
url4 = 'https://www2.hm.com/pl_pl/ona/produkty/kurtki-i-plaszcze.html?sort=stock&image-size=small&image=model&offset=0&page-size=170'


headers = {'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:106.0) Gecko/20100101 Firefox/106.0'}

scrap(47, url2)
scrap(48, url3)
scrap(46, url4)

with open('/var/www/html/prestashop/admin990d5icld/scrapResult.csv', 'w', encoding='UTF8', newline='') as f:
    writer = csv.writer(f, delimiter=';')

    writer.writerows(woman)
