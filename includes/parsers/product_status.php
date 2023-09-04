<?php 

require_once '../../users/init.php';
$db = DB::getInstance();

$resp = ['success' => false, 'msg' => '', 'status' => ''];


$id = Input::get('id');
$active = Input::get('active');
$product = $db->update("products", $id, ["active" => $active]);



$resp['success'] = 'true';
if($active == 0 ) {
    $resp['status'] = "Disabled";
} else {
    $resp['status'] = "Enabled";
}
$resp['id'] = $id;
$resp['msg'] = "updated";




echo json_encode($resp);die;
