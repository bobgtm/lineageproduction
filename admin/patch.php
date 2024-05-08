<?php 
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }

 $user_id = $user->data()->id;
if($user_id != 1){
    usError("You don't belong on this page");
    Redirect::to("admin/home.php");
}


echo "Running Patch...";
// Remove OhHeyCafe from shops table
$count_cafe = $db->query("SELECT * FROM `shops` WHERE name = 'Oh Hey Cafe'")->count();
echo $count_cafe . "</br>";
if($count_cafe > 0){
    $db->query("DELETE FROM
     `shops` WHERE name = 'Oh Hey Cafe'");
    $db->errorString();
    echo "Successfully removed Oh Hey Cafe from shops table</br>";
}

// remove oh_hey_cafe from users table
$count_cafe_users = $db->query("SELECT * FROM `users` WHERE username = 'oh_hey_cafe'")->count();
echo $count_cafe_users . "</br>";
if($count_cafe_users > 0){
    $db->query("DELETE FROM `shops` WHERE username = 'oh_hey_cafe'")->count();
    $db->errorString();
    echo "Successfully removed Oh Hey Cafe from users table</br>";
}

echo "done";
