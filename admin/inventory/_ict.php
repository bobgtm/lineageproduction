<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

// $shop = $db->query("SELECT * FROM shops")->results();


// ! Probably set up the query so that a date can be selected, otherwise the default date should be shown.
// $ictCount = $db->query("SELECT iie.*, ip.* FROM ict_inventory_entry AS iie
// LEFT JOIN ict_products AS ip
// ON ip.id=iie.product_id
// ")->results();

$ictCount = $db->query("SELECT ie.*, ip.*, ut.*
FROM ict_inventory_entry ie
JOIN (
    SELECT product_id, MAX(entry_date) AS max_entry_date
    FROM ict_inventory_entry
    GROUP BY product_id
) AS latest_entries
ON ie.product_id = latest_entries.product_id
AND ie.entry_date = latest_entries.max_entry_date
LEFT JOIN ict_products AS ip
ON ip.id=ie.product_id
LEFT JOIN unit_types AS ut
ON ut.id = ie.unit_id
ORDER BY ie.product_id
")->results();

$ict_par = $db->query("SELECT ipp.*, ip.product_name FROM 
ict_product_par AS ipp
RIGHT JOIN ict_products AS ip
ON ip.id = ipp.product_id
ORDER BY ip.id ASC
")->results();

$ict_unit = $db->query("SELECT * FROM 
unit_types
")->results();

function parseUnit($value){
    global $ict_unit;
    foreach($ict_unit as $u) {
        if($u->id == $value) {
            echo $u->unit_name;
        }
    }
}


function cleanDate($val) {
    $newDate = new DateTime($val);
    $strip = $newDate->format('D: m/j');
    return $strip;
 }

?>
    <div class="card mb-3 mt-3" id="">
        <div id="" class="card-header">
            <h3 id="">Quantity Requested</h3>
        </div>
        <div class="card-body">
            <table class="table" >
                <thead>
                    <tr>
                        <th>Entry Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ictCount as $c) {
                        if ($c->qty == "") {
                            $c->qty = 0;
                        }?>
                    <tr>    
                        <td><?= cleanDate($c->entry_date) ?> </td>
                        <td><?= $c->product_name ?> </td>
                        <td><?= $c->qty . " " . $c->unit_name ?></td>
                        <td><?php if($c->notes != ""){
                            echo $c->notes;
                        } else {
                            echo "---";
                        }?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-evenly mt-4">

    <div class="card flex-grow-1 mx-2 my-2">
        <div class="card-header"><h3 class="">ICT Par</h3></div>
        <div class="card-body">
            <table class="table table-sm ">
                <thead class="">
                    <tr>
                        <th>Product</th>
                        <th>Par Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach($ict_par as $p){ ?>
                        <tr>
                            <td scope="" class=""><?=$p->product_name ?></td>
                            <td scope="">
                                <div>
                                <span><?=$p->quantity . "  " ?><?= parseUnit($p->unit_id)?></span>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>    
                </table>
            </div>
    </div>

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

</script>
