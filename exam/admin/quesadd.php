<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/inc/header.php');
	include_once ($filepath.'/../classes/Exam.php');
	$exm = new Exam();
?>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 	$addQue = $exm->getQuestions($_POST);
 }
 //get Total Question
 $total = $exm->getTotalRows();
 $next =  $total+1;
?>

<div class="main">
<h1>Admin Panel</h1>
<?php if(isset($addQue)){ echo $addQue; } ?>
	<div class="adminpanel">
		<form action="" method="POST">
			<table>
				<tr>
					<td>Question No</td>
					<td>:</td>
					<td><input type="number" name="quesNo" value="<?php if (isset($next)) { echo $next; } ?>" /></td>
				</tr>
				<tr>
					<td>Question</td>
					<td>:</td>
					<td><input type="text" name="ques" placeholder="Enter question.." id="" required /></td>
				</tr>
				<tr>
					<td>Choice One</td>
					<td>:</td>
					<td><input type="text" name="ans1" placeholder="Enter Choice One." id="" required /></td>
				</tr>
				<tr>
					<td>Choice Two</td>
					<td>:</td>
					<td><input type="text" name="ans2" placeholder="Enter Choice Two." id="" required /></td>
				</tr>
				<tr>
					<td>Choice Three</td>
					<td>:</td>
					<td><input type="text" name="ans3" placeholder="Enter Choice Three." id="" required /></td>
				</tr>
				<tr>
					<td>Correct No.</td>
					<td>:</td>
					<td><input type="number" name="rightAns" value="" /></td>
				</tr>
				<tr>
					<td align="center" colspan="3"><input type="submit" name="rightAns" value="Add A Question" /></td>
				</tr>
			</table>
		</form>
	</div>	
</div>
<?php include 'inc/footer.php'; ?>