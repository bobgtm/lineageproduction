<?php 
$user_id = $user->data()->id;
?>

    <div class="d-flex justify-content-center flex-lg-row flex-md-row flex-column p-0 ">
        <a href="<?= $us_url_root?>admin/home.php" class="btn btn-primary m-2">Home Page</a>
        <a href="<?= $us_url_root?>admin/inventory/keg_home.php" class="btn btn-primary m-2">Keg Form</a>
        <a href="<?= $us_url_root?>admin/inventory/coffee_home.php" class="btn btn-primary m-2">Coffee Form</a>
        <a href="<?= $us_url_root?>admin/inventory/syrup_home.php" class="btn btn-primary m-2">Syrup Form</a>
        <a href="<?= $us_url_root?>admin/inventory/pastry_home.php" class="btn btn-primary m-2">Pastry Form</a>
        <?php if($user_id == 9 || $user_id == 1 || $user_id == 12) { ?>
            <a href="<?= $us_url_root?>admin/inventory/ict_home.php" class="btn btn-primary m-2">ICT Form</a>
        <?php } ?>
    </div>
