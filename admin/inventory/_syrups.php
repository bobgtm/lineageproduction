<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

// $syrup = $db->query("SELECT * FROM inventory_syrup WHERE entry_date > CURDATE() - INTERVAL 1 WEEK ORDER BY entry_date DESC")->results();

$syrCount = $db->query("SELECT * FROM products WHERE product_type = 3 and ACTIVE = 1")->count();

$mills_inv = $db->query("SELECT ip.*, p.product_name  FROM inventory_syrup as ip
LEFT OUTER JOIN products as p
on ip.syrup_id=p.id
WHERE ip.store_id = 1
LIMIT $syrCount
")->results();

$ee_inv = $db->query("SELECT ip.*, p.product_name  FROM inventory_syrup as ip
LEFT OUTER JOIN products as p
on ip.syrup_id=p.id
WHERE ip.store_id = 2
LIMIT $syrCount
")->results();

$ucf_inv = $db->query("SELECT ip.*, p.product_name  FROM inventory_syrup as ip
LEFT OUTER JOIN products as p
on ip.syrup_id=p.id
WHERE ip.store_id = 3
LIMIT $syrCount
")->results();

dump($mills_inv);
dump($db->errorString());
$store_par = $db->query("SELECT pp.*, p.* FROM product_par as pp
LEFT OUTER JOIN products as p
ON pp.product_id=p.id
WHERE pp.product_type = 3 AND active = 1
")->results();




// $syrups_q = $db->query("SELECT t1.*,
// p.id as prod_id, p.product_name,
// pp.par, pp.unit_id as unit
// FROM inventory_syrup t1
// JOIN (
//   SELECT syrup_id, store_id, entry_date, MAX(id) AS max_id
//   FROM (
//     SELECT syrup_id, store_id, entry_date, MAX(entry_date) AS max_date
//     FROM inventory_syrup
//     GROUP BY syrup_id, store_id 
//   ) t2
//   GROUP BY syrup_id, store_id, entry_date
// ) t3
// ON t1.id=t3.max_id
// ")->results();
// dump($db->errorString());




function parseUnit($value){
    switch ($value) {
        case '1':
            echo "Gal.";
            break;
        case '2':
            echo "L";
            break;
        case '3':
            echo "Qt.";
            break;
        case '4':
            echo "C.";
            break;
        case '5':
            echo "Oz.";
            break;
        default:
            echo "no unit supplied";
            break;
    }
}


$shop = $db->query("SELECT * FROM shops")->results();




function cleanDate($val) {
   $newDate = new DateTime($val);
   $strip = $newDate->format('D: m/j');
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
                    <th scope="col">Latest Inventory</th>
                    
                </tr>
            </thead>

            <tbody class="table-striped mb-3 ">
                <?php if($s->id == 1){ ?>
                    <?php foreach($ee_inv as $y){ ?>
                <tr>
                    <td scope="col" class=""><?=$y->product_name?></td>
                    <td scope="col"><?= $y->quantity == "" ? "0 " : $y->quantity . " " ?><?= parseUnit($y->unit_id)?></td>
                    <td scope="col"><?= cleanDate($y->entry_date)?></td>   
                </tr>
                <?php } ?>
                <?php } ?>
                <?php if($s->id == 2){ ?>
                    <?php foreach($mills_inv as $y){ ?>
                <tr>
                    <td scope="col" class=""><?=$y->product_name?></td>
                    <td scope="col"><?= $y->quantity == "" ? "0 " : $y->quantity . " " ?><?= parseUnit($y->unit_id)?></td>
                    <td scope="col"><?= cleanDate($y->entry_date)?></td>   
                </tr>
                <?php } ?>
                <?php } ?>
                <?php if($s->id == 3){ ?>
                    <?php foreach($ucf_inv as $y){ ?>
                <tr>
                    <td scope="col" class=""><?=$y->product_name?></td>
                    <td scope="col"><?= $y->quantity == "" ? "0 " : $y->quantity . " " ?><?= parseUnit($y->unit_id)?></td>
                    <td scope="col"><?= cleanDate($y->entry_date)?></td>   
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
                        <th>Product</th>
                        <th>Par Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($store_par as $p){ ?>
                        <tr>
                            <?php if($s->id == $p->store_id){ ?>
                                <td scope="col" class=""><?=$p->product_name?></td>
                                <td scope="col"><?=$p->par . " " ?><?= parseUnit($p->unit_id)?></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>    
                </table>
            </div>
    </div>
<?php } ?>
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
