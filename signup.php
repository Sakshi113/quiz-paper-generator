<?php 
	$servername = "localhost";
	$username = "root";
	$password = "password";
	$dbname="snehal";
	$conn = mysqli_connect($servername, $username, $password,$dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	if(isset($_POST['submit'])){
		$login_id = $_POST['login_id'];
		$password = $_POST['password'];
		$name = $_POST['name'];
		$dept_id = $_POST['dept_id'];
		$desig = $_POST['desig'];
		$email= $_POST['email'];
		$sql = "insert into login values('$login_id','$password','N');";
		if(mysqli_query($conn,$sql)){
			$sql1 = "insert into faculty values('$login_id','$name','$dept_id','$desig','$email');";
			if(mysqli_query($conn,$sql1)){
				echo "Successfully signed up!";
			}
			else{
				echo "some error occured!";
			}
		}
		else{
			echo "some Error occured!";
		}
	}	
?>
<!DOCTYPE HTML>
<head>
	<title>Sign-Up</title>
	<link href = "style.css" rel = "stylesheet" type ="text/css">
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Sign Up</h1>
			</div>
	<div class = "login-form">
	<form action = "signup.php" method = "POST" onsubmit = "return validate();">
			<div class="control-group">
				<input type="text" name="login_id" class="login-field" placeholder = "Login Id" required id = "login_id">
			<label class="login-field-icon fui-user" for="login-name"></label>
			</div>
			<div class="control-group">
				<input type="Password" name="password" class="login-field" placeholder = "Password" required id = "password">
			<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
			<div class="control-group">
				<input type="text" name="dept_id" class="login-field" placeholder = "Department ID" required id = "dept_id">
				<label class="login-field-icon fui-user" for="login-name" ></label>
			</div>
			<div class="control-group">
				<input type="text" name="desig" class="login-field" placeholder = "Designation" required id ="designation">
				<label class="login-field-icon fui-user" for="login-name" ></label>
			</div>
		<div class="control-group">
				<input type="Email" name="email" class="login-field"  placeholder = "Email ID" required>
			<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
		<button type = "submit" value = "submit" name = "submit" class = "btn btn-primary btn-large btn-block">Submit</button>
	</form>
</body>	
<script type="text/javascript">
function validate(){
	let login_id = document.getElementById('login_id').value;
	let password = document.getElementById('password').value;
	let dept_id = document.getElementById('dept_id').value;
	let designation = document.getElementById('designation').value;
	let login_regex = new RegExp(/^([a-z0-9]{5,})$/);
	let pass = new RegExp(/^[a-z0-9]{6,}$/);
	if(login_regex.test(login_id)== false){
		alert("login_id can contain only alphabets and digits and must be of 5 or more characters!");
		return false;
	}
	else if(pass.test(password)==false){
		alert("Password must be of 6 characters or more and must contain alphabets digits and special symbols!");
		return false;
	}
	return true;
}
</script>