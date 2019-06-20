<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "snehal";
require('fpdf/fpdf.php');
$pdf = new FPDF('P','mm','A4');
//$pdf->SetProtection(array('print'),'password'); 

$textColour = array( 0, 0, 0 );
$headerColour = array( 100, 100, 100 );

//require('fpdf/fpdf.php');
//$pdf = new FPDF('P','mm','A4');
// Create connection
$conn =  mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$one = $_POST['1marks'];
$two = $_POST['2marks'];
$three = $_POST['3marks'];
$sets = $_POST['sets'];
$i=$_POST['name'];
$x=$_POST['quiznum'];
$y=$_POST['sub'];
$w=$_POST['sch_date'];
$t=$_POST['manual'];
$mod = $_POST['module'];
$full_marks = $one*1+$two*2+$three*3;
$required_one = $one*$sets;
$required_two = $two*$sets;
$required_three = $three*$sets;
$query1 = "select question,is_diagram,d_path from quiz_ques where marks = '1' and sub_id = '$y' and module = '$mod';";
$query2= "select question,is_diagram,d_path from quiz_ques where marks = '2' and sub_id = '$y' and module = '$mod';";
$query3 = "select question,is_diagram,d_path from quiz_ques where marks = '3' and sub_id = '$y' and module = '$mod';";
$res1 = mysqli_query($conn,$query1);
$res2 = mysqli_query($conn,$query2);
$res3 = mysqli_query($conn,$query3);
$count1 = mysqli_num_rows($res1);
$count2 = mysqli_num_rows($res2);
$count3 = mysqli_num_rows($res3);
if($required_one > $count1|| $required_two > $count2 || $required_three > $count3){
	$message = "Insufficient number of questions";
	$_SESSION['message'] = $message;
	header("location://localhost/snehal/add_ques.php");
}
$subsql = "select subject_name from subject where subject_code='$y'";
$subres = $conn->query($subsql);
$subrow = $subres->fetch_assoc();
$subject = $subrow["subject_name"];

$sql = "INSERT INTO stats (sub_id,fac_name,quiz_no,scheduled_date,is_manual) VALUES ('$y','$i','$x','$w','$t')";
$stack1 = array("a","b");
$stack2 = array("a","b");
$stack3 = array("a","b");
$quiz = "Quiz : " . $x;
for($z = 0;$z < $sets;$z++){
	$pdf->AddPage();
	$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
	$pdf->SetFont( 'Arial', '', 17 );
	$pdf->Cell( 0, 8,"Siddaganga Institute of Technology", 0, 1, 'C' );
	$pdf->SetFont( 'Arial', '', 14 );
	$pdf->Cell( 0, 10,$subject, 0, 1, 'C' );
	$pdf->Cell( 0, 10,$quiz, 0, 1, 'C' );
	$pdf->SetFont('Arial','',12);
	$f = 1;
	$set = "Set ".($z+1);
	$num = mt_rand(1,$count1);
	$pdf->Cell(0,10,$set,0,1,'C');
	$ex1 = "Questions";
	$pdf->Cell(0,8,$ex1,0,0,'L');
	$fstring = "Full Marks: ".$full_marks;
	$pdf->Cell(0,8,$fstring,0,1,'R');
	$sn = $one;
	$tn = $two;
	$thn = $three;
	while($sn > 0){
		mysqli_data_seek($res1,0);
		$num = mt_rand(1,$count1);
		if(in_array($num,$stack1)){
			continue;
		}
		else{
			mysqli_data_seek($res1,$num);
			array_push($stack1,$num);
			$quest = mysqli_fetch_assoc($res1);	
			$ex2 = "$f: ".$quest["question"]." (1 mark)";
			$has_image = $quest['is_diagram'];
			$pdf->Cell(0,5,$ex2,0,1,'L');
			if($has_image == 1){
				$path = $quest['d_path'];
				$pdf->Image($path,100,null,40);
			}
			$f++;
			$sn--;
		}
	}
	while($tn > 0){
		mysqli_data_seek($res2,0);
		$num = mt_rand(1,$count2);
		if(in_array($num,$stack2)){
			continue;
		}
		else{
			mysqli_data_seek($res2,$num);
			array_push($stack2,$num);
			$quest = mysqli_fetch_assoc($res2);
			//echo $quest["question"]."<br>";	
			$ex2 = "$f: ".$quest["question"]." (2 mark)";
			$pdf->Cell(0,5,$ex2,0,1,'L');
			$f++;
			$tn--;
		}
	}
	while($thn > 0){
		mysqli_data_seek($res3,0);
		$num = mt_rand(1,$count3);
		if(in_array($num,$stack3)){
			continue;
		}
		else{
			mysqli_data_seek($res3,$num);
			array_push($stack3,$num);
			$quest = mysqli_fetch_assoc($res3);
			//echo $quest["question"]."<br>";	
			$ex2 = "$f: ".$quest["question"]." (3 mark)";
			$pdf->Cell(0,5,$ex2,0,1,'L');
			$f++;
			$thn--;
		}
	}
}
$conn->close();
$pdf->Output();
?>
<!doctype html>
<html>
<head>
<title>GenerateQuiz </title>
<link rel="stylesheet" href="style.css" >
</head>
<body>
<form action="gen_quiz.php" method="post">
<h4>Generate Quiz </h4> </br>
<p5>Faculty name : </p5>
<input type="text" name = "name" class = "box"/ > </br> </br>
<p5>Enter Quiz Number : </p5>
<input type="number" name = "quiznum" class = "box"/ > </br> </br>
<p5>Choose subject : </p5>
<select name = "sub">
  <option value="Select">Select</option>
  <?php
  $sql4 = "select subject_name,subject_code from subject,teaches where faculty_id='$id' and subject_id=subject_code";	
	$result2 = $conn->query($sql4);
	while($row2 = $result2->fetch_assoc())
	{  
	 echo '<option value ="'.$row2["subject_code"].'">'.$row2["subject_name"].'</option>';
	}
	?>
</select>
<select name = "module">
  <option value="Select">Select</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
<p5>Enter Scheduled Date : </p5>
<input type="date" name = "sch_date" class = "box"> </br> </br>
<p5>Is manual(1 for yes/0 for no): </p5>
<select name = "manual">
  <option value="1">0</option>
  <option value="2">1</option>
  
</select>
No. of 1 marks:<input type = "text" name = "1marks"><br>
No. of 2 marks:<input type = "text" name = "2marks"><br>
No. of 3 marks:<input type = "text" name = "3marks"><br>
No. of sets:<input type = "text" name = "sets"><br>
<hr>
<div id="buttonzone">

    <input type="submit" value="Generate Paper" >
    
    &nbsp

    <input type="reset" value="clear" >
    
</div>

</form>
</body>
</html>