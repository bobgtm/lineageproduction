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
<div class="row text-center my-4">
    <p>Home page for all of our mini-apps</p>
</div>
<div class="row">
    <div class="col col-xg-3 col-md-12 col-sm-12 mb-4">

        <div class="text-center align-self-center mb-5">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/inventory/keg_home.php"><button class="btn btn-secondary btn-lg shadow">Keg Inventory</button></a>
            <h4 class="align-self-center"></h4>
        </div>
        <div class="text-center align-self-center mb-5">
            <a class="text-bg-primary-emphasis" href="<?=$us_url_root?>admin/inventory/coffee_home.php"><button class="btn btn-secondary btn-lg shadow">Coffee Retail Inventory</button></a>
            <h4 class="align-self-center"></h4>
        </div>
        <div class="text-center align-self-center mb-5">
            <a href="<?=$us_url_root?>admin/inventory/home.php"><button class="btn btn-secondary btn-lg shadow">Pastry Waste</button></a>
            <h4 class="align-self-center"></h4>
        </div> 
        <div class="text-center align-self-center mb-5">
            <a href="<?=$us_url_root?>admin/inventory/home.php"><button class="btn btn-secondary btn-lg shadow">Quality Control</button></a>
            <h4 class="align-self-center"></h4>
        </div>
                
   
    </div>
</div>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
