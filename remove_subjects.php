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
	$query2 = "select login_id,faculty_name from faculty where dept_id = '$d_id';";
	$res2 = mysqli_query($conn,$query2);
	while($row = mysqli_fetch_assoc($res2)){
		$string2 = '<option value = '.$row['login_id'].'>'.$row['faculty_name'].'</option>'.$string2;
	}
	if(isset($_POST['submit'])){
		$l_id = $_POST['login_id'];
		$query = "select subject_id from teaches where faculty_id = '$l_id';";
		$result = mysqli_query($conn,$query);
		while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
			$string1 = '<input type = "checkbox" name  = "subjects[]" value = "'.$row['subject_id'].'">'.$row['subject_id'].'<br>'.$string1;
		}
	}
	$t=0;
	if(isset($_POST['delete'])){
		foreach($_POST['subjects'] as $selected){
		$query1= "delete from teaches where subject_id = '$selected';";
		mysqli_query($conn,$query1);
		$t=1;
		$msg = "Deletion Successful!";
	}
}
?>
<!DOCTYPE HTML>
<head>
	<title> Remove Subjects</title>
	<link rel = "stylesheet" href = "style.css" type = "text/css">
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Remove Subjects</h1>
				<h7><?php if($t==1){echo $msg;} ?>
			</div>
	<div class = "login-form">
	<form action = "remove_subjects.php" method = "POST">
		<div class="control-group">
		List Of teachers: 
		<select name = login_id>
			<option value ="selected">Select</option>
			<?php echo $string2; ?>
			</select>
			<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
		<button type = "submit" name = "submit" class="btn btn-primary btn-large btn-block"> Submit </button>
		<div class="control-group">
	<?php 
			echo $string1;
	?>
	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
	<button type = "submit" name = "delete" class="btn btn-primary btn-large btn-block" onclick = "return fun();">Delete </button>
</form>
</body>
<script type="text/javascript">
function fun(){
	var checkboxes = document.querySelectorAll('input[type="checkbox"]');
	var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
	if(checkedOne == false){
		alert("Please Select at least one subject!");
		return false;
	}
}
</script>