<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }

function getsyr() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_type = 3 AND active = 1")->results();
    
    return $res;
}

$units = $db->query("SELECT * FROM unit_types")->results();

// $details = $user->data()->permissions;
$uname = $user->data()->fname . " " .  $user->data()->lname;
$user_ids = $db->query("SELECT id FROM users")->results();
$store_id = "";
$uid = $user->data()->id;

if($uid == 9) {
    $store_id = 1;
}
if($uid == 5) {
    $store_id = 2;
}
if($uid == 10) {
    $store_id = 3;
}

// Grabs Par Information from form
if(!empty($_POST['syrpar'])){
    
    
    $fields = [
     'store_id' => $store_id
    ];
    $syrups = Input::get('spar');
   
    $vals = Input::get('valpar');

    $check = $db->query("SELECT * FROM product_par WHERE store_id = ? AND product_type = ?", [$store_id, 3])->count();
    
    if($check < 1) {
        foreach($syrups as $k => $v){
            foreach($vals as $t => $u){
                if ($k == $t){
                    
                    $fields = [
                        'product_id' => $k,
                        'par' => $v,
                        'unit_id' => $u,
                        'store_id' => $store_id,
                        'product_type' => 3,
                    ];
                    // dump($fields);
                    $db->insert('product_par', $fields);            
                    dump($db->errorString());
                }
            }
        }
        usSuccess("Syrup Par Added");
    }
    // Associative array of store_ids to quantities
    
    // If so, then we delete the previous entry and replace it with a new entry
    if($check >= 1){
        $ids = Input::get('valpar');    
        
        foreach($ids as $i => $par) {
            $db->delete("product_par", ["and", ["product_id", "=", $i], ["store_id", "=", $store_id]]);   
        }
        foreach($syrups as $k => $v){
            foreach($vals as $t => $u){
                if ($k == $t){
                    
                    $fields = [
                        'product_id' => $k,
                        'par' => $v,
                        'unit_id' => $u,
                        'store_id' => $store_id,
                        'product_type' => 3,
                    ];
                    
                    $db->insert('product_par', $fields);            
                }
            }
        }
        usSuccess("Syrup Par Updated");
    }
}

if (!empty($_POST['syrinv'])) {

    $syrups = Input::get('sinv');
    $syrups2 = [];
    foreach ($syrups as $k => $v) {
        for ($i = 0; $i < count($syrups); $i++) {
            $syrups2[$k] = number_format((float) $v, 2, '.', '');
        }
    }
    $vals = Input::get('val');
    foreach ($syrups as $k => $v) {
        if ($v != "") {
            foreach ($vals as $t => $u) {
                if ($k == $t) {
                    $fields = [
                        'syrup_id' => $k,
                        'quantity' => $v,
                        'unit_id' => $u,
                        'entry_date' => date('Y-m-d H:i:s'),
                        'store_id' => $store_id
                    ];
                    $db->insert('inventory_syrup', $fields);
                }
            }

        }


        usSuccess("Syrup Inventory Saved");
    }
}
?>


<div class="row row-cols-2 d-flex flex-lg-row flex-column justify-content-center mx-5-lg mx-0 mt-3">
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center mb-5">    
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> Syrup Inventory</h4>
                
            
            <div class="form-group">
                
                
            <?php 
                $syr = getsyr(); 
                foreach($syr as $s) { ?>
                <label for="syr" class="mt-3 fw-bold"><?= $s->product_name ?></label>
                <div class="row row-cols-2">
                    <div class="col"><input type="number" class="form-control mt-2" name="sinv[<?= $s->id ?>]" id="" value="" step="0.01"></div>
                    <div class="col"><select class="form-control mt-2 text-center" name="val[<?= $s->id ?>]" id="">
                        <?php foreach($units as $v) { ?>
                            <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                        <?php } ?>
                    </select></div>
                </div>
                <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="syrinv" value="Save" class="btn btn btn-success mt-3">
            </div>        
        </form>
    </div>
    
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center">
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> Syrup Par</h4>
           
           <div class="form-group">
            <?php 
                    $syr = getsyr(); 
                    foreach($syr as $s) { ?>
                    <label for="syr" class="mt-3 fw-bold"><?= $s->product_name ?></label>
                    <div class="row row-cols-2">
                        <div class="col"><input type="number" class="form-control mt-2" name="spar[<?= $s->id ?>]" id="" value=""></div>
                        <div class="col"><select class="form-control mt-2 text-center" name="valpar[<?= $s->id ?>]" id="">
                            <?php foreach($units as $v) { ?>
                                <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                            <?php } ?>
                        </select></div>
                    </div>
                    <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="syrpar" value="Save" class="btn btn btn-success mt-3">
            </div>
        </form>
    </div>
    
    
</div>
<div class="text-center">
        <a class="text-center mx-auto" href="_syrups.php"><button class="btn btn-success btn-sm px-3 mt-3 mb-5">View Current Syrup Inventory</button></a>
</div>

<div class="row mt-4 mb-4">
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
</div> 
