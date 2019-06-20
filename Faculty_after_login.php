<?php
$servername = "localhost";
$username = "username";
$password = "";
$dbname="test";


$conn = mysqli_connect($servername, $username, $password,$dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

$x=$_POST['t1'];
$y=$_POST['t2'];
$sql = "select * from login where login_id='$x' and password='$y'";
$fname="select S.subject_name
from SUBJECT S,TEACHES T,FACULTY F
where F.login_id = '$x' AND F.faculty_id = T.faculty_id AND T.sub_id = S.subject_code";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{while($row = $result->fetch_assoc()) {
        echo "id: " . $row["login_id"]. " admin: " . $row["is_admin"]. " <br>";
    }
	
}
else
{echo "Wrong userid or password";
}
mysqli_close($conn);
?>
<doctype html!>
<html>
<head>
<title>Faculty </title>
<link rel="stylesheet" href="style.css" />
</head>
<body>
<form action="add_ques.html" method="post">
<h4>Faculty </h4> </br>
<p5>Faculty Name: <?php echo $f_name ?></p5>
 </br> </br>
<p5>List of subjects : <?php echo $s_list ?></p5>
 </br> </br>
<p5>Faculty email : <?php echo $s_email ?></p5>
 </br> </br>
<hr>
<div id="buttonzone">


    <input type="submit" value="add questions" >
    
</div>

</form>
<form action="gen_quiz.html" method="post">

<div id="buttonzone">

    
    
    <input type="submit" value="generate quiz paper" >
</div>
</form>

</body>
</html>