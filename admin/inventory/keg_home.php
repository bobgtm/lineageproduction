<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

function getCB() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_name LIKE 'cold%' ORDER BY id DESC")->results();
    
    return $res;
}


// $fields = [];
if(!empty($_POST)){
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


<div class="row mt-3 text-center">
    <form  action="" method="post">
        <h4 class="text-center">Cold Brew Inventory</h4>
            
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
                <!-- Kegs -->
                <?php 
                $cb = getCB();
                foreach($cb as $c) { ?>
                <label for="cb" class="mt-2"><?= $c->product_name ?></label>
                <input type="number" class="form-control mt-2" name="cb[<?= $c->product_name ?>]" id="" value="">
                <?php } ?>
            </div>
        </div>
        <input type="submit" name="cbinv" value="Save" class="btn btn-sm btn-success mb-3">                
    </form>
    <div class="text-center">
            <a class="text-center" href="_keg.php"><button class="btn btn-success btn-sm mx-auto px-3 mb-5">View Current Keg Inventory</button></a>
    </div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
