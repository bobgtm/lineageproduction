<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$c = $db->query("SELECT * FROM entries")->results();
$s = $db->query("SELECT * FROM shops")->results();
$rec = $db->query("SELECT * FROM shops RIGHT JOIN entries ON shops.id = entries.shop_id")->results();

function cleanDate($val) {
   $newDate = new DateTime($val);
   $strip = $newDate->format('m/j/Y');
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
      $rec = $dbI->query("SELECT * FROM shops RIGHT JOIN entries ON shops.id = entries.shop_id WHERE DATE(date) >= ? AND DATE(date) <= ?", [$from, $to])->results();
   }
} elseif(!empty($_GET["clear"])){
   $from = "2023-01-01";
   $to = date("Y-m-d");
   Redirect::to('records.php');
}
if($from == "") {
   $from = "2023-01-01";
}
if($to == "") {
   $to = date("Y-m-d");
}
?>



<div class="row my-3">
   <p class="mb-0">View entries:</p>  
   <div class="d-flex mt-1">   
     <button id="show1" class="btn btn-primary me-2">East End</button>
     <button id="show2" class="btn btn-primary me-2">Mills</button>
     <button id="show3" class="btn btn-primary me-2">UCF</button>
   </div>
</div>
<div class="row col-lg-12 mt-1 mb-3">
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
</div>
<div class="col col-lg-2"><a href="index.php" class="btn btn-primary">Back Home</a></div>

<?php foreach($s as $k => $v) { ?>
   <div class="table-responsive">
   <h3 id="shopName<?= $v->id?>" style="display: none" class="vertical-align-center"><?= $v->name ?></h3>
   <table id="tab<?= $v->id?>" style="display: none" class="table table-striped table-light table-sm table-bordered table-hover"> 
   <thead>
      <tr>
         <th rowspan="3">Entry Date</th>
         <th scope="col">431</th>
         <th scope="col">S.O. Batch</th>
         <th scope="col">S.O. Batch Notes</th>
         <th scope="col">MA</th>
         <th scope="col">S.O. Espresso</th>
         <th scope="col">S.O.E. Notes</th>
      </tr>
   </thead>

   <tbody class="table-striped">
      <?php foreach($rec as $q => $r) { ?>
         <?php if ($v->name == $r->name) { ?>
         <tr>
            <td><?= cleanDate($r->date) ?></td>
            <!-- 431 Notes and Date -->
            <td>
               <?= cleanDate($r->batch_date).": ".$r->batch_notes ?>
            </td>
            <!-- Single Orign bean and Date -->
            <td>
               <?= cleanDate($r->so_date).": ".$r->so_bean ?>
            </td>
            <!-- SO Batch Notes -->
            <td><?= $r->so_notes ?></td>
            <td><?= cleanDate($r->ma_date).": ".$r->ma_notes ?></td>
            <td><?= cleanDate($r->soe_date).": ".$r->soe_bean ?></td>
            <td><?= $r->soe_notes ?></td>
         </tr>
      <?php } ?>
      <?php } ?>
   </tbody>
   <thead>
      <tr>
         <th></th>
         <th scope="col">CBB Date</th>
         <th scope="col">CBB Notes</th>
         <th scope="col">CBW Date</th>
         <th scope="col">CBW Notes</th>
         <th scope="col">CBV Date</th>
         <th scope="col">CBV Notes</th>
      </tr>
   </thead>
   <tbody class="table-striped">
      <?php foreach($rec as $q => $r) { ?>
         <?php if ($v->name == $r->name) { ?>
         <tr>
            <td><?= cleanDate($r->date) ?></td>
            <td><?= cleanDate($r->cbb_date) ?></td>
            <td><?= $r->cbb_notes ?></td>
            <td><?= cleanDate($r->cbw_date) ?></td>
            <td><?= $r->cbw_notes ?></td>
            <td><?= cleanDate($r->cbv_date) ?></td>
            <td><?= $r->cbv_notes ?></td>
            
         </tr>
      <?php } ?>
      <?php } ?>
   </tbody>
</table>
</div>
<?php } ?>


<script>
   $(document).ready(function() {
      var nums = [1, 2, 3]
      nums.forEach(num => {
         $("#show" + num).on("click", function(){
            $("#tab" + num).toggle();
            $("#shopName" + num).toggle();
         });
      });
   });

</script>
