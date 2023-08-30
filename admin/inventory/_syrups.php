<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$syrup = $db->query("SELECT * FROM inventory_syrup WHERE entry_date > CURDATE() - INTERVAL 1 WEEK ORDER BY entry_date DESC")->results();

// dump($syrup_stock);
$syrups_q = $db->query("SELECT p.id as product_id, p.product_name, iyp.* FROM products as p  
LEFT OUTER JOIN inventory_syrup AS iyp ON p.id=iyp.syrup_id
WHERE product_type = 3 AND ACTIVE = 1 LIMIT 11")->results();
// dump($syrups);
$shop = $db->query("SELECT * FROM shops")->results();

$par = $db->query("SELECT pp.*, p.* FROM product_par as pp
LEFT OUTER JOIN products as p on pp.product_id=p.id
WHERE pp.product_id BETWEEN 4 AND 6")->results();

$rec = $db->query("SELECT * from shops RIGHT JOIN inventory_cold_brew_entry as icbe ON shops.id = icbe.store_id")->results();


function cleanDate($val) {
   $newDate = new DateTime($val);
   $strip = $newDate->format('l: m/j');
   return $strip;
}
$from = Input::get('from');
$to = Input::get('to');
$searched = false;
dump($_GET);
// If the user decides to select a filter
if(!empty($_GET["filter"])){
   if ($from != "" && $to != "") {
      // $searched = true;
      $rec = $db->query("SELECT * FROM shops RIGHT JOIN inventory_cold_brew_entry AS icbe ON shops.id = icbe.shop_id WHERE DATE(date) >= ? AND DATE(date) <= ?", [$from, $to])->results();
   }
} elseif(!empty($_GET["clear"])){
   $from = "2023-01-01";
   $to = date("D: Y, m");
   Redirect::to('_keg.php');
}
if($from == "") {
   $from = "2023-01-01";
}
if($to == "") {
   $to = date("Y-m-d");
}
?>



<div class="row my-3">
    <div class="text-center">
        <h4 class="mb-2 me-2">View/Hide Inventory:</h4>  
        <div class="d-flex justify-content-center align-items-center mt-1">   
            <button id="show1" class="btn btn-info me-2">East End</button>
            <button id="show2" class="btn btn-warning me-2">Mills</button>
            <button id="show3" class="btn btn-success me-2">UCF</button>
        </div>
    </div>
</div>

<div class="d-flex flex-column flex-md-row justify-content-evenly mt-4">
<?php foreach($shop as $s) { ?>
    <div class="card flex-grow-1 mx-2 my-2"  id="tab<?= $s->id?>">
        <div class="card-header"><h3 id="shopName<?= $s->id?>"  class=""><?= $s->name ?></h3></div>
        <div class="card-body table-responsive">
        <table class="table table-light table-striped table-sm"> 
            <thead>
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Quantity</th>
                </tr>
            </thead>

            <tbody class="table-striped mb-3 ">
                <?php foreach($syrups_q as $y){ ?>
                <tr>
                    <?php if($s->id == $y->store_id){ ?>
                        <td scope="col" class=""><?=$y->product_name?></td>
                        <td><?=$y->quantity?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                
            </tbody>
        </table>
        </div>
    </div>
<?php } ?>
</div>


<div class="row my-3">
    <div class="text-center">
        <h4 class="mb-2 me-2">View/Hide Cold Brew Par:</h4>  
        <div class="d-flex justify-content-center align-items-center mt-1">   
            <button id="sh1" class="btn btn-info me-2">East End</button>
            <button id="sh2" class="btn btn-warning me-2">Mills</button>
            <button id="sh3" class="btn btn-success me-2">UCF</button>
        </div>
    </div>
</div>
<div class="d-flex flex-column flex-md-row justify-content-evenly mt-4">
<?php foreach($shop as $s) { ?>
    <div class="card flex-grow-1 mx-2 my-2"  id="partab<?= $s->id?>">
        <div class="card-header"><h3 id="parName<?= $s->id?>"  class=""><?= $s->name ?></h3></div>
        <div class="card-body">
            <table class="table table-sm text-center">
                <thead class="text-centered">
                    <tr>
                    <?php foreach ($par as $p) { ?>
                        
                        <?php if($s->id == $p->store_id && ($p->product_id >= 4 && $p->product_id <=6)) {?>
                            <th><?= $p->product_name ?></th>
                        <?php } ?>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach ($par as $p) { ?>
                        
                        <?php if($s->id == $p->store_id && ($p->product_id >= 4 && $p->product_id <=6)) {?>
                            <td><?= $p->par ?></td>
                        <?php } ?>
                        <?php } ?>
                        </tr>
                    </tbody>    
                </table>
            </div>
    </div>
<?php } ?>
</div>

<div class="row mt-4 mb-4">
    <div class="text-center ">
        <a href="<?php $us_url_root?>/inventory/keg_home.php" class="btn btn-primary">Back to Keg Form</a>
    </div>
    <div class="d-flex justify-content-center flex-lg-row flex-sm-column p-0">
        <a href="<?= $us_url_root?>admin/home.php" class="btn btn-primary m-2">Back to Home Page</a>
        <a href="<?= $us_url_root?>admin/inventory/coffee_home.php" class="btn btn-primary m-2">View Coffee Form</a>
    </div>
</div>


<script>
   $(document).ready(function() {
      var nums = [1, 2, 3]
      htmlContent = "style=display: none;"
      nums.forEach(num => {
         $("#show" + num).on("click", function(){
            $("#tab" + num).toggle(300, 'linear');
            $("#shopName" + num).toggle(300, 'linear');
         });
      });
   });

   $(document).ready(function() {
      var nums = [1, 2, 3]
      htmlContent = "style=display: none;"
      nums.forEach(num => {
         $("#sh" + num).on("click", function(){
            $("#partab" + num).toggle(300, 'linear');
            $("#parName" + num).toggle(300, 'linear');
         });
      });
   });

</script>

<?php require_once $abs_us_root . $us_url_root .'views/menu_foot.php'; ?>