<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$cb_stock = $db->query("SELECT * FROM inventory_cold_brew_entry WHERE entry_date > CURDATE() - INTERVAL 1 WEEK ORDER BY entry_date DESC")->results();
// offset date

$shop = $db->query("SELECT * FROM shops")->results();

$par = $db->query("SELECT pp.*, p.* FROM products as p
RIGHT OUTER JOIN product_par as pp on pp.product_id=p.id
WHERE pp.product_type = 2 AND p.active = 1
ORDER BY p.id ASC")->results();

$rec = $db->query("SELECT * from shops RIGHT JOIN inventory_cold_brew_entry as icbe ON shops.id = icbe.store_id")->results();


function cleanDate($val) {
   $newDate = new DateTime($val);
   $strip = $newDate->format('l: m/j');
   return $strip;
}
$from = Input::get('from');
$to = Input::get('to');
$searched = false;

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
        <div class="card-body">
        <table class="table table-light table-sm"> 
            <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col" class="">CB Black</th>
                    <th scope="col" class="">CB White</th>
                    <th scope="col" class="">CB Vegan</th>
                </tr>
            </thead>

            <tbody class="table-striped mb-3 ">
                <?php foreach($cb_stock as $q => $r) { ?>
                    <?php if ($s->id == $r->store_id) { ?>
                    <tr class="">
                        <td class="" scope="" ><?= cleanDate($r->entry_date) ?></td>
                        <td class=""><?= $r->cbb_stock?></td>
                        <td class=""><?= $r->cbw_stock?></td>
                        <td class=""><?= $r->cbv_stock?></td>
                    </tr>
                <?php } ?>
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
                        
                        <?php if($s->id == $p->store_id && ($p->product_id >= 4 && $p->product_id <=6)) { ?>
                            <th span="col"><?= $p->product_name ?></th>
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
    <?php require_once $abs_us_root.$us_url_root."views/menu_foot.php" ?>
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
