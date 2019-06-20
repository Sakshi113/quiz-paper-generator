<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "password";
$dbname="snehal";
$conn = mysqli_connect($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$x=$_POST['t1'];
$y=$_POST['t2'];

$sql2 = "select * from login where login_id='$x' and password='$y'";
$result = $conn->query($sql2);
if ($result->num_rows > 0 ) {
	$row = $result->fetch_assoc();
        $id = $row["login_id"];
		$_SESSION['login_id'] = $id;
		$sql3 = "select faculty_name,faculty_desig,email from faculty where login_id='$id'";	
	$result1 = $conn->query($sql3);
	$row1 = $result1->fetch_assoc();
	$f_name = $row1["faculty_name"];
	$s_email = $row1["email"];
	$_SESSION['name'] = $f_name;
}
//}
else
{echo "Wrong userid or password";
	include("wrong_id.html");
}

mysqli_close($conn);
?>
<doctype html!>
<html>
<head>
<title>Faculty </title>
<link rel="stylesheet" href="style.css" type = "text/css">
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Faculty Details</h1>
			</div>
	<div class = "login-form">	
	<form action="add_ques.php" method="post">
		<div class="control-group">
			Faculty Name: <?php echo $f_name ?>
 		<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
		<div class="control-group">
 		Faculty email : <?php echo $s_email ?>
 		<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
		<a href = "add_ques.php" class = "btn btn-large btn-primary btn-block" value = "submit">Add Questions</a><br>
<a href = "remove_question.php" class = "btn btn-large btn-primary btn-block" value = "submit">Remove Questions</a><br>
<a href = "generate_quiz.php" class = "btn btn-large btn-primary btn-block" value = "submit">Generate Quiz</a><br>
</form>
	</div>
	</div>

</body>
</html>