<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$uname = $user->data()->username;

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }
 
function getCoffees() {
    global $db;    
    $res = $db->query("SELECT * FROM products WHERE product_type = 1 AND active = 1")->results();
    return $res;
}


// $fields = [];
if(!empty($_POST)){
    $coffees = Input::get('coffee_');
    $store_id = Input::get('location');
    $inserted = false;
    foreach($coffees as $id => $inv) {
        $fields = [];
        if($inv != "") {
            $invCheck = $db->query("SELECT * FROM inventory_coffee WHERE store_id = ? and coffee_id = ? ORDER BY entry_date DESC LIMIT 1", [$store_id, $id])->results();
            
            foreach($invCheck as $i) {
                if($inv == $i->stock) {
                    usMessage("A count of {$inv} was already recorded for this product");
                    break 2;
                }
            }

            $fields = [ 
                'entry_date' => date('Y-m-d H:i:s'),
                'store_id' => $store_id,
                'coffee_id' => $id,
                'stock' => $inv
                ];

        }
            $db->insert('inventory_coffee', $fields);
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
        <h4 class="text-center">Coffee Inventory</h4>
            
        <div class="col col-lg-3 col-md-6 col-sm-12 mx-auto text-center">
            <label for="" class="form-label">Shop Location</label>
            <select name="location" class="form-select mb-1" id="" required>
                <option selected disabled value="">Where ya at?</option>

                <option value="1">East End</option>
                <option value="2">Mills</option>
                <option value="3">UCF</option>
            </select>
        </div>
             
        <div class="col col-lg-3 mb-3 mx-auto">
            <div class="form-group">
                <!-- Coffee Retail -->
                <?php 
                $coffee = getCoffees();
                foreach($coffee as $c) { ?>
                    <label for="coffee" class="mt-2"><?= $c->product_name ?></label>
                    <input type="number" class="form-control mt-2" name="coffee_[<?= $c->id ?>]" id="" value="">
                <?php } ?>
            </div>
        </div>
        <input type="submit" name="cbinv" value="Save" class="btn btn btn-success mb-3">                
    </form>
    <div class="text-center">
            <a class="text-center" href="_coffee.php"><button class="btn btn-success btn-sm mx-auto px-3 mb-5">View Current Coffee Inventory</button></a>
    </div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
