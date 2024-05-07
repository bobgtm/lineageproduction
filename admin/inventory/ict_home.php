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

 if($user_id != 9 && $user_id != 1 && $user_id != 12){
    usError("That page is for East End Only");
    Redirect::to($us_url_root."admin/home.php");
 }
 // Product Information
function getIct() {
    global $db;    
    $res = $db->query("SELECT * FROM ict_products")->results();    
    return $res;
}

function getictUnits() {
    global $db;
    $res = $db->query("SELECT DISTINCT unit_type FROM ict_products")->results();
    
    return $res;
}
// Unit Types
$units = $db->query("SELECT * FROM unit_types WHERE id > 3")->results();

// Inventory Form Submission
if(!empty($_POST['ict_inv'])){
    $ict_products = Input::get('ict_');
    // dump($ict_products);
    $inserted = false;
    $ict_vals = Input::get('ict_inv_val');
    $ict_notes = Input::get('ict_notes');
    
    $fields = [];
    foreach($ict_products as $id => $amt) {
        if($amt != "") {
            foreach($ict_vals as $t => $u){
                foreach($ict_notes as $i => $note) {
                    if($id == $t && $id == $i){
                        $fields = [ 
                            'entry_date' => date('Y-m-d'),
                            'product_id' => $id,
                            'qty' => $amt,
                            'unit_id' => $u, 
                            'notes' => $note
                        ];
                        $db->insert('ict_inventory_entry', $fields);
                        dump($db->errorString());
                        $inserted = true;
                    }
                }
            }
        }
    }

        
    if($inserted && ($uname == "mills")){
        usSuccess("༼ つ ◕_◕ ༽つ saved ");
    } else {
        usSuccess("ICT Inventory Saved");
    }
}

// Par form submission
if(!empty($_POST['ict_par'])){
       
    $fields = [];

    $ict = Input::get('ict');
    $ict_par_vals = Input::get('ict_par_val');
    
    $check = 0;
    $added = 0;
    $update = 0;
    // * Iterate through the values of the ict input separating the item_id and the quantity
    foreach($ict as $ict_item_id => $item_quantity) {

        // * As we look through these values, if they contain something other than an empty string, we can proceed
        
        if($item_quantity != "") {
            // * We will need to check and make sure all item_id's with a value have an entry in the product_par table or not
            // * So we query the database for any entries that have the product_id and count those entries
            // * We assigned the value of this query to the $check variable
            $check = $db->query("SELECT * FROM ict_product_par WHERE product_id = ?", [$ict_item_id])->count();
            // * If check is less than one, that means we didn't find any entries for that item
            if ($check < 1) {
                foreach($ict_par_vals as $item_id => $item_unit){
                    if ($ict_item_id == $item_id){
                        $fields = [
                            'product_id' => $ict_item_id,
                            'quantity' => $item_quantity,
                            'unit_id' => $item_unit
                        ];
                        
                        $db->insert('ict_product_par', $fields);            
                        
                    }
                }
                if ($added == 0) {
                    usSuccess("ICT Par Added");
                }
                $added++;
            }
            if ($check >= 1) {
                
                $db->delete("ict_product_par", ["product_id", "=", $ict_item_id]);
                foreach($ict_par_vals as $item_id => $item_unit){
                    if ($ict_item_id == $item_id){
                        $fields = [
                            'product_id' => $ict_item_id,
                            'quantity' => $item_quantity,
                            'unit_id' => $item_unit
                        ];
                        
                        $db->insert('ict_product_par', $fields);            
                        if ($update == 0) {
                            usSuccess("ICT Par Updated");
                        }
                        $update++;
                        
                    }
                }
            }
        }
    }
}

?>

<div class="col col-12 col-md-8 col-lg-12 col-sm-12 mx-auto text-center mb-5">    
    <form  action="" method="post">
        <h4 class="text-center"><?= ucwords($uname) ?> ICT Inventory</h4>
            
        
        <div class="form-group">
            <div class="row">

            
            <?php
            $ict_products = getIct();
            $types = getictUnits();
            foreach ($types as $ip) { ?>
                <div class="">
                <?php foreach ($ict_products as $p) { 
                    if($p->unit_type == $ip->unit_type) { ?>
                    <div class="col"><label for="ict_inv" class="mt-3 fw-bold"><?= $p->product_name . ": " . $p->unit_type ?></label></div>
                    <div class="row row-cols-2">
                        <div class="col"><input type="number" class="form-control mt-2" name="ict_[<?= $p->id ?>]" id="" value="" step="0.01"></div>        
                        <div class="col">
                            <select class="form-control mt-2 text-center" name="ict_inv_val[<?= $p->id ?>]" id="">
                            <?php foreach($units as $v) { ?>
                                <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php } ?>
                <?php } ?>
                </div>
            <?php } ?>
            </div>
        <!-- <?php 
            $ict_products = getIct(); 
            foreach($ict_products as $p) { ?>
            <label for="ict_inv" class="mt-3 fw-bold"><?= $p->product_name ?></label>
            <div class="row row-cols-2">
                <div class="col"><input type="number" class="form-control mt-2" name="ict_[<?= $p->id ?>]" id="" value="" step="0.01"></div>
                <div class="col"><select class="form-control mt-2 text-center" name="ict_inv_val[<?= $p->id ?>]" id="">
                    <?php foreach($units as $v) { ?>
                        <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                    <?php } ?>
                </select></div>
                
            </div>
            <div class="row mt-2">
                <div class="col">
                    <input class="form-control mt-2 mx-auto" type="Text" placeholder="notes" name="ict_notes[<?= $p->id ?>]">
                </div>
            </div>
            <?php } ?> -->

        </div>
        <div class="item ">
            <input type="submit" name="ict_inv" value="Save" class="btn btn btn-success mt-3">
        </div>        
    </form>
</div>
<!-- <div class="row row-cols-2d-flex flex-lg-row flex-column justify-content-center mx-5-lg mx-0 mt-3"> -->
    
    
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center">
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> ICT Par</h4>
           
           <div class="form-group">
            <?php 
                    $syr = getIct(); 
                    foreach($syr as $s) { ?>
                    <label for="syr" class="mt-3 fw-bold"><?= $s->product_name ?></label>
                    <div class="row row-cols-2">
                        <div class="col">
                            <input type="number" class="form-control mt-2" name="ict[<?= $s->id ?>]" id="" value="">
                        </div>
                        <div class="col">
                            <select class="form-control mt-2 text-center" name="ict_par_val[<?= $s->id ?>]" id="">
                                <?php foreach($units as $v) { ?>
                                    <option value="<?= $v->id ?>"><?= $v->unit_name ?></option>
                                <?php } ?>
                            </select>
                        </div>                                           
                    </div>
                    <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="ict_par" value="Save" class="btn btn btn-success mt-3">
            </div>
        </form>
    </div>
      
<!-- </div> -->
<div class="text-center">
        <a class="text-center mx-auto" href="_ict.php"><button class="btn btn-success btn-sm px-3 mb-5">View ICT Inventory</button></a>
</div>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
