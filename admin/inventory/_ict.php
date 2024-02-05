<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

// $shop = $db->query("SELECT * FROM shops")->results();

$ictCount = $db->query("SELECT iie.*, ip.* FROM ict_inventory_entry AS iie
RIGHT JOIN ict_products AS ip
ON ip.id=iie.ict_id
")->results();
// dnd($ictCount);


function cleanDate($val) {
    $newDate = new DateTime($val);
    $strip = $newDate->format('D: m/j');
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
    <div class="card mb-3" id="">
        <div id="" class="card-header">
            <h3 id="">Quantity Requested</h3>
        </div>
        <div class="card-body">
            <table class="table" >
                <thead>
                    <tr>
                        <th>Product</th>
                        <!-- <th>Qnty</th> -->
                        <th>Entry Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ictCount as $c) {
                        if ($c->qty == "") {
                            $c->qty = 0;
                        }?>
                    <tr>    
                        <td><?= $c->product_name . ": " . $c->qty ?> </td>
                        <!-- <td><?= $c->qty ?></td> -->
                        <td><?= cleanDate($c->entry_date) ?> </td>
                    </tr>
                    
                    <?php } ?>
                </tbody>
            </table>

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
