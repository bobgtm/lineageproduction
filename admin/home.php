<?php 
require_once '../users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';


?>
<!-- <style>
    .btn {
        background-color: yellow;
        border-color: yellow
    }
</style> -->

<div class="row mt-4">
    <div class="d-flex flex-column flex-lg-row justify-content-md-center col-xg-3 col-md-12 col-sm-12 mb-2">
        <div class="text-center mx-1 mb-3">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/inventory/keg_home.php"><button class="btn btn-secondary btn-lg shadow">Keg Inventory</button></a>
        </div>
        <div class="text-center mx-1 mb-3">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/inventory/coffee_home.php"><button class="btn btn-secondary btn-lg shadow">Coffee Retail Inventory</button></a>
        </div>
        <div class="text-center mx-1 mb-3">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/inventory/syrup_home.php"><button class="btn btn-secondary btn-lg shadow">Syrup Inventory</button></a>
        </div>
        
                
   
    </div>
    <div class="d-flex flex-column flex-lg-row justify-content-md-center col-xg-3 col-md-12 col-sm-12 mb-4">       
        <div class="text-center align-self-center mx-1 mb-3">
            <a href="<?=$us_url_root?>admin/inventory/pastry_home.php"><button class="btn btn-secondary btn-lg shadow">Pastry Waste</button></a>
            <h4 class="align-self-center"></h4>
        </div> 
        <div class="text-center align-self-center mx-1 mb-3">
            <a href="<?=$us_url_root?>admin/qc/index.php"><button class="btn btn-secondary btn-lg shadow">Quality Control</button></a>
            
            <h4 class="align-self-center"></h4>
        </div>
        <div class="text-center align-self-center mx-1 mb-3">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/manage_products.php"><button class="btn btn-secondary btn-lg shadow">Manage Products</button></a>
            <h4 class="align-self-center"></h4>
        </div>
    </div>
    <div class="d-flex flex-column flex-lg-row justify-content-md-center col-xg-3 col-md-12 col-sm-12 mb-4">       
        <div class="text-center align-self-center mx-1 mb-3">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/inventory/ict_home.php"><button class="btn btn-secondary btn-lg shadow">EE ICT</button></a>
        </div>
    </div>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
