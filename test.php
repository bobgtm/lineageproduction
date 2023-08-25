<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';


$user = [
    "name" => null
];
$user['name'] ??= 'Guest';
echo $user['name'] . "<br>";
function concat(string $a, string $b) {
    return $a . ": " . $b . "<br>";
}

echo concat("testing", "the world");
?> 
