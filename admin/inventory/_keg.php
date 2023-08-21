<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$cb_stock = $db->query("SELECT * FROM inventory_cold_brew_entry WHERE entry_date > CURDATE() - INTERVAL 1 WEEK ORDER BY entry_date DESC")->results();
// offset date

$shop = $db->query("SELECT * FROM shops")->results();



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
        
            <button id="show1" class="btn btn-primary me-2">East End</button>
            <button id="show2" class="btn btn-primary me-2">Mills</button>
            <button id="show3" class="btn btn-primary me-2">UCF</button>
        </div>
    </div>
</div>
<!-- <div class="row col-lg-12 mt-1 mb-3">
   <p class="fw-bold mb-1">Filter entries by date</p>
   <form class="mt-0" action="" method="get">
      <div class="row col-lg-5 col-sm-4">
         <div class="col col-lg-5">
            <label class="form-label" for="from">From:</label>
            <input type="date" name="from" value="<?= $from ?>">
         </div>    
         <div class="col col-lg-5">
            <label class="form-label" for="to">To:</label>
            <input type="date" name="to" value="<?= $to ?>">
         </div>
      </div>
      <div class="row d-flex mt-1">
         <div class="col col-lg-2"><input type="submit" name="filter" value="Filter" class="text-center btn btn-primary"></div>
         <div class="col col-lg-2"><input type="submit" name="clear" value="Clear Filter" class="btn btn-primary"></div>
      </div>
   </form>
</div> -->


<?php foreach($shop as $s) { ?>
   <div class="table-responsive mt-4">
    <h3 id="shopName<?= $s->id?>"  class="vertical-align-center"><?= $s->name ?></h3>
    <table id="tab<?= $s->id?>"  class="table table-striped table-light table-sm table-bordered table-hover align-middle"> 
        <thead>
            <tr>
                <th>Date</th>
                <th class="p-0 text-center">CB Black</th>
                <th class="p-0 text-center">CB White</th>
                <th class="p-0 text-center">CB Vegan</th>
            </tr>
        </thead>

        <tbody class="table-striped mb-3 align-middle">
            <?php foreach($cb_stock as $q => $r) { ?>
                <?php if ($s->id == $r->store_id) { ?>
                <tr class="">
                    <td class="" scope="row" ><?= cleanDate($r->entry_date) ?></td>
                    <td class="p-0 text-center"><?= $r->cbb_stock?></td>
                    <td class="p-0 text-center"><?= $r->cbw_stock?></td>
                    <td class="p-0 text-center"><?= $r->cbv_stock?></td>
                </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
<div class="row mt-4 mb-4">
    <div class="text-center ">
        <a href="../inventory/keg_home.php" class="btn btn-primary">Back to Keg Form</a>
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

</script>
