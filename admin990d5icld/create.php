<?php
	// Check if _PS_ADMIN_DIR_ is defined
	if (!defined('_PS_ADMIN_DIR_')) {
    	// if _PS_ADMIN_DIR_ is not defined, define.
    	define('_PS_ADMIN_DIR_', getcwd());
	}
	// Setup connection with config.inc.php (required for database connection, ...)
	include(_PS_ADMIN_DIR_.'/../config/config.inc.php');

    $secure_key = 'ed3fa1ce558e1c2528cfbaa3f99403';

	// Check if the client use the correct secure_key, url to use: www.yourstore.com/yourbackoffice/importmyproduct.php?secure_key=ed3fa1ce558e1c2528cfbaa3f99403
	if(!Tools::getValue('secure_key') || Tools::getValue('secure_key') != $secure_key) {
    	// If the secure_key is not set our not equal the php page will stop running.
    	die('UNAUTHORIZED: We dont want you on this page!');
	}
	echo 'Welcome, the secure_key you have used is correct. Now we can start adding product programmatically ... <br>';
 
    $csv_file = file_get_contents('scrapResult2.csv');
    $data = explode("\n", $csv_file);
    $data = array_filter(array_map("trim", $data));
    $default_language = Configuration::get('PS_LANG_DEFAULT');

    foreach ($data as $csv) {
        
        $csv_values = explode(";", $csv);

        $reference = ' ';
        $name = $csv_values[1];
        $price = $csv_values[2];
        $quantity = $csv_values[4];
        $category = $csv_values[0];
        $description = $csv_values[5];
        $ean = '';
        $url = $csv_values[3];

        addProduct($ean, $reference, $name, $quantity, $description, $price, $url, $category, array(12, $category));
    }

    function addProduct($ean13, $ref, $name, $qty, $text, $price, $imgUrl, $catDef, $catAll) {
    	$product = new Product();          	// Create new product in prestashop
    	$product->ean13 = $ean13;
    	$product->reference = $ref;
    	$product->name = createMultiLangField($name);
    	$product->description = htmlspecialchars($text);
    	$product->id_category_default = $catDef;
    	$product->redirect_type = '301';
    	$product->price = number_format($price, 2, '.', '');
    	$product->id_tax_rules_group = 1;
    	$product->minimal_quantity = 1;
    	$product->show_price = 1;
    	$product->on_sale = 0;
    	$product->online_only = 0;
    	$product->meta_description = '';
    	$product->link_rewrite = createMultiLangField(Tools::str2url($name)); // Contribution credits: mfdenis
    	$product->add();                    	// Submit new product
    	StockAvailable::setQuantity($product->id, null, $qty); // id_product, id_product_attribute, quantity
    	$product->addToCategories($catAll); 	// After product is submitted insert all categories

    	// add product image.
    	$shops = Shop::getShops(true, null, true);
    	$image = new Image();
    	$image->id_product = $product->id;
    	$image->position = Image::getHighestPosition($product->id) + 1;
    	$image->cover = true;
    	if (($image->validateFields(false, true)) === true && ($image->validateFieldsLang(false, true)) === true && $image->add()) {
        	$image->associateTo($shops);
        	if (!uploadImage($product->id, $image->id, $imgUrl)) {
            	$image->delete();
        	}
    	}
    	echo 'Product added successfully (ID: ' . $product->id . ')';
	}

    function uploadImage($id_entity, $id_image = null, $imgUrl) {
    	$tmpfile = tempnam(_PS_TMP_IMG_DIR_, 'ps_import');
    	$watermark_types = explode(',', Configuration::get('WATERMARK_TYPES'));
    	$image_obj = new Image((int)$id_image);
    	$path = $image_obj->getPathForCreation();
    	$imgUrl = str_replace(' ', '%20', trim($imgUrl));
    	// Evaluate the memory required to resize the image: if it's too big we can't resize it.
    	if (!ImageManager::checkImageMemoryLimit($imgUrl)) {
        	return false;
    	}
    	if (@copy($imgUrl, $tmpfile)) {
        	ImageManager::resize($tmpfile, $path . '.jpg');
        	$images_types = ImageType::getImagesTypes('products');
        	foreach ($images_types as $image_type) {
            	ImageManager::resize($tmpfile, $path . '-' . stripslashes($image_type['name']) . '.jpg', $image_type['width'], $image_type['height']);
            	if (in_array($image_type['id_image_type'], $watermark_types)) {
            	Hook::exec('actionWatermark', array('id_image' => $id_image, 'id_product' => $id_entity));
            	}
        	}
    	} else {
        	unlink($tmpfile);
        	return false;
    	}
    	unlink($tmpfile);
    	return true;
	}

    function createMultiLangField($field) {
    	$res = array();
    	foreach (Language::getIDs(false) as $id_lang) {
        	$res[$id_lang] = $field;
    	}
    	return $res;
	}

