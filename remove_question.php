<?php
/*start_session();
$id = $_SESSION['login_id'];
echo $id;*/
$servername = "localhost";
$username = "root";
$password = "password";
$dbname="snehal";
$conn = mysqli_connect($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql4 = "select subject_name,subject_code from subject,teaches where faculty_id = 'csad01' and subject_id=subject_code";	
$result2 = mysqli_query($conn,$sql4);
while($row2 = $result2->fetch_assoc())
{
 $string = '<input type ="radio" name = "subjects" value ="'.$row2["subject_code"].'">'.$row2["subject_name"].'<br>'.$string;
}
if(isset($_POST['submit'])){
	$sub_id = $_POST['subjects'];
	$query = "select question,marks,module from quiz_ques where sub_id = '$sub_id';";
	$result = mysqli_query($conn,$query);
	while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		$string1 = '<input type = "checkbox" name  = "questions[]" value = "'.$row['question'].'">'.$row['question'].'<br>'.$string1;
	}
}
if(isset($_POST['delete'])){
	foreach($_POST['questions'] as $selected){
		$query1= "delete from quiz_ques where question = '$selected';";
		mysqli_query($conn,$query1);
	}
}
?>
<!DOCTYPE HTML>
<head>
	<title> Remove Questions</title>
	<link rel = "stylesheet" href = "style.css" type = "text/css">
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Remove Questions</h1>
			</div>
	<div class = "login-form">
	<form action = "remove_question.php" method = "POST">
		<div class="control-group">
		List Of Subjects: <br><?php echo $string; ?>
		<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
		<button type = "submit" name = "submit" id = "submit" class="btn btn-primary btn-large btn-block" onclick = "return validate();"> Submit </button>
	<div class="control-group">
	<?php 
			echo $string1;
	?>
	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
	<button type = "submit" name = "delete" id = "delete" class = "btn btn-primary btn-large btn-block" onclick = "return fun();">Delete </button>
</form>
</body>
<script type="text/javascript">
	function validate(){
		let t = document.querySelectorAll('input[type="radio"]');
		let tval = Array.prototype.slice.call(t).some(x => x.checked);
		if(tval == false){
			alert("Please select a subject!");
			return false;
		}
	}
function fun(){
	var checkboxes = document.querySelectorAll('input[type="checkbox"]');
	var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
	if(checkedOne == false){
		alert("Please Select at least one question!");
		return false;
	}
}
</script>
