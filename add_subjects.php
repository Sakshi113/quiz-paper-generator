<?php 
	session_start();
	$d_id = $_SESSION['dept_id'];
	$id = $_SESSION['id'];
$servername = "localhost";
$username = "root";
$password = "password";
$dbname="snehal";
$conn = mysqli_connect($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$query2 = "select faculty_name,login_id,faculty_desig from faculty where dept_id = '$d_id';";
	$res2 = mysqli_query($conn,$query2);
	while($row = mysqli_fetch_assoc($res2)){
		$string2 = '<option value = '.$row['login_id'].'>'.$row['faculty_name'].'</option>'.$string2;
	}
	$query1= "select subject_code from subject where dept_id = '$d_id';";
	$res1 = mysqli_query($conn,$query1);
	while($roww = mysqli_fetch_assoc($res1)){
		$string3 = '<option value ='.$roww['subject_code'].'>'.$roww['subject_code'].'</option>'.$string3;
	}
	if(isset($_POST['submit'])){
		$teachers = $_POST['teachers'];
		$subject_id =$_POST['subjects'];
		$sql = "insert into teaches values('$teachers','$subject_id');";
		$t=0;
		if(mysqli_query($conn,$sql)){
			$msg = "Updated Succesfully!";
			$t=1;
		}
	}
?>
<!DOCTYPE HTML>
<head>
	<title> Add Subjects </title>
	<link rel = "stylesheet" href = "style.css" type = "text/css">
</head>
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Add Subjects</h1>
				<h6> <?php if($t==1){echo $msg;} ?>
			</div>
	<div class = "login-form">	
	<form action = "add_subjects.php" method = "POST" onsubmit="return validate();">
		<div class="control-group">
			 Add Subjects for : 
		<select name = "teachers" id = "teachers">
			<option value = "select">Select</option>
			<?php echo $string2; ?>
		</select>
		<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
		<div class="control-group">
			Select subjects:
		<select name = "subjects" id = "subjects">
			<option value="select">Select</option>
			<?php echo $string3; ?>
		</select>
		<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
	<button type = "submit" name = "submit" class="btn btn-primary btn-large btn-block">Submit</button><br>
	<a href = "remove_subjects.php" class  = "btn btn-large btn-primary btn-block"> Remove Subjects </a>
	</form>
	</div>
	</div>
</div>
<script type="text/javascript">
	function validate(){
		let t = document.getElementById('teachers');
		let tval = t.options[t.selectedIndex].value;
		let s = document.getElementById('subjects');
		let sval = s.options[s.selectedIndex].value;
		if(tval == 'select'){
			alert("Please Select a Teacher Code!");
			return false;
		}
		else if(sval == 'select'){
			alert("Please Select a Subject!");
			return false;
		}
	}
	
</script>