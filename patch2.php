<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

echo "Running Patch...";
// Create ICT Products Table
$db->query("UPDATE `ict_products` SET unit_type = 2 WHERE id BETWEEN 7 AND 18");
dump($db->errorString());
$db->query("UPDATE `ict_products` SET unit_type = 3 WHERE id BETWEEN 19 AND 26");
dump($db->errorString());
$db->query("UPDATE `ict_products` SET unit_type = 4 WHERE id BETWEEN 27 AND 31");
dump($db->errorString());
$db->query("UPDATE `ict_products` SET unit_type = 5 WHERE id BETWEEN 32 AND 37");
dump($db->errorString());
