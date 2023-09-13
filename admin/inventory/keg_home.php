<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

function getCB() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_name LIKE 'cold%' ORDER BY id DESC")->results();
    
    return $res;
}



$details = $user->data()->permissions;

// Grabs Par Information from form
if(!empty($_POST['cbpar'])){
    $storeid = Input::get('location');
    $fields = [
     'store_id' => $storeid
    ];
    // Associative array of store_ids to quantities
    $ids = Input::get('cbid');    
    // Need to check whether there are entries in the db for the store already,
    $check = $db->query("SELECT * FROM product_par WHERE store_id = ? AND product_id BETWEEN 4 AND 6", [$storeid])->count();
    dump($check);
    // If not, then we add the first entry
    if($check < 1) {
        foreach($ids as $i => $par) {
            $fields["product_id"] = $i; 
            $fields["par"] = $par; 
            $db->insert("product_par", $fields);
        }
    } 
    // If so, then we delete the previous entry and replace it with a new entry
    if($check >= 1){
        foreach($ids as $i => $par) {
            $db->delete("product_par", ["and", ["product_id", "=", $i], ["store_id", "=", $storeid]]);   
        }
        foreach($ids as $i => $par) {
            $fields["product_id"] = $i; 
            $fields["par"] = $par; 
            $db->insert("product_par", $fields);
        }
    }

    usSuccess("Cold Brew Par Saved");
}
// $fields = [];
if(!empty($_POST['cbinv'])){
    
   $cbs = Input::get('cb');
    
        
    $fields = [ 
    'entry_date' => date('Y-m-d'),
    'store_id' => Input::get('location')
    ];
    foreach ($cbs as $cb => $inv) {
    switch ($cb) {
        case 'Cold Brew Black':
            $fields['cbb_stock'] = $inv;
            break;
        case 'Cold Brew White':
            $fields['cbw_stock'] = $inv;
            break;
        case 'Cold Brew Vegan':
            $fields['cbv_stock'] = $inv;
            break;
        default:
                // Handle the default case if needed
            break;
    }
    }

    $db->insert('inventory_cold_brew_entry', $fields);
    usSuccess("Inventory Saved");
    // dump($db->errorString());
     
    
   
   
}
?>


<div class="row row-cols-2 d-flex flex-md-row flex-column justify-content-center align-items-center mx-1 mt-4">
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center">    
        <form  action="" method="post">
            <h4 class="text-center">Cold Brew Inventory</h4>
                
            <div class="form-group">
                <label for="" class="form-label">Shop Location</label>
                <select name="location" class="form-select mb-1" id="" required>
                    <option selected disabled value="">Where ya at?</option>
                    <option value="1">East End</option>
                    <option value="2">Mills</option>
                    <option value="3">UCF</option>
                </select>
            </div>
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
    <?php if((isset($user) && $user->isLoggedIn()) && $user->data()->id == 1 || $user->data()->id == 6) { ?>
    <div class="col col-12 col-md-8 col-lg-4 mx-auto mt-lg-0 mt-5 text-center">
        <form  action="" method="post">
            <h4 class="text-center">Cold Brew Par</h4>
                
            <div class="form-group">
                <label for="" class="form-label">Shop Location</label>
                <select name="location" class="form-select mb-1" id="" required>
                    <option selected disabled value="">Set Cold Brew Par For...</option>
                    <option value="1">East End</option>
                    <option value="2">Mills</option>
                    <option value="3">UCF</option>
                </select>
            </div>
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
    <?php } ?>
    
</div>
<div class="text-center">
        <a class="text-center mx-auto" href="_keg.php"><button class="btn btn-success btn-sm px-3 mt-3 mb-5">View Current Keg Inventory</button></a>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
