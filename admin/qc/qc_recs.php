<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

if(!(isset($user) && $user->isLoggedIn())){
    echo "Please Login to view the page";
    die();
 }


$c = $db->query("SELECT * FROM entries")->results();
$origins = $db->query("SELECT * FROM coffee_origins")->results();
$notes = $db->query("SELECT * FROM  tasting_notes")->results();

function parseOrigin($val)
{
    global $origins;
    foreach ($origins as $o) {
        if ($o->id == intval($val)) {
            return $o->origin_location;
        }
    }
}

function coffDate($val)
{
    $newDate = new DateTime($val);
    $strip = $newDate->format('M. jS');
    return $strip;
}

function parseNote($val) {
    global $notes;
    foreach($notes as $n) {
        if($n->id == intval($val)) {
            return $n->note;
        }
    }
}

$s = $db->query("SELECT * FROM shops")->results();
$rec = $db->query("SELECT * FROM shops LEFT JOIN entries ON shops.id = entries.shop_id")->results();
// dump ($rec);
function cleanDate($val) {
   $newDate = new DateTime($val);
   $strip = $newDate->format('D: M. j');
   return $strip;
}
// $from = Input::get('from');
// $to = Input::get('to');
// $searched = false;
// dump($_GET);
// If the user decides to select a filter
// if(!empty($_GET["filter"])){
//    if ($from != "" && $to != "") {
//       // $searched = true;
//       $rec = $dbI->query("SELECT * FROM shops RIGHT JOIN entries ON shops.id = entries.shop_id WHERE DATE(date) >= ? AND DATE(date) <= ?", [$from, $to])->results();
//    }
// } elseif(!empty($_GET["clear"])){
//    $from = "2023-01-01";
//    $to = date("Y-m-d");
//    Redirect::to('records.php');
// }
// if($from == "") {
//    $from = "2023-01-01";
// }
// if($to == "") {
//    $to = date("Y-m-d");
// }
?>



<div class="row my-3">
   <p class="mb-0">View entries:</p>  
   <div class="d-flex mt-1">   
     <button id="show1" class="btn btn-primary me-2">East End</button>
     <button id="show2" class="btn btn-primary me-2">Mills</button>
     <button id="show3" class="btn btn-primary me-2">UCF</button>
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
<div class="col col-lg-2"><a href="index.php" class="btn btn-primary">Back To QC Form</a></div>

<?php foreach($s as $k => $v) { ?>
   <div class="table-responsive">
   <h3 id="shopName<?= $v->id?>" style="display: none" class="vertical-align-center mt-2"><?= $v->name ?></h3>
   <div class="card" id="tab<?= $v->id?>" style="display: none"  >
        <div class="card-body" >
            <table class="table table-sm table-striped table-bordered table-responsive"> 
                <thead>
                    <tr>
                        <th rowspan="">Entry Date</th>
                        <th scope="">431</th>
                        <th scope="">SO Batch</th>
                        <th scope="">MA</th>
                        <th scope="">SO Espresso</th>
                        <th scope="">CBB</th>
                        <th scope="">CBW</th>
                        <th scope="">CBV</th>
                    </tr>
                </thead>

                <tbody class="table-striped">
                    <?php foreach($rec as $q => $r) { ?>
                        <?php if ($v->name == $r->name) { ?>
                        <tr>
                            <td><?= cleanDate($r->date) ?></td>
                            <!-- 431 Notes and Date -->
                            <td>
                                <p class="m-0 p-0"><span class="fw-bold">Origin: </span><?= parseOrigin($r->batch_origin)?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Notes: </span><?=  parseNote($r->batch_notes) ?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Date: </span><?= coffDate($r->batch_date)?></p>
                            
                            </td>
                            <!-- Single Orign bean and Date -->
                            <td>
                                <p class="m-0 p-0" > <span class="fw-bold">Coffee: </span><?= $r->sob_origin?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Notes: </span><?=parseNote($r->sob_notes) ?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Date: </span><?=coffDate($r->sob_date) ?></p>
                            </td>
                            <!-- SO Batch Notes -->
                            <td>
                                <p class="m-0 p-0"><span class="fw-bold">Origin: </span><?= parseOrigin($r->ma_origin)?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Notes: </span><?=  parseNote($r->ma_notes) ?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Date: </span><?= coffDate($r->ma_date)?></p>
                            </td>
                            <!-- S0 Espresso -->
                            <td>
                                <p class="m-0 p-0"><span class="fw-bold">Origin: </span><?= $r->soe_origin ?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Notes: </span><?=  parseNote($r->soe_notes) ?></p>
                                <p class="m-0 p-0" ><span class="fw-bold">Date: </span><?= coffDate($r->soe_date)?></p>
                                
                            <td>
                                <p class="m-0 p-0"><?php  echo $r->cbb_qual."</br>"; ?></p>
                                <?php if($r->cbb_qual == 'poor') { ?>
                                    <p class="m-0 p-0"><span class="fw-bold">Notes: </span><?= $r->cbbPoor ?></p>
                                    <p class="m-0 p-0"><span class="fw-bold">Date: </span><?= coffDate($r->cbb_date) ?></p>
                                <?php } ?>
                            </td>
                            <td>
                                 <p class="m-0 p-0"><?php  echo $r->cbw_qual."</br>"; ?></p>
                                <?php if($r->cbw_qual == 'poor') { ?>
                                    <p class="m-0 p-0"><span class="fw-bold">Notes: </span><?= $r->cbwPoor ?></p>
                                    <p class="m-0 p-0"><span class="fw-bold">Date: </span><?= coffDate($r->cbw_date) ?></p>
                                <?php } ?>
                            </td>
                            <td>
                                <p class="m-0 p-0"><?php  echo $r->cbv_qual."</br>"; ?></p>
                                <?php if($r->cbv_qual == 'poor') { ?>
                                    <p class="m-0 p-0"><span class="fw-bold">Notes: </span><?= $r->cbvPoor ?></p>
                                    <p class="m-0 p-0"><span class="fw-bold">Date: </span><?= coffDate($r->cbv_date) ?></p>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
   </div>
   
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
