<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';



$syrCount = $db->query("SELECT * FROM products WHERE product_type = 3 and ACTIVE = 1")->count();

$mills_inv = $db->query("SELECT ip.*, p.product_name
FROM inventory_syrup AS ip
LEFT JOIN products AS p ON ip.syrup_id = p.id
INNER JOIN (
    SELECT syrup_id, MAX(entry_date) AS max_entry_date
    FROM inventory_syrup
    WHERE store_id = 2
    GROUP BY syrup_id
) AS latest_entries ON ip.syrup_id = latest_entries.syrup_id
WHERE ip.entry_date = latest_entries.max_entry_date
AND p.active = 1
ORDER BY ip.syrup_id
LIMIT $syrCount")->results(); 

$ee_inv = $db->query("SELECT ip.*, p.product_name
FROM inventory_syrup AS ip
LEFT JOIN products AS p ON ip.syrup_id = p.id
INNER JOIN (
    SELECT syrup_id, MAX(entry_date) AS max_entry_date
    FROM inventory_syrup
    WHERE store_id = 1
    GROUP BY syrup_id
) AS latest_entries ON ip.syrup_id = latest_entries.syrup_id
WHERE ip.entry_date = latest_entries.max_entry_date
AND p.active = 1
ORDER BY ip.syrup_id
LIMIT $syrCount")->results();

$ucf_inv = $db->query("SELECT ip.*, p.product_name
FROM inventory_syrup AS ip
LEFT JOIN products AS p ON ip.syrup_id = p.id
INNER JOIN (
    SELECT syrup_id, MAX(entry_date) AS max_entry_date
    FROM inventory_syrup
    WHERE store_id = 3
    GROUP BY syrup_id
) AS latest_entries ON ip.syrup_id = latest_entries.syrup_id
WHERE ip.entry_date = latest_entries.max_entry_date
AND p.active = 1
ORDER BY ip.syrup_id
LIMIT $syrCount")->results();

$store_par = $db->query("SELECT pp.*, p.* FROM product_par as pp
LEFT OUTER JOIN products as p
ON pp.product_id=p.id
WHERE pp.product_type = 3 AND active = 1
")->results();

function parseUnit($value){
    switch ($value) {
        case '1':
            echo "Gal.";
            break;
        case '2':
            echo "Toddy";
            break;
        case '3':
            echo "Ctr.";
            break;
        default:
            echo "no unit given";
            break;
    }
}


$shop = $db->query("SELECT * FROM shops")->results();




function cleanDate($val) {
   $newDate = new DateTime($val);
   $strip = $newDate->format('D: m/j - g:i a');
   return $strip;
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
        <h4 class="mb-2 me-2">View/Hide Syrup Par:</h4>  
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
      var nums = [1, 2, 3, 4]
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
