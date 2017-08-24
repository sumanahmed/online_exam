<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Session.php');
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

class User{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function userRegistration($name, $username, $password, $email){
		$name     = $this->fm->validation(mysqli_real_escape_string($this->db->link, $name));
		$username = $this->fm->validation(mysqli_real_escape_string($this->db->link, $username));
		$email    = $this->fm->validation(mysqli_real_escape_string($this->db->link, $email));
		if ($name == "" || $username == "" || $password == "" || $email == "") {
			echo "<span class='error'>"."Fields Must not be Empty !"."</span>";			
		}else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				echo "<span class='error'>"."Invalid Email address !"."</span>";
		}else{
			$chkQuery = "SELECT * FROM tbl_user WHERE email='$email'";
			$chkResult = $this->db->select($chkQuery);
			if ($chkResult != false) {
				echo "<span class='error'>"."Email address Already Exst !"."</span>";
			}else{
				$password = $this->fm->validation(mysqli_real_escape_string($this->db->link, md5($password)));

				$query = "INSERT INTO tbl_user(name, username, password, email) VALUES('$name', '$username', '$password', '$email')";
				$insert_row = $this->db->insert($query);
				if ($insert_row) {
					echo "<span class='success'>"."Registration Successfuly."."</span>";
					exit();
				}else{
					echo "<span class='error'>"."Error.. Not Register !"."</span>";
					exit();
				}		
			}
		}
	}

	public function userLogin($email, $password){
		$email    = $this->fm->validation(mysqli_real_escape_string($this->db->link, $email));	
		if ( $email == "" || $password == "" ) {
			echo "empty";		
			exit();	
		}else{

			$password = $this->fm->validation(mysqli_real_escape_string($this->db->link, md5($password)));
			$query = "SELECT * FROM tbl_user WHERE email='$email' AND password='$password'";
			$result = $this->db->select($query);	
			if ($result != false) {
				$value = $result->fetch_assoc();
				if ($value['status'] == '1') {
					echo "disabled";
					exit();
				} else {
					Session::init();
					Session::set("login", true);
					Session::set("userid", $value['userid']);
					Session::set("username", $value['username']);
					Session::set("name", $value['name']);
				}
			}else{
				echo "error";
				exit();
			}
		}
	}

	public function getUserData($userid){
		$query = "SELECT * FROM tbl_user WHERE userid = '$userid' ";
		$result = $this->db->select($query);
		return $result;
	}

	public function getAllUser(){
		$query = "SELECT * FROM tbl_user ORDER BY userid DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function updateUserData($userid, $data){
		$name     = $this->fm->validation(mysqli_real_escape_string($this->db->link, $data['name']));
		$username = $this->fm->validation(mysqli_real_escape_string($this->db->link, $data['username']));
		$email    = $this->fm->validation(mysqli_real_escape_string($this->db->link, $data['email']));
		if ($name == "" || $username == "" || $email == "") {
			echo "<span class='error'>"."Fields Must not be Empty !"."</span>";			
		}else if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				echo "<span class='error'>"."Invalid Email address !"."</span>";
		}else{
			$query = "UPDATE tbl_user SET name='$name', username='$username', email='$email' WHERE userid='$userid'";
			$updated_row = $this->db->update($query);
			if ($updated_row) {
				echo "<span class='success'>"."User Data Updated"."</span>";
			}else{
				echo "<span class='error'>"."User Data not Updated !"."</span>";
			}
		}
	}

	public function DisableUser($userid){
		$query = "UPDATE tbl_user SET status='1' WHERE userid='$userid'";
		$updated_row = $this->db->update($query);
		if ($updated_row) {
			echo "<span class='success'>"."User Disabled"."</span>";
		}else{
			echo "<span class='error'>"."User not Disabled !"."</span>";
		}
	}
	public function EnableUser($userid){
		$query = "UPDATE tbl_user SET status='0' WHERE userid='userid'";
		$updated_row = $this->db->update($query);
		if ($updated_row) {
			echo "<span class='success'>"."User Enabled"."</span>";
		}else{
			echo "<span class='error'>"."User not Enabled !"."</span>";
		}
	}
	public function DeleteUser($userid){
		$query = "DELETE FROM tbl_user WHERE userid='$userid'";
		$deleted_row = $this->db->delete($query);
		if ($deleted_row) {
			echo "<span class='success'>"."User Removed"."</span>";
		}else{
			echo "<span class='error'>"."Error... User not Removed !"."</span>";
		}
	}





}
?>