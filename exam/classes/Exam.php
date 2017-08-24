<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php');
	include_once ($filepath.'/../helpers/Format.php');

class Exam{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function getQuestions($data){
		$quesNo = $this->fm->validation(mysqli_real_escape_string($this->db->link, $data['quesNo']));
		$ques = $this->fm->validation(mysqli_real_escape_string($this->db->link, $data['ques']));
		$ans = array();
		$ans[1] = $data['ans1'];
		$ans[2] = $data['ans2'];
		$ans[3] = $data['ans3'];
		$rightAns = $this->fm->validation(mysqli_real_escape_string($this->db->link, $data['rightAns']));
		$query = "INSERT INTO tbl_ques (quesNo, ques) VALUES('$quesNo', '$ques')";
		$insert_row = $this->db->insert($query);
		if ($insert_row) {
			foreach ($ans as $key => $ansName) {
				if ($ansName != '') {
					if ($rightAns == $key) {
						$rquery = "INSERT INTO tbl_ans (quesNo, rightAns, ans) VALUES('$quesNo', '1', '$ansName')";						
					}else{
						$rquery = "INSERT INTO tbl_ans (quesNo, rightAns, ans) VALUES('$quesNo', '0', '$ansName')";						
					}
					$insert_row = $this->db->insert($rquery);
					if ($insert_row) {
						continue;
					}else{
						die('Error...');
					}
				}
			}
			echo "<span class='success'>"."Question Added Successfuly"."</span>";
		}
	}

	public function getQueByOrder(){
		$query  = "SELECT * FROM tbl_ques ORDER BY quesNo ASC";
		$result = $this->db->select($query);
		return $result;
	}

	public function delQuestion($quesNo){
		$tables = array("tbl_ques", "tbl_ans");
		foreach ($tables as $table) {
			$query = "DELETE FROM $table WHERE quesNo='$quesNo'";
			$deleted_row = $this->db->delete($query);		
		}
		if ($deleted_row) {
			echo "<span class='success'>"."Data Deleted Successfuly"."</span>";
		}else{
			echo "<span class='error'>"."Data Not Deleted !"."</span>";
		}
	}

	public function getTotalRows(){
		$query  = "SELECT * FROM tbl_ques";
		$result = $this->db->select($query);
		$total  = $result->num_rows;
		return $total;
	}

	public function getQuestion(){		
		$query  = "SELECT * FROM tbl_ques";
		$getdata = $this->db->select($query);
		$result = $getdata->fetch_assoc();
		return $result;
	}

	public function getQuesByNumber($number){
		$query  = "SELECT * FROM tbl_ques WHERE quesNo='$number'";
		$getdata = $this->db->select($query);
		$result = $getdata->fetch_assoc();
		return $result;
	}

	public function getAnswer($number){
		$query  = "SELECT * FROM tbl_ans WHERE quesNo='$number'";
		$getdata = $this->db->select($query);
		return $getdata;
	}

	






}
?>