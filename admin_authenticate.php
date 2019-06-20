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
$sql2 = "select * from login where login_id='$x' and password='$y' and is_admin = 'Y';";
$result = $conn->query($sql2);
if($result->num_rows > 0 ) {
	$row = $result->fetch_assoc();
    $id = $row["login_id"];
	$dept = "select dept_id from faculty where login_id = '$id';";
	$tampa = mysqli_query($conn,$dept);
	$ram = mysqli_fetch_assoc($tampa);
	$d_id = $ram['dept_id'];
	$_SESSION['dept_id'] = $d_id;
	$_SESSION['id'] = $id;
	$query2 = "select faculty_name,login_id,faculty_desig from faculty where dept_id = '$d_id';";
	$res2 = mysqli_query($conn,$query2);
	while($row = mysqli_fetch_assoc($res2)){
		$string =  '<tr><td>'.$row['faculty_name'].'</td><td>'.$row['login_id'].'</td></tr>'.$string;
	}
}
else
{
	echo "Wrong userid or password";
	include("wrong_id.html");
}
mysqli_close($conn);
?>
<!DOCTYPE HTML>
<head>
	<title> Admin </title>
	<link rel = "stylesheet" href = "style.css" type = "text/css">
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>People Under Your Administration</h1>
			</div>
	<table>
		<tbody>
			<tr><td>Name</td><td>Login ID</td></tr>
			<?php echo $string; ?>
		</tbody>
	</table>
	</div>
</div>
	<a href = "add_subjects.php" class = "btn btn-large btn-primary btn-block"> Add Subjects </a><br>
	<a href = "remove_subjects.php" class  = "btn btn-large btn-primary btn-block"> Remove Subjects </a>
</body>