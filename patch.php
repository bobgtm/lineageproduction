<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

// Create ICT Products Table
$countIctProductTable = $db->query("SHOW TABLES LIKE 'inventory_ict'")->count();

if($countIctProductTable == 0) {
    $db->query("CREATE TABLE `ict_products` (
        `id` int(11) NOT NULL,
        `product_name` varchar(255) DEFAULT NULL,
        `abbreviation` int(11) DEFAULT NULL,
        `unit_type` varchar(255) DEFAULT NULL
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    $db->query("ALTER TABLE `ict_products` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);");
}



// Add Products to ict_products
$count = $db->query("SELECT * FROM `ict_products`")->count();
if($count <= 0){
    $db->query("INSERT INTO `ict_products` (`product_name`, `abbreviation`, `unit_type`) VALUES
      ('Oloong', NULL, NULL),
      ('Jasmine Green', NULL, NULL),
      ('Yunnan Black', NULL, NULL),
      ('Matcha', NULL, NULL),
      ('Hibiscus', NULL, NULL),
      ('Rooibos', NULL, NULL),
      ('Fetco Filters', NULL, NULL),
      ('PINK Cozy Latte Cups', NULL, NULL),
      ('Choice 12 oz. Clear PET Plastic Cold Cup', NULL, NULL),
      ('Choice 16 oz. Clear PET Plastic Cold Cup', NULL, NULL),
      ('Choice 9, 12, 16, 20, 24 oz clear flat lid', NULL, NULL),
      ('Choice 4 oz. White Poly Paper Hot Cup', NULL, NULL),
      ('Choice 4 oz. White Hot Paper Cup Travel Lid', NULL, NULL),
      ('8 oz, Hot Paper Cup', NULL, NULL),
      ('12 oz. Hot paper Cup', NULL, NULL),
      ('8 oz. Hot lid', NULL, NULL),
      ('12 oz. Hot lid', NULL, NULL),
      ('Pink Cozy Lids', NULL, NULL),
      ('Black Jumbo Straws, Wrapped', NULL, NULL),
      ('Homie bottles', NULL, NULL),
      ('Homie lids', NULL, NULL),
      ('Chocolate powder (or capp.)', NULL, NULL),
      ('Sugar In The Raw Packets - 500/Case', NULL, NULL),
      ('Stevia In The Raw Packets', NULL, NULL),
      ('Large, Trash black bags', NULL, NULL),
      ('Small, trash black/white bags', NULL, NULL),
      ('Napkins', NULL, NULL),
      ('Brown Paper Bags', NULL, NULL),
      ('8-32 oz. Molded Fiber 4-Cup Carrier', NULL, NULL),
      ('7 1/2\" Woodgrain Coffee Stirrers', NULL, NULL),
      ('Pastry Bags', NULL, NULL),
      ('Urnex 20 oz. Cafiza Espresso Machine Cleaning Powder', NULL, NULL),
      ('Urnex Grindz Coffee / Espresso Grinder Cleaner Granules', NULL, NULL),
      ('Urnex 1 ltr. Rinza Milk Frother Cleaner', NULL, NULL),
      ('Dish Sponge', NULL, NULL),
      ('Scouring Pads', NULL, NULL),
      ('Chix Competive Wet Wipe', NULL, NULL);
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
$countIctEntryTable = $db->query("SHOW TABLES LIKE 'inventory_ict'")->count();
if ($countIctEntryTable == 0) {
    $db->query("CREATE TABLE `lineage`.`ict_inventory_entry` 
    (`id` INT(11) NOT NULL AUTO_INCREMENT, 
    `entry_date` DATE NOT NULL,
    `product_id` INT(11) NOT NULL, 
    `qty` INT(11) NOT NULL,
    `unit_id` INT(11) NOT NULL,
    PRIMARY KEY (`id`)) ENGINE = InnoDB;");
}

echo "done";
