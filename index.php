<?php
if(file_exists("install/index.php")){
	//perform redirect if installer files exist
	//this if{} block may be deleted once installed
	header("Location: install/index.php");
}

require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(isset($user) && $user->isLoggedIn()){
}
?>
		<div class="jumbotron">
			
			<p align="center">
				<?php
				if($user->isLoggedIn()){
                    Redirect::to($us_url_root . "admin/home.php") ?>
                <?php } else{ ?>
					<a class="btn btn-primary mt-5" href="users/login.php" role="button"><?=lang("SIGNIN_TEXT");?> &raquo;</a>
					
				<?php }?>
			</p>
			<br>
			
			
		</div>
<?php  languageSwitcher();?>


<!-- Place any per-page javascript here -->
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
