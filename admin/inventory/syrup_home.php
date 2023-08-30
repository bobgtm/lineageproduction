<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

function getsyr() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_type = 3 AND active = 1")->results();
    
    return $res;
}

$units = $db->query("SELECT * FROM unit_types")->results();

$details = $user->data()->permissions;

// Grabs Par Information from form
if(!empty($_POST['syrpar'])){
    echo "This one is submitted";
    $storeid = Input::get('location');
    $fields = [
     'store_id' => $storeid
    ];
    $syrups = Input::get('spar');
   
    $vals = Input::get('valpar');
    // dump($syrups);
    // dump($vals);
    $check = $db->query("SELECT * FROM product_par WHERE store_id = ? AND product_type = ?", [$storeid, 3])->count();
    // dump($check);
    if($check < 1) {
        foreach($syrups as $k => $v){
            foreach($vals as $t => $u){
                if ($k == $t){
                    
                    $fields = [
                        'product_id' => $k,
                        'par' => $v,
                        'unit_id' => $u,
                        'store_id' => Input::get('location'),
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
        // dnd($ids);
        foreach($ids as $i => $par) {
            $db->delete("product_par", ["and", ["product_id", "=", $i], ["store_id", "=", $storeid]]);   
        }
        foreach($syrups as $k => $v){
            foreach($vals as $t => $u){
                if ($k == $t){
                    
                    $fields = [
                        'product_id' => $k,
                        'par' => $v,
                        'unit_id' => $u,
                        'store_id' => Input::get('location'),
                        'product_type' => 3,
                    ];
                    
                    $db->insert('product_par', $fields);            
                }
            }
        }
        usSuccess("Syrup Par Updated");
    }
}

if(!empty($_POST['syrinv'])){
    
   $syrups = Input::get('sinv');
   
   $vals = Input::get('val');
    foreach($syrups as $k => $v){
        foreach($vals as $t => $u){
            if ($k == $t){
                
                $fields = [
                    'syrup_id' => $k,
                    'quantity' => $v,
                    'unit_id' => $u,
                    'entry_date' => date('Y-m-d'),
                    'store_id' => Input::get('location')
                ];

                $db->insert('inventory_syrup', $fields);            
            }
        }
    }
   

    
    
    
    usSuccess("Inventory Saved");
}
?>


<div class="row row-cols-2 d-flex flex-row justify-content-center mx-3 mt-3">
    <div class="col col-sm-12 col-md-8 col-lg-4 mx-auto text-center">    
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
                $syr = getsyr(); 
                foreach($syr as $s) { ?>
                <label for="syr" class="mt-3 fw-bold"><?= $s->product_name ?></label>
                <div class="row row-cols-2">
                    <div class="col"><input type="number" class="form-control mt-2" name="sinv[<?= $s->id ?>]" id="" value=""></div>
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
    <?php if((isset($user) && $user->isLoggedIn()) && $user->data()->id == 1 || $user->data()->id == 6) { ?>
    <div class="col col-sm-12 col-md-8 col-lg-4 mx-auto text-center">
        <form  action="" method="post">
            <h4 class="text-center">Syrup Par</h4>
                
            <div class="form-group">
                <label for="" class="form-label">Shop Location</label>
                <select name="location" class="form-select mb-1" id="" required>
                    <option selected disabled value="">Set Syrups Par For...</option>
                    <option value="1">East End</option>
                    <option value="2">Mills</option>
                    <option value="3">UCF</option>
                </select>
            </div>
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
    <?php } ?>
    
</div>
<div class="text-center">
        <a class="text-center mx-auto" href="_syrups.php"><button class="btn btn-success btn-sm px-3 mt-3 mb-5">View Current Syrup Inventory</button></a>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
