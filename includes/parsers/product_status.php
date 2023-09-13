<?php 

require_once '../../users/init.php';
$db = DB::getInstance();

$resp = ['success' => false, 'msg' => '', 'status' => ''];


$id = Input::get('id');
$active = Input::get('active');
$c = $db->query("SELECT * FROM `products` WHERE `id` = ?", [$id])->first();
$cId = $db->query("SELECT * FROM products_coffee WHERE product_id = ?", [$id])->first();
$resp['success'] = 'true';
if($active == 0 ) {
    $resp['status'] = "Disabled";
} else {
    $resp['status'] = "Enabled";
}
$resp['id'] = $id;
$resp['msg'] = "updated";

if($c->product_type == 1){
    $db->update("products", $id, ["active" => $active]);
    $db->update("products_coffee", $cId->product_id, ["active" => $active]);
} else {
    $db->update("products", $id, ["active" => $active]);
}



echo json_encode($resp);die;
