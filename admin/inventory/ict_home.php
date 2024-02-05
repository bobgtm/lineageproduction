<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$uname = $user->data()->username;

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }
 
function getIct() {
    global $db;    
$res = $db->query("SELECT * FROM ict_products")->results();    
    return $res;
}



// $fields = [];
if(!empty($_POST)){
    $ict_products = Input::get('ict_');
    // $store_id = Input::get('location');
    $inserted = false;
    // $unit = 
    foreach($ict_products as $id => $amt) {
        $fields = [];
        if($amt != "") {
            // $invCheck = $db->query("SELECT * FROM inventory_ict WHERE store_id = ? and id = ? ORDER BY entry_date DESC LIMIT 1", [$store_id, $id])->results();
            
            // foreach($invCheck as $i) {
            //     if($inv == $i->stock) {
            //         usMessage("A count of {$inv} was already recorded for this product");
            //         break 2;
            //     }
            // }

            $fields = [ 
                'entry_date' => date('Y-m-d H:i:s'),
                'ict_id' => $id,
                'qty' => $amt,
                // 'unit_type' => $unit
                ];

        }
            $db->insert('ict_inventory_entry', $fields);
        dump($fields);
            $inserted = true;
        }
        
        if($inserted && ($uname == "mills")){
            usSuccess("༼ つ ◕_◕ ༽つ saved ");
        } else {
            usSuccess("Coffee Inventory Saved");
        }
    }
?>


<div class="row mt-3 text-center">
    <form  action="" method="post">
        <h4 class="text-center"><?= ucwords($uname) ?> Coffee Inventory</h4>
            
        <div class="col col-lg-3 mb-3 mx-auto">
            <div class="form-group">
                <!-- Coffee Retail -->
                <?php 
                $ict = getIct();
                foreach($ict as $c) { ?>
                    <label for="ict" class="mt-2"><?= $c->product_name ?></label>
                    <input type="number" class="form-control mt-2" name="ict_[<?= $c->id ?>]" id="" value="">
                <?php } ?>
            </div>
        </div>
        <input type="submit" name="ictinv" value="Save" class="btn btn btn-success mb-3">                
    </form>
    <div class="text-center">
            <a class="text-center" href="_ict.php"><button class="btn btn-success btn mx-auto px-3 mb-5">View ICT Numbers</button></a>
    </div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
