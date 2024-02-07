<?php 
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }

function getPastry() {
    global $db;
    
    $res = $db->query("SELECT * FROM products WHERE product_type = 4 AND active = 1 ORDER BY id ASC")->results();
    
    return $res;
}


$uname = $user->data()->fname;
$user_ids = $db->query("SELECT id FROM users")->results();
$store_id = "";
$uid = $user->data()->id;

if($uid ==9) {
    $store_id = 1;
}
if($uid == 5) {
    $store_id = 2;
}
if($uid == 10) {
    $store_id = 3;
}
// dump($db->errorString());
if(!empty($_POST['pastryInv'])){
    
   $pastryVal = Input::get('pastryI');
//    foreach($pastryVal as $t => $v){
//     echo $t . "<br>";
//     if($v == ""){
//         echo "hello<br>";
//     }
//     echo $v . "<br>";
//    }
   
   
   $active = getPastry();
   
   
   
   
  
   $fields2 = [
        'entry_date' => date('Y-m-d H:i:s'),
        'store_id' => $store_id 
    ];
            
    $db->insert('inventory_pastry_entry', $fields2);
    $dbID = $db->lastId();    
    

    foreach($pastryVal as $t => $v){
        // I want to use this to go through the database, check for the most recent entry... delete it, 
        // Then replace it with a new entry that edits the number for the number that needs to be changed. 
        // So far this query just checks for the recent inventory number. 
        $invCheck = $db->query("SELECT ip.*, ie.* FROM inventory_pastry as ip
        LEFT JOIN inventory_pastry_entry as ie
        ON ie.id=ip.entry_id
        WHERE ip.store_id = ?
        AND ip.entry_id = ?
        ORDER BY ie.entry_date DESC", [$store_id, $dbID])->results();
        

        // foreach($invCheck as $invNum) {
        //     for($i = 0; $i < count($active); $i++) {
        //         if($active[$i]->id == $invNum->product_id) {
        //            echo "confirmed<br>";
        //         } else {
        //             echo "unconfrim";
        //         }
                
        //       }      
        // }
            $fields = [
                'product_id' => $t,
                'entry_id' => $dbID,
                'store_id' => $store_id,
                'stock' => $v
            ];
            
            $db->insert('inventory_pastry', $fields);
        
        }
        echo usSuccess("🥐 Waste saved");
}

?>


<div class="row row-cols-2 d-flex flex-lg-row flex-column justify-content-center mx-5-lg mx-0 mt-3">
    <div class="col col-12 col-md-8 col-lg-4 mx-auto text-center mb-3">    
        <form  action="" method="post">
            <h4 class="text-center"><?= ucwords($uname) ?> Pastry Waste Form</h4>
                
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
        <a class="text-center mx-auto" href="_pastry.php"><button class="btn btn-success btn-sm px-3 mt-2 mb-5">View Pastry Waste</button></a>
</div>

<div class="row mt-4 mb-4">
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
</div>

