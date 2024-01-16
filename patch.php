<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

// Create ICT Products Table
$countIctProductTable = $db->query("SHOW TABLES LIKE 'inventory_ict'")->count();

if($countIctProductTable == 0) {
    $db->query("CREATE TABLE ict_products 
    (id int,
    product_name varchar(255), 
    abbreviation int, 
    unit_type varchar(255), 
    product_category varchar(255)
    )");
    $db->query("ALTER TABLE `ict_products` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);");
}

// Add Products to ict_products
$count = $db->query("SELECT * FROM `ict_products`")->count();
if($count <= 0){
    $db->query("INSERT INTO `ict_products` 
    (`product_name`) 
    VALUES ('Oolong'), 
           ('Jasmine Green'),
           ('Yunnan Black'),
           ('Matcha'), 
           ('Hibiscus'), 
           ('Rooibos'), 
           ('Fetco Filters'), 
           ('PINK Cozy Latte Cups'), 
           ('Choice 12 oz. Clear PET Plastic Cold Cup'), 
           ('Choice 16 oz. Clear PET Plastic Cold Cup'), 
           ('Choice 9, 12, 16, 20, 24 oz clear flat lid'), 
           ('Choice 4 oz. White Poly Paper Hot Cup'), 
           ('Choice 4 oz. White Hot Paper Cup Travel Lid'), 
           ('8 oz, Hot Paper Cup'), 
           ('12 oz. Hot paper Cup'), 
           ('8 oz. Hot lid'), 
           ('12 oz. Hot lid'), 
           ('Pink Cozy Lids'), 
           ('Black Jumbo Straws, Wrapped'), 
           ('Homie bottles'), 
           ('Homie lids'), 
           ('Chocolate powder (for capp.)'), 
           ('Sugar In The Raw Packets - 500/Case'), 
           ('Stevia In The Raw Packets'), 
           ('Large, Trash black bags'), 
           ('Small, trash black/white bags'), 
           ('Napkins'), 
           ('Brown Paper Bags'), 
           ('8-32 oz. Molded Fiber 4-Cup Carrier'), 
           ('7 1/2\" Woodgrain Coffee Stirrers'),
           ('Pastry Bags'),
           ('Urnex 20 oz. Cafiza Espresso Machine Cleaning Powder'),
           ('Urnex Grindz Coffee / Espresso Grinder Cleaner Granules'),
           ('Urnex 1 ltr. Rinza Milk Frother Cleaner'),
           ('Dish Sponge'),
           ('Scouring Pads'),
           ('Chix Compettive Wet Wipe')
    ");    
}

// $db->query("ALTER TABLE `ict_products`
// ADD COLUMN abbreviation INT AFTER product_name,
// ADD COLUMN unit_type VARCHAR(255) AFTER abbreviation;
// ");
dump($db->errorString());
// Add ICT Inventory Table for inventory entries
$countInventoryTable = $db->query("SHOW TABLES LIKE 'inventory_ict'")->count();
if($countInventoryTable == 0) {
    $db->query("CREATE TABLE inventory_ict 
    (id int,
    entry_date datetime,
    product_id int,
    amount int
    )");    
}


echo "done";
