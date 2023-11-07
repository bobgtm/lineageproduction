<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
// if(!(isset($user) && $user->isLoggedIn())){
//    echo "Please Login to view the page";
//    die();
// }
// $defaultDate = date("M d, Y");
// echo $defaultDate;

$fields = [];
if(isset($_POST['submit'])){
   $fields = [
      'date' => date("Y-m-d H:i:s"),
      'shop_id' => Input::get('location'),
      'so_bean'  => Input::get('so_bean'),
      'soe_bean'  => Input::get('soe_bean'),
   ];
   foreach ($_POST as $k => $v) {
      if (str_contains($k, "_date")) {
         // $v = convertDate($v);
         $fields[$k] = $v;
      }  
      if (str_contains($k, "_notes")) {
         $fields[$k] = $v;
      }
   }
   $db->insert('entries', $fields);    
   usSuccess("Notes Noted");
	Redirect::to("qc_recs.php");
}

?>
<div class="row mx-auto mt-3">
   <div class="col-md-12">
      <h3>Lineage Quality Control Form</h3>
   </div>
   <div class="col-lg-12 col-md-12 mt-1">
      <p class="mb-0">This should be filled out daily before the morning shift clocks out. This will help us maintain quality across all shops and determine the source of any issues.</p> 
    </br>  
      <p>Taste each of the prodcuts below and submit any notes about what you are tasting, concerns, etc</p>  
      <p><span style="font-weight: bold;">Note:</span> Date fields below are for roast date or keg date (likely different than today's date which is set by default to allow for easier navigation to the product date)</p>    
   </div>
</div>
<form method="post">
      <!-- Shop location -->
      <div class="row mx-1">
        <div class="card shadow-sm px-0">
            <div class="card-body">
                <label for="" class="card-title form-label ">Shop Location</label>
                <select name="location" class="form-select" id="" required>
                    <option selected disabled value="">Where ya at? </option>
                    <option value="1">East End</option>
                    <option value="2">Mills</option>
                    <option value="3">UCF</option>
                </select>
            </div>
        </div>
      </div>
     
    <div class="row mx-1 mt-2 d-flex justify-content-center align-items-stretch">
        <div class="col mx-ms-0 me-md-2 px-0 mb-2">
            <!--  {property}{sides}-{breakpoint}-{size}  -->
            <div class="card shadow-sm py-lg-3 py-md-3">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-2 my-0"><label for="date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">431°</p> </label></div>
                        <div class="col-10"><input name="batch_date" placeholder="date" type="date" class="form-control" id="date"/></div>
                    </div>
                    <div class="row mb-sm-2">
                        <div class="col mt-2">
                            <input name="batch_notes" type="text" class="form-control my-1" id="validationCustom02" placeholder="how we tasting?" required>  
                            <input name="batch_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-7 mx-0 px-0">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row justify-content-md-center align-middle">
                        <div class="col-4 my-0 mx-0 pe-0"><label for="sob_date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">S.O. Batch</p> </label></div>
                        <div class="col-8 mx-0 ps-0"><input name="sob_date" type="date" class="form-control" id="date" placeholder="<?php echo $defaultDate ?>"/></div>
                    </div>
                    <input name="sob_name" type="text" class="form-control mt-2" id="validationCustom02" placeholder="Name" required>  
                    <input name="sob_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>  
                    <select name="sob_notes" class="form-select mt-2" id="" required>
                        <option selected disabled vale="">What are you tasting?</option>
                        <option value="1">Green/Vegatative</option>
                        <option value="2">Sour/Fermented</option>
                        <option value="3">Fruity</option>
                        <option value="4">Floral</option>
                        <option value="5">Sweet</option>
                        <option value="6">Nutty/Cocoa</option>
                        <option value="7">Spices</option>
                        <option value="8">Roasted</option>
                        <option value="9">Other</option>
                    </select>
                </div>
            </div>
        </div>
    
    </div>
        
    <div class="row mx-1 mt-2 d-flex justify-content-center align-items-stretch">
        <div class="col mx-ms-0 me-md-2 px-0 mb-2 align-self-stretch ">
            <div class="card shadow-sm py-lg-4 py-md-4">
                <div class="card-body pb-3">
                    <div class="row justify-content-md-evenly mb-3">
                        <div class="col-lg-3 col-sm-3 my-0"><label for="date" class="form-label my-0"><p class="my-1">M.A. Espresso</p> </label></div>
                        <div class="col-lg-9 col-sm-9"><input name="ma_date" placeholder="date" type="date" class="form-control" id="date"/></div>
                    </div>
                    
                    <div class="col">
                        <input name="ma_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>  
                        <select name="ma_notes" class="form-select mt-2" id="" required>
                            <option selected disabled vale="">What are you tasting?</option>
                            <option value="1">Green/Vegatative</option>
                            <option value="2">Sour/Fermented</option>
                            <option value="3">Fruity</option>
                            <option value="4">Floral</option>
                            <option value="5">Sweet</option>
                            <option value="6">Nutty/Cocoa</option>
                            <option value="7">Spices</option>
                            <option value="8">Roasted</option>
                            <option value="9">Other</option>
                        </select>
                    </div>
                    
                </div>
            </div>
        </div>        
        <div class="col-sm-12 col-md-7 mx-0 px-0">
            <div class="card shadow-sm px-0">
                <div class="card-body">
                    <div class="row justify-content-md-center align-middle">
                        <div class="col-4 my-0"><label for="date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">S.O. Espresso</p> </label></div>
                        <div class="col-8"><input name="soe_date" placeholder="date" type="date" class="form-control" id="date"/></div>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <input name="soe_name" type="text" class="form-control mt-2" id="validationCustom02" placeholder="Name" required>  
                            <input name="soe_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>  
                            <select name="soe_notes" class="form-select mt-2" id="" required>
                                <option selected disabled vale="">What are you tasting?</option>
                                <option value="1">Green/Vegatative</option>
                                <option value="2">Sour/Fermented</option>
                                <option value="3">Fruity</option>
                                <option value="4">Floral</option>
                                <option value="5">Sweet</option>
                                <option value="6">Nutty/Cocoa</option>
                                <option value="7">Spices</option>
                                <option value="8">Roasted</option>
                                <option value="9">Other</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
      

      
      
     
    <div class="row mt-3 ">
        <div class="card px-0 shadow-sm">
            <div class="card-body">
                <div class="row mt-2 vertical-align-center">
                    <div class="col-4 align-middle my-0"><label for="date" class="form-label align-middle my-0">CB Black</label></div>
                    <div class="col-8">
                        <select name="cbv_qual" class="form-select" id="">
                        <option value="good">Good</option>
                        <option value="good">Poor</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 vertical-align-center">
                    <div class="col-4 align-middle my-0"><label for="date" class="form-label align-middle my-0">CB White</label></div>
                    <div class="col-8">
                        <select name="cbv_qual" class="form-select" id="">
                        <option value="good">Good</option>
                        <option value="good">Poor</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-2 vertical-align-center">
                    <div class="col-4 align-middle my-0"><label for="date" class="form-label align-middle my-0">CB Vegan</label></div>
                    <div class="col-8">
                        <select name="cbv_qual" class="form-select" id="">
                        <option value="good">Good</option>
                        <option value="good">Poor</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

        

      <div class="d-flex justify-content-between mt-4">
         <div class="col-sm-2">
            <button class="btn btn-primary" name="submit" value="submit" type="submit">Submit form</button>
         </div>
         <div class="col-sm-2">
            <a href="qc_recs.php" class="btn btn-primary">View Records</a>
         </div>
      </div>
</form>


<div class="row mb-5">
   
</div>



<!-- Place any per-page javascript here -->
<script>

$(function(){
   let datePicker = ["1", "2", "3", "4", "5", "6", "7"];
   for (i = 0; i <= datePicker.length; i++) {
      $('#datepicker' + datePicker[i]).datepicker();
   }
});

</script>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
