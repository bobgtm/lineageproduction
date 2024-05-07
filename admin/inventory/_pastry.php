<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$shop = $db->query("SELECT * FROM shops")->results();

$pastries = $db->query("SELECT * FROM products WHERE product_type = 4 AND active = 1 ORDER BY id ASC")->results();

$dates = $db->query("SELECT * FROM inventory_pastry_entry WHERE entry_date > CURDATE() - INTERVAL 1 WEEK")->results();
$pastry_stock = $db->query("SELECT ip.*, pe.id, p.product_name
FROM inventory_pastry AS ip
LEFT OUTER JOIN products AS p ON ip.product_id = p.id
LEFT OUTER JOIN inventory_pastry_entry as pe ON pe.id=ip.entry_id
WHERE pe.entry_date > CURDATE() - INTERVAL 1 WEEK
ORDER BY ip.product_id")->results();

function cleanDate($val) {
    $newDate = new DateTime($val);
    $strip = $newDate->format('D: m/j g:i a');
    return $strip;
 }
?>



<div class="row my-3">
    <div class="text-center">
        <h4 class="mb-2 me-2">View/Hide Shop Waste for:</h4>  
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
        <div class="card-body table-responsive">
            <table class="table" >
                <thead>
                    <tr>
                        <th>Date</th>
                        <?php foreach($pastries as $p) { ?>
                            <th><?= $p->product_name?></th>
                        <?php } ?>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dates as $date) {
                        if($date->store_id == $s->id ) { ?>
                        <tr class="">
                            <td class="" scope="" ><?= cleanDate($date->entry_date) ?></td>
                            <?php foreach($pastry_stock as $q => $r) { ?>
                                <?php if ($s->id == $r->store_id && ($r->entry_id == $date->id)) { ?>
                                    <td class=""><?= $r->stock?></td>
                            <?php } ?>
                            <?php } ?>
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
