<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
// if(!(isset($user) && $user->isLoggedIn())){
//    echo "Please Login to view the page";
//    die();
// }

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
      <p>Taste each of the prodcuts below and submit any notes about what you are tasting, concerns, etc</p>      
   </div>
</div>
<div class="row mx-auto">
    <form method="post">
      <!-- Shop location -->
      <div class="row">
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
     
      <div class="row mt-2 align-items-center">
        <div class="card shadow-sm px-0">
            <div class="card-body">
                <div class="row justify-content-md-center align-middle">
                    <div class="col-2 my-0"><label for="date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">431°</p> </label></div>
                    <div class="col-10"><input name="batch_date" placeholder="date" type="date" class="form-control" id="date"/></div>
                </div>
                <div class="row">
                    <div class="col mt-2">
                        <input name="batch_notes" type="text" class="form-control my-1" id="validationCustom02" placeholder="how we tasting?" required>  
                        <input name="batch_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>  
                    </div>
                </div>
            </div>
        </div>
      </div>
        <!-- SO BATCH -->
    <div class="row align-items-center mt-2">
        <div class="card shadow-sm px-0">
            <div class="card-body">
                <div class="row justify-content-md-center align-middle">
                    <div class="col-4 my-0 mx-0 pe-0"><label for="date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">S.O. Batch</p> </label></div>
                    <div class="col-8 mx-0 ps-0"><input name="so_date" type="date" class="form-control" id="date"/></div>
                    
                </div>
                <input name="batch_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>  
                <select name="so_notes" class="form-select mt-2" id="" required>
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
               <option selected disabled value="">What are you tasting?</option>
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
</div>

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
