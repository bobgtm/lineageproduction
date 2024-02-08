<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
}
// User Informatioin
$uname = $user->data()->username;
$user_id = $user->data()->id;

 if($user_id != 9){
    usError("That page is for East End Only");
    Redirect::to($us_url_root."admin/home.php");
 }

 // Product Information
function getIct() {
    global $db;    
$res = $db->query("SELECT * FROM ict_products")->results();    
    return $res;
}

// dump(getIct());

// Unit Types
$units = $db->query("SELECT * FROM unit_types WHERE id > 3")->results();
// dump($units);


// $fields = [];
if(!empty($_POST)){
    $ict_products = Input::get('ict_');
    dump($ict_products);
    $inserted = false;
    $ict_vals = Input::get('ict_inv_val');
    dnd($ict_vals);
    foreach($ict_products as $id => $amt) {

        $fields = [];
        if($amt != "") {
            
            $fields = [ 
                'entry_date' => date('Y-m-d H:i:s'),
                'product_id' => $id,
                'qty' => $amt,
                // 'unit_type' => $unit
                ];

        }
            // $db->insert('ict_inventory_entry', $fields);
            dump($fields);
            $inserted = true;
        }
        
        if($inserted && ($uname == "mills")){
            usSuccess("༼ つ ◕_◕ ༽つ saved ");
        } else {
            usSuccess("Coffee Inventory Saved");
        }
}


// if(!empty($_POST['ict_par'])){
//     // echo "This one is submitted";
    
//     $fields = [
//         'store_id' => $store_id
//     ];
//     $ict = Input::get('ict');
    
//     $ict_par_vals = Input::get('ict_par_val');

//     $check = $db->query("SELECT * FROM ict_product_par WHERE product_type > ?", [3])->count();
    
//     if($check < 1) {
//         foreach($ict as $k => $v){
//             foreach($vals as $t => $u){
//                 if ($k == $t){
                    
//                     $fields = [
//                         'product_id' => $k,
//                         'par' => $v,
//                         'unit_id' => $u,
//                         'store_id' => $store_id,
//                         'product_type' => 3,
//                     ];
//                     // dump($fields);
//                     $db->insert('ict_product_par', $fields);            
//                     dump($db->errorString());
//                 }
//             }
//         }
//         usSuccess("Syrup Par Added");
//     }
//     // Associative array of store_ids to quantities
    
//     // If so, then we delete the previous entry and replace it with a new entry
//     if($check >= 1){
//         $ids = Input::get('ict_val');    
        
//         foreach($ids as $i => $par) {
//             $db->delete("ict_product_par", ["and", ["product_id", "=", $i]]);   
//         }
//         foreach($syrups as $k => $v){
//             foreach($vals as $t => $u){
//                 if ($k == $t){
                    
//                     $fields = [
//                         'product_id' => $k,
//                         'par' => $v,
//                         'unit_id' => $u,
//                         // 'store_id' => $store_id,
//                         // 'product_type' => 3,
//                     ];
                    
//                     $db->insert('ict_product_par', $fields);            
//                 }
//             }
//         }
//         usSuccess("Par Updated");
//     }
// }

?>


<div class="row row-cols-2 d-flex flex-lg-row flex-column justify-content-center mx-5-lg mx-0 mt-3">
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center mb-5">    
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> ICT Inventory</h4>
                
            
            <div class="form-group">
                
                
            <?php 
                $ict = getIct(); 
                foreach($ict as $p) { ?>
                <label for="ict_inv" class="mt-3 fw-bold"><?= $p->product_name ?></label>
                <div class="row row-cols-2">
                    <div class="col"><input type="number" class="form-control mt-2" name="ict_[<?= $p->id ?>]" id="" value="" step="0.01"></div>
                    <div class="col"><select class="form-control mt-2 text-center" name="ict_inv_val[<?= $p->id ?>]" id="">
                        <?php foreach($units as $v) { ?>
                            <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                        <?php } ?>
                    </select></div>
                </div>
                <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="ict_inv" value="Save" class="btn btn btn-success mt-3">
            </div>        
        </form>
    </div>
    
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center">
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> ICT Par</h4>
           
           <div class="form-group">
            <?php 
                    $syr = getIct(); 
                    foreach($syr as $s) { ?>
                    <label for="syr" class="mt-3 fw-bold"><?= $s->product_name ?></label>
                    <div class="row row-cols-2">
                      <div class="col"><input type="number" class="form-control mt-2" name="ict[<?= $s->id ?>]" id="" value=""></div>
                        <div class="col"><select class="form-control mt-2 text-center" name="ict_par[<?= $s->id ?>]" id="">
                            <?php foreach($units as $v) { ?>
                                <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                            <?php } ?>
                        </select></div>
                    </div>
                    <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="ict_par" value="Save" class="btn btn btn-success mt-3">
            </div>
        </form>
    </div>
    
    
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
