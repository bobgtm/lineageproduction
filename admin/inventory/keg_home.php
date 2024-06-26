<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }

function getCB() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_type = 2 AND active = 1 ORDER BY id ASC")->results();
    
    return $res;
}

//  = $db->query("SELECT * FROM products WHERE product_type = 2 ORDER BY id DESC")->results();
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
if(!empty($_POST['cbpar'])){
    
    $fields = [
     'store_id' => $store_id
    ];
    // Associative array of store_ids to quantities
    $ids = Input::get('cbid');    
    // Need to check whether there are entries in the db for the store already,
    $check = $db->query("SELECT * FROM product_par WHERE store_id = ? AND product_id BETWEEN 4 AND 6", [$store_id])->count();
    
    // If not, then we add the first entry
    if($check < 1) {
        foreach($ids as $i => $par) {
            $fields["product_id"] = $i; 
            $fields["par"] = $par; 
            $fields["product_type"] = 2;
            $db->insert("product_par", $fields);
        }
    } 
    // If so, then we delete the previous entry and replace it with a new entry
    if($check >= 1){
        foreach($ids as $i => $par) {
            $db->delete("product_par", ["and", ["product_id", "=", $i], ["store_id", "=", $store_id]]);   
        }
        foreach($ids as $i => $par) {
            $fields["product_id"] = $i; 
            $fields["par"] = $par; 
            $fields["product_type"] = 2;
            $db->insert("product_par", $fields);
        }
    }

    usSuccess("Cold Brew Par Saved");
}

if(!empty($_POST['cbinv'])){
    
    $cbs = Input::get('cb');
    
    $fields = [ 
    'entry_date' => date('Y-m-d'),
    'store_id' => $store_id
    ];
    foreach ($cbs as $cb => $inv) {
        $invCheck = $db->query("SELECT * FROM inventory_cold_brew_entry WHERE store_id = ? ORDER BY entry_date DESC LIMIT 1", [$store_id])->results();
        switch ($cb) {
            case 'Cold Brew Black':
                if($inv == ""){
                $fields['cbb_stock'] = $invCheck[0]->cbb_stock;    
                } else {
                $fields['cbb_stock'] = $inv;
                }
                break;
            case 'Cold Brew White':
                if($inv == ""){
                $fields['cbw_stock'] = $invCheck[0]->cbw_stock;    
                } else {
                $fields['cbw_stock'] = $inv;
                }
                break;
            case 'Cold Brew Vegan':
                if($inv == ""){
                $fields['cbv_stock'] = $invCheck[0]->cbv_stock;    
                } else {
                $fields['cbv_stock'] = $inv;
                }
                break;
            default:
            // Handle the default case if needed
                break;
        }
}
$db->insert('inventory_cold_brew_entry', $fields);

usSuccess("Inventory Saved");
}
?>


<div class="row row-cols-2 d-flex flex-md-row flex-column justify-content-center align-items-center mx-1 mt-4">
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center">    
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> Cold Brew Inventory</h4>
                
            
            <div class="form-group">
                <!-- Kegs -->
                <?php 
                $cb = getCB();
                foreach($cb as $c) { ?>
                <label for="cb" class="mt-2"><?= $c->product_name ?></label>
                <input type="number" class="form-control mt-2" name="cb[<?= $c->product_name ?>]" id="" value="">
                <?php } ?>
            </div>
            <div class="item">
                <input type="submit" name="cbinv" value="Save" class="btn btn btn-success mt-3">
            </div>        
        </form>
    </div>
    
    <div class="col col-12 col-md-8 col-lg-4 mx-auto mt-lg-0 mt-5 text-center">
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> Cold Brew Par</h4>
            <div class="form-group">
                <!-- Kegs -->
                <?php 
                $cb = getCB();
                foreach($cb as $c) { ?>
                <label for="cb" class="mt-2"><?= $c->product_name ?></label>
                <input type="number" class="form-control mt-2" name="cbid[<?= $c->id ?>]" id="" value="">
                <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="cbpar" value="Save" class="btn btn btn-success mt-3">
            </div>
        </form>
    </div>
    
    
</div>
<div class="text-center">
        <a class="text-center mx-auto" href="_keg.php"><button class="btn btn-success btn-sm px-3 mt-3 mb-5">View Current Keg Inventory</button></a>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
