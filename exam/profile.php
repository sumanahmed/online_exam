<?php include 'inc/header.php'; ?>
<?php 
	Session::checkSession();
	$userid = Session::get("userid");
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$updateUsr = $usr->updateUserData($userid, $_POST);
}
?>
<div class="main">
<h1>Your Profile</h1>	
	<div class="profile">
	<?php if(isset($updateUsr)) {echo $updateUsr; } ?>
		<form action="" method="post">
		<?php
			$getData = $usr->getUserData($userid);
			if ($getData) {
				$result = $getData->fetch_assoc();			
		?>
			<table class="tbl">    
				<tr>
				   <td>Name</td>
				   <td><input type="text" name="name" value="<?php echo $result['name']; ?>" /></td>
				</tr>    
				<tr>
				   <td>Username</td>
				   <td><input type="text" name="username" value="<?php echo $result['username']; ?>" /></td>
				</tr>    
				<tr>
				   <td>Email</td>
				   <td><input type="text" name="email" value="<?php echo $result['email']; ?>" /></td>
				</tr>

				<tr>
				  <td></td>
				  <td><input type="submit" name="" value="Update"></td>
				</tr>
	       </table>
	    <?php } ?>
		</form>	
	</div>
	  
</div>
<?php include 'inc/footer.php'; ?> 