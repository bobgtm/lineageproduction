<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$shop = $db->query("SELECT * FROM shops")->results();

$coffCount = $db->query("SELECT * FROM products WHERE product_type = 1 AND active = 1")->count();


$coffee_stock = $db->query("WITH RankedEntries AS (
    SELECT
      *,
      ROW_NUMBER() OVER (PARTITION BY store_id, coffee_id ORDER BY entry_date DESC ) AS rn
    FROM
      inventory_coffee
  )
  SELECT
    r.*, p.product_name, p.active
  FROM
    RankedEntries as r
  LEFT OUTER JOIN products as p
  ON r.coffee_id=p.id
  WHERE
    rn = 1
  AND p.active = 1;")->results();

function cleanDate($val) {
    $newDate = new DateTime($val);
    $strip = $newDate->format('D: m/j - g:i a');
    return $strip;
 }
$from = Input::get('from');
$to = Input::get('to');
// $searched = false;
// dump($_GET);
// If the user decides to select a filter
if(!empty($_GET["filter"])){
   if ($from != "" && $to != "") {
      // $searched = true;
      $rec = $dbI->query("SELECT * FROM shops RIGHT JOIN inventory_cold_brew_entry AS icbe ON shops.id = icbe.shop_id WHERE DATE(date) >= ? AND DATE(date) <= ?", [$from, $to])->results();
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
            <button id="show1" class="btn btn-primary me-2">East End</button>
            <button id="show2" class="btn btn-primary me-2">Mills</button>
            <button id="show3" class="btn btn-primary me-2">UCF</button>
        </div>
    </div>
</div>
<?php foreach($shop as $s) { ?>

    <div class="card mb-3" id="tab<?= $s->id?>">
        <div id="" class="card-header">
            <h3 id="shopName<?$s->id?>"><?=$s->name ?></h3>
        </div>
        <div class="card-body">
            <table class="table" >
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Entry Date</th>
                        <th>Retail Bags</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($coffee_stock as $c) { 
                        if($s->id == $c->store_id) { ?>
                    <tr>    
                        <td><?= $c->product_name?> </td>
                        <td><?= cleanDate($c->entry_date) ?> </td>
                        <td><?= $c->stock ?></td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>
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
</script>
