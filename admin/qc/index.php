<?php
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(!(isset($user) && $user->isLoggedIn())){
   echo "Please Login to view the page";
   die();
}

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
	Redirect::to("lin");
}

?>
<div class="row mx-auto mt-3">
   <div class="col-md-12">
      <h3>Lineage Quality Control Form</h3>
   </div>
   <div class="col-lg-12 col-md-12 mt-1">
      <p class="mb-0">This should be filled out daily before the morning shift clocks out. This will help us maintain quality across all shops and determine the source of any issues.</p>   
      <p>Taste each of the prodcuts below and submit any notes about what you are tasting, concerns, etc</p>      
   </div>
</div>

<div class="row mb-5">
   <form method="post">
      <!-- Shop location -->
      
      <div class="card col-md-4 shadow-sm  border border-dark border-1 ">
         <div class="card-body">
            <div class="col col-sm-12 col-md-6">
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
      
      
     
      <div class="card border-dark mt-2 col-md-4">

         <div class="card-body">
            <label for="date" class="card-title form-label">431</label>     
            <div class="">
               
               <div class="col col-sm-10">
                  <input name="batch_date" placeholder="date" type="date" class="form-control" id="date"/>
               </div>
            </div>
      
            <div class="col col-sm-12 col-lg-4 mt-2">
               <label for="validationCustom02" class="form-label">431° Notes</label>
               <input name="batch_notes" type="text" class="form-control" id="validationCustom02" placeholder="how we tasting?" required>  
            </div>
         </div>             
      </div>
         
     
      <!-- SO BATCH -->
      <div class="row align-items-center mt-2">
         <div class="mt-2 col-lg-4 col-md-5">
            <label for="date" class="form-label">Single Origin Batch Roast Date</label>
               <!-- <div class="input-group date" id="datepicker2">
                  <span class="input-group-text">
                     <span class="input-group-append">
                        <i class="fa fa-calendar"></i>
                     </span>
                  </span> -->
            <input name="so_date" type="date" class="form-control" id="date"/>
               <!-- </div> -->
         </div>
         <div class="mt-2 col-lg-4 col-md-4">
            <label for="so_notes" class="form-label">S.O. Batch Notes</label>
            <!-- <input name="so_notes" type="text" class="form-control" id="validationCustom02" value="" required> -->
            
            <!-- <label for="" class="form-label">Shop Location</label> -->
            <select name="so_notes" class="form-select" id="" required>
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
         <div class="mt-2 col-lg-4 col-md-3">
            <label for="validationCustom02" class="form-label">S.O. Batch Origin</label>
            <input name="so_bean" type="text" class="form-control" id="validationCustom02" placeholder="ex: Ardi" required>            
         </div>
      </div>
      <!-- MODERN AMERICAN -->
      <div class="row mt-2">
         <div class="mt-2 col-lg-4 col-md-5">
            <label for="date" class="form-label">M.A. Roast Date</label>
               <!-- <div class="input-group date" id="datepicker3">
                  <span class="input-group-text">
                     <span class="input-group-append">
                        <i class="fa fa-calendar"></i>
                     </span>
                  </span> -->
            <input name="ma_date" type="date" class="form-control" id="date"/>
               <!-- </div> -->
         </div>
         <div class="mt-2 col-lg-4 col-md-4">
            <label for="validationCustom03" class="form-label">M.A. Notes</label>
            <!-- <input name="ma_notes" type="text" class="form-control" id="validationCustom03" required> -->
            <select name="so_notes" class="form-select" id="" required>
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
      <!-- SO ESPRESSO -->
      <div class="row align-items-center mt-2">
         <div class="mt-2 col-lg-4 col-md-5">
            <label for="date" class="form-label">S.O. Espresso Roast Date</label>
               <!-- <div class="input-group date" id="datepicker4">
                  <span class="input-group-text">
                     <span class="input-group-append">
                        <i class="fa fa-calendar"></i>
                     </span>
                  </span> -->
            <input name="soe_date" type="date" class="form-control" id="date"/>
               <!-- </div> -->
         </div>
         <div class="mt-2 col-lg-4 col-md-4">
            <label for="validationCustom02" class="form-label">S.O. Espresso Notes</label>
            <input name="soe_notes" type="text" class="form-control" id="validationCustom02" value=" " required>
         </div>
         <div class="mt-2 col-lg-4 col-md-3">
            <label for="validationCustom02" class="form-label">S.O. Espresso Bean</label>
            <input name="soe_bean" type="text" class="form-control" id="validationCustom02" placeholder="ex: Luz Mila" required>            
         </div>
      </div>
      <div class="row mt-2">
         <div class="col-lg-4 col-md-5 mt-2">
            <label for="date" class="form-label">CB Black Keg Date</label>
               <!-- <div class="input-group date" id="datepicker5">
                  <span class="input-group-text">
                     <span class="input-group-append">
                        <i class="fa fa-calendar"></i>
                     </span>
                  </span> -->
            <input name="cbb_date" type="date" class="form-control" id="date"/>
               <!-- </div> -->
         </div>
         <div class="mt-2 col-lg-4 col-md-4">
            <label for="validationCustom02" class="form-label">CB Black Notes</label>
            <input name="cbb_notes" type="text" class="form-control" id="validationCustom02" value=" " required>
         </div>
      </div>
      <div class="row mt-2">
         <div class="mt-2 col-lg-4 col-md-5">
            <label for="date" class="form-label">CB White Keg Date</label>
               <!-- <div class="input-group date" id="datepicker6"> -->
                  <!-- <span class="input-group-text">
                     <span class="input-group-append">
                        <i class="fa fa-calendar"></i>
                     </span>
                  </span> -->
            <input name="cbw_date" type="date" class="form-control" id="date"/>
               <!-- </div> -->
         </div>
         <div class="mt-2 col-lg-4 col-md-4">
            <label for="validationCustom02" class="form-label">CB White Notes</label>
            <input name="cbw_notes" type="text" class="form-control" id="validationCustom02" value=" " required>
         </div>
      </div>
      <div class="row mt-2">
         <div class="mt-2 col-lg-4 col-md-5">
            <label for="date" class="form-label">CB Vegan Keg Date</label>       
            <input name="cbv_date" type="date" class="form-control" id="date"/>
         </div>
         <div class="mt-2 col-lg-4 col-md-4">
            <label for="validationCustom02" class="form-label">CB Vegan Notes</label>
            <input name="cbv_notes" type="text" class="form-control" id="validationCustom02" value=" " required>
         </div>
      </div>
      <div class="d-flex justify-content-between mt-4">
         <div class="col-sm-2">
            <button class="btn btn-primary" name="submit" value="submit" type="submit">Submit form</button>
         </div>
         <div class="col-sm-2">
            <a href="records.php" class="btn btn-primary">View Records</a>
         </div>
      </div>
      
   </form>
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
