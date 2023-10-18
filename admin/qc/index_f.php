<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
$currentDate = date('d-m-Y')
?>
<div class="row mx-auto mt-3">
   <div class="col-md-12">
      <h3>Lineage Quality Control Form</h3>
   </div>
   <div class="col-lg-12 col-md-12 mt-1">
      <p class="mb-0">This should be filled out daily before the morning shift clocks out. This will help us maintain quality across all shops and determine the source of any issues.</p>
      <p class="mt-2">Taste each of the prodcuts below and submit any notes about what you are tasting, concerns, etc</p>      
   </div>
</div>


<div class="row">
   <form method="post">
      <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 g-3 mt-2">
         <div class="col">
            <div class="card">
               <div class="card-body">
                  <label for="" class="form-label"><h5>Shop Location</h5></label>
                  <select name="location" class="form-select" id="" required>
                     <option selected disabled value="">Where ya at? </option>
                     <option value="1">East End</option>
                     <option value="2">Mills</option>
                     <option value="3">UCF</option>
                  </select>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card  ">
               <div class="card-body">
                  <h5 class="card-title">431</h5>     
                  <label for="date" class="form-label">Roast Date</label>
                  <input name="batch_date" value="2023-07-01" type="date" class="form-control" id="date"/>
                  
                  <label for="date" class="form-label mt-2">Notes</label>
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
         </div>
         <!-- Start Single Origin Batch -->
         <div class="col">
            <div class="card shadow-sm border-none">
               <div class="card-body">
                  <label for="date" class="form-label"><h5 class="card-title">S.O. Batch</h5></label>     
                  <input name="batch_date" placeholder="date" type="date" class="form-control" id="date"/>
 
                  <select name="so_notes" class="form-select mt-3" id="" required>
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
                  
                  <input name="so_bean" type="text" class="form-control mt-3" id="validationCustom02" placeholder="Origin" required>
               </div>
            </div>
         </div><!-- End Single Origin Batch -->
         
         <!-- Start Modern American -->
         <div class="col">
            <div class="card shadow-sm  ">
               <div class="card-body">
                  <label for="date" class="form-label"><h5 class="card-title">Modern American</h5></label>     
                  <div class="mt-2 col-lg-4 col-md-5">
                     
                        
                     <input name="ma_date" type="date" class="form-control" id="date"/>
                        
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
            </div>
         </div>
         <!-- Start Modern American -->
         <div class="col">
            <div class="card shadow-sm  ">
               <div class="card-body">
               <h5 class="card-title">Card title</h5>
               <p class="card-text">
                  This is a longer card with supporting text below as a natural lead-in to
                  additional content. This content is a little bit longer.
               </p>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card shadow-sm  ">
               <div class="card-body">
               <h5 class="card-title">Card title</h5>
               <p class="card-text">
                  This is a longer card with supporting text below as a natural lead-in to
                  additional content. This content is a little bit longer.
               </p>
               </div>
            </div>
         </div>
         <div class="col">
            <div class="card shadow-sm ">
               <div class="card-body">
               <h5 class="card-title">Card title</h5>
               <p class="card-text">
                  This is a longer card with supporting text below as a natural lead-in to
                  additional content. This content is a little bit longer.
               </p>
               </div>
            </div>
         </div>
      </div>
   </form>
</div>

<style> 
 
body {
   
   background: hsl(36, 28%, 55%);
   background-color: hsl(36, 28%, 55%);
   
   /* background: hsl(39, 74%, 95%);
   background-color: hsl(39, 74%, 95%); */
} 
input {
   background: hsl(39, 74%, 95%);
   background-color: hsl(39, 74%, 95%);
}
label, .card-text {
   /* color: hsl(39, 74%, 95%); */
   color: hsl(36, 28%, 55%);

}
.card {
   background: hsl(39, 74%, 95%);
   background-color: hsl(39, 74%, 95%);
   /* background: hsl(36, 28%, 55%);
   background-color: hsl(36, 28%, 55%); */
   
}
</style>
