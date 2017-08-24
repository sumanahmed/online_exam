<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/inc/header.php');
?>
<?php
  // Session::checkLogin();
?>

<div class="main">
<h1>Admin Panel</h1>
	<div class="adminpanel">
		<h2>Welcome to control Admin Panel</h2>
		<p>You can manage your user and online exam system form here...</p>
	</div>
	
</div>
<?php include 'inc/footer.php'; ?>