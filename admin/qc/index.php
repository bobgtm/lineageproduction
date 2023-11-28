<?php
require_once '../../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';

$defaultDate = date("Y-m-d");
$coffees = $db->query("SELECT * FROM products WHERE product_type = 1 AND active = 1 AND product_name NOT IN ('431', 'Modern American', 'Select Decaf')")->results();
$origins = $db->query("SELECT * FROM coffee_origins")->results();

$fields = [];
if(isset($_POST['submit'])){
   $fields = [
      'date' => date("Y-m-d H:i:s"),
      'shop_id' => Input::get('location'),
      'batch_origin' => Input::get('batch_origin'),
      'batch_notes' => Input::get('batch_notes'),
      'so_bean'  => Input::get('so_bean'),
      'soe_bean'  => Input::get('soe_bean'),
      'sob_name' => Input::get('sob_name'),
      'sob_origin' => Input::get('sob_origin'),
      'ma_origin' => Input::get('ma_origin'),
      'cbv_qual' => Input::get('cbv_qual'),
      'cbv_notes' => Input::get('cbvPoor'),
      'cbw_qual' => Input::get('cbw_qual'),
      'cbw_notes' => Input::get('cbwPoor'),
      'cbb_qual' => Input::get('cbb_qual'),
      'cbb_notes' => Input::get('cbbPoor'),
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
    dump($fields);
//    $db->insert('entries', $fields);    
   usSuccess("Notes Noted");
	// Redirect::to("qc_recs.php");
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
            <div class="card shadow-sm py-lg-0 py-md-3 py-0">
                <div class="card-body">
                    <div class="row justify-content-md-center">
                        <div class="col-2 my-0"><label for="date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">431°</p> </label></div>
                        <div class="col-10"><input name="batch_date"  type="date" class="form-control" id="date" value="<?= $defaultDate ?>"/></div>
                    </div>
                    <div class="row">
                        <div class="col mt-2">
                            <select name="batch_origin" id="" class="form-select">
                                <option value="" >Origin...</option>
                                <?php foreach($origins as $o): ?>
                                    <option value=""><?= $o->origin_location ?></option>
                                <?php endforeach ?>
                            </select>
                            <!-- <input name="batch_notes" type="text" class="form-control mt-2" id="validationCustom02" placeholder="what are you tasting?" required>   -->
                            <select name="batch_notes" class="form-select mt-2" id="" required>
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
        <div class="col-sm-12 col-md-7 mx-0 px-0">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row justify-content-md-center align-middle">
                        <div class="col-4 my-0 mx-0 pe-0"><label for="sob_date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">S.O. Batch</p> </label></div>
                        <div class="col-8 mx-0 ps-0"><input name="sob_date" type="date" class="form-control" id="date" value="<?= $defaultDate ?>"/></div>
                    </div>
                    <select name="sob_name" id="" class="form-select mt-2">
                            <option value="">What's on?</option>
                        <?php foreach ($coffees as $c) { ?> 
                            <option value="<?= $c->product_name ?>"><?= $c->product_name ?></option>
                        <?php } ?>
                    </select>
                    <!-- <input name="sob_name" type="text" class="form-control mt-2" id="validationCustom02" placeholder="Name" required>   -->
                    <!-- <input name="sob_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>   -->
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
        <div class="col mx-ms-0 me-md-2 px-0 mb-2">
            <div class="card shadow-sm ">
                <div class="card-body">
                    <div class="row justify-content-md-evenly mb-2">
                        <div class="col-4 col-lg-3 col-sm-3 my-0"><label for="date" class="form-label my-0"><p class="my-1">M.A. Espresso</p> </label></div>
                        <div class="col-8 col-lg-9 col-sm-9"><input name="ma_date"  type="date" class="form-control" id="date" value="<?= $defaultDate ?>"/></div>
                    </div>
                    
                    <div class="col">
                        <!-- <input name="ma_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>   -->
                        <select name="batch_origin" id="" class="form-select">
                                <option value="" >Origin...</option>
                                <?php foreach($origins as $o): ?>
                                    <option value=""><?= $o->origin_location ?></option>
                                <?php endforeach ?>
                            </select>
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
                <div class="card-body ">
                    <div class="row justify-content-md-center align-middle">
                        <div class="col-4 my-0"><label for="date" class="form-label align-middle my-0"><p class="align-middle mb-0 mt-1">S.O. Espresso</p> </label></div>
                        <div class="col-8 my-0"><input name="soe_date"  type="date" class="form-control" id="date" value="<?= $defaultDate ?>"/></div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <select name="soe_name" id="" class="form-select mt-2">
                                <option selected disabled value="">What's on? </option>
                            <?php foreach ($coffees as $c) { ?> 
                                <option value="<?= $c->product_name ?>"><?= $c->product_name ?></option>
                            <?php } ?>
                            </select>
                            <!-- <input name="soe_name" type="text" class="form-control mt-2" id="validationCustom02" placeholder="Name" required>  
                            <input name="soe_origin" type="text" class="form-control mt-2" id="validationCustom02" placeholder="origin" required>   -->
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
      

      
      
     
    <div class="row mt-2 mx-1">
        <div class="card px-0 shadow-sm">
            <div class="card-body">
                <div class="row mt-2 vertical-align-center">
                    <div class="col-4 align-middle my-0"><label for="date" class="form-label align-middle my-0">CB Black</label></div>
                    <div class="col-8">
                        <select name="cbb_qual" class="form-select" id="cbb_qual">
                        <option value="good">Good</option>
                        <option value="poor">Poor</option>
                        </select>
                        <div class="d-flex flex-column">
                        <input style="display: none;" name="cbb_date"  type="date" class="form-control mt-2 cbb_date" id="date" disabled value="<?= $defaultDate ?>">
                        <input style="display: none" name="cbbPoor" type="text" class="form-control mt-2 cbbPoor" id="validationCustom02" placeholder="CBB Notes">     
                        </div>
                        
                    </div>
                    
                </div>
                <div class="row mt-2 vertical-align-center">
                    <div class="col-4 align-middle my-0"><label for="date" class="form-label align-middle my-0">CB White</label></div>
                    <div class="col-8">
                        <select name="cbw_qual" class="form-select" id="cbw_qual">
                        <option value="good">Good</option>
                        <option value="poor">Poor</option>
                        </select>
                        <div class="d-flex flex-column">
                            <input style="display: none;" name="cbw_date"  type="date" class="form-control mt-2 cbw_date" id="date" disabled value="<?= $defaultDate ?>">
                            <input style="display: none" name="cbwPoor" type="text" class="form-control mt-2 cbwPoor" id="validationCustom02" placeholder="CBW Notes" > 
                        </div>
                    </div>
                    
                </div>
                <div class="row mt-2 vertical-align-center">
                    <div class="col-4 align-middle my-0"><label for="date" class="form-label align-middle my-0">CB Vegan</label></div>
                    <div class="col-8 cbvp">
                        <select name="cbv_qual" class="form-select" id="cbv_qual">
                            <option value="good">Good</option>
                            <option value="poor">Poor</option>
                        </select>
                        <div class="d-flex flex-column">
                            <input style="display: none;" name="cbv_date"  type="date" class="form-control mt-2 cbv_date" id="date" disabled value="<?= $defaultDate ?>">
                            <input style="display: none;" name="cbvPoor" type="text" class="form-control mt-2 cbvPoor" id="validationCustom02" placeholder="CBV Notes" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        

      <div class="d-flex justify-content-evenly mt-4">
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

$(function(){


    $("#cbv_qual").on("change", function() {
        var val = $("#cbv_qual option:selected").text();
        if(val === 'Poor'){
            $(".cbvPoor").show()
            $(".cbv_date").show()
            
            $(".cbvPoor").removeAttr("disabled")
            $(".cbvPoor").attr("required", true)
            
            $(".cbv_date").removeAttr("disabled")
            $(".cbv_date").attr("required", true)
        }
        if(val === 'Good'){
            $(".cbvPoor").hide()
            $(".cbv_date").removeAttr("disabled")
            $(".cbv_date").attr("required", true)
            
            $(".cbvPoor").removeAttr("required")
            $(".cbvPoor").attr("disabled", true)
            $(".cbv_date").removeAttr("required")
            $(".cbv_date").attr("disabled", true)
        }
        
    })
    $("#cbw_qual").on("change", function() {
        var val = $("#cbw_qual option:selected").text();
        if(val === 'Poor'){
            $(".cbwPoor").show()
            $(".cbw_date").show()
            $(".cbwPoor").removeAttr("disabled")
            $(".cbbPoor").attr("required", true)

            $(".cbw_date").removeAttr("disabled")
            $(".cbw_date").attr("required", true)
            }
        if(val === 'Good'){
            $(".cbwPoor").hide()
            $(".cbw_date").hide()
            
            $(".cbwPoor").removeAttr("required")
            $(".cbbPoor").attr("disabled", true)

            $(".cbv_date").removeAttr("required")
            $(".cbv_date").attr("disabled", true)
            }
        
    })
    $("#cbb_qual").on("change", function() {
        var val = $("#cbb_qual option:selected").text();
        if(val === 'Poor'){
            $(".cbbPoor").show()
            $(".cbb_date").show()
            $(".cbbPoor").removeAttr("disabled")
            $(".cbbPoor").attr("required", true)

            $(".cbb_date").removeAttr("disabled")
            $(".cbb_date").attr("required", true)
            }
        if(val === 'Good'){
            $(".cbbPoor").hide()
            $(".cbb_date").hide()
            $(".cbb").hide()
            $(".cbbPoor").attr("disabled", true)
            $(".cbbPoor").removeAttr("required")

            $(".cbv_date").removeAttr("required")
            $(".cbv_date").attr("disabled", true)
            }
        
    })
})
</script>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
