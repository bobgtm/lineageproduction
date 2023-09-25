<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

function getPastry() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_type = 4 AND active = 1 ORDER BY id ASC")->results();
    
    return $res;
}

if(!empty($_POST['pastryInv'])){
    
   $pastryVal = Input::get('pastryI');
   
   
   
    

    foreach($pastryVal as $t => $v){
            
            $fields = [
                'product_id' => $t,
                'stock' => $v,
                'entry_date' => date('Y-m-d H:i:s'),
                'store_id' => Input::get('location')
            ];
            
            $db->insert('inventory_pastry', $fields);            
        }
}

?>


<div class="row row-cols-2 d-flex flex-lg-row flex-column justify-content-center mx-5-lg mx-0 mt-3">
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center mb-5">    
        <form  action="" method="post">
            <h4 class="text-center">Syrup Inventory</h4>
                
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
                
                
            <?php 
                $pastry = getPastry(); 
                foreach($pastry as $p) { ?>
                <label for="syr" class="mt-3 fw-bold"><?= $p->product_name ?></label>
                <div class="row">
                    <div class="col"><input type="number" class="form-control mt-2" name="pastryI[<?= $p->id ?>]" id="" value=""></div>
                </div>
                <?php } ?>
            </div>
            <div class="item ">
                <input type="submit" name="pastryInv" value="Save" class="btn btn btn-success mt-3">
            </div>        
        </form>
    </div>
    
    
    
    
</div>
<div class="text-center">
        <a class="text-center mx-auto" href="_pastry.php"><button class="btn btn-success btn-sm px-3 mt-3 mb-5">View Pastry Waste</button></a>
</div>

<div class="row mt-4 mb-4">
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
</div>

