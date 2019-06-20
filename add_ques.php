<?php
$servername = "localhost";
$username = "root";
$password = "password";
$dbname = "snehal";
session_start();
$id = $_SESSION['login_id'];
$conn =  mysqli_connect($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
  $sql4 = "select subject_name,subject_code from subject,teaches where faculty_id='$id' and subject_id=subject_code";	
	$result2 = $conn->query($sql4);
	while($row2 = $result2->fetch_assoc())
	{
	 $string =  
	 '<input type ="radio" name = "subjects" class="login-field" value ="'.$row2["subject_code"].'">'.$row2["subject_name"].'<br>'.$string;
	}
if(isset($_SESSION['message'])){
	echo $_SESSION['message'];
}
if(isset($_POST['submit'])){
	$i=$_POST['question'];
	$x=$_POST['subjects'];
	$y=$_POST['marks'];
	$w=$_POST['module'];
	$t=0;
	if($_POST['diagram']){
		$t= 1;
	}
	$ro = 0;
	$sql = "insert into quiz_ques(question,sub_id,marks,module,upload_date,is_diagram ) VALUES('$i','$x','$y','$w',NOW(),'$t');";
	if ($conn->query($sql) === TRUE) {
	    $success = "New record created successfully";
		$ro  =1;
		//include("logout.html");
	}
	 else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	if($t == 1){
		$file=$_FILES['file'];$tew = 0;
		$filename=$_FILES['file']['name'];
		$fileTmpName=$_FILES['file']['tmp_name'];
		$fileSize=$_FILES['file']['size'];
		$fileError=$_FILES['file']['error'];
		$fileType=$_FILES['file']['type'];
		$fileExt=explode('.',$filename);
		$fileActualExt=strtolower(end($fileExt));
		$allowed = array('jpg','jpeg','png');
			if(in_array($fileActualExt,$allowed)){
				if($fileError===0)
				{
					if($fileSize<209715200000){
							//$fileNameNew=uniqid('',true).".".$fileActualExt;
						$fileDestination='/home/us/proctor_portal/'.$filename;
						$query = "update quiz_ques set d_path = '$fileDestination' where question = '$i';";
						mysqli_query($conn,$query);
						if(move_uploaded_file($fileTmpName,$fileDestination)){
						   $tew = 1;
						}
						else { $tew = 2;
							$msg = "Failed to upload file!";
						};
					}
					else{$tew = 3;
						$msg = "Your file is too big!";
					}
				}
				else{
					$tew = 4;
					$msg = "There was an error uploading your file";
				}
			}
			else{
				$tew = 5;
				$msg = "You cannot upload this kind of file";
			}
		}
		$conn->close();
	}
?>

<!DOCTYPE html>
<head>
	<title> Add Questions </title>
	<link rel = "stylesheet" href = "style.css">
</head>
<body>
	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Add Questions </h1>
				<h3><?php 
					if($t==1)
							{
								if($tew==1 && $ro==1){
									echo $success;
								}
								else{
								switch($tew){
									case 2: echo $msg;
											break;
									case 3: echo $msg;
											break;
									case 4: echo $msg;
											break;
									case 5: echo $msg;
											break;
								}
							}
						}
							else if($t== -1){
								echo "failed to upload! Some Error Occured!";
							}

					?>
			</div>
	<div class = "login-form">	
<form action="add_ques.php" method="POST" enctype="multipart/form-data" onsubmit="return validate();">
<div class="control-group">
<p5>Enter Question : </p5><br>
 <textarea rows = "8" cols = "60" name = "question" id = "question">
         </textarea>
         	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
    <div class="control-group">     
 Choose Subject: <br><?php  echo $string; 
  	?>
  		<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
  	<div class="control-group">
Choose Marks :
<select name = "marks" class="login-field">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
</select>
	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
<div class="control-group">
<p5>Choose Module : </p5>
<select name = "module" class="login-field">
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
<div class="control-group">
<p5>has diagram: </p5>
	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
<div class="control-group">
<input type = 'checkbox' name = "diagram" class="login-field" value = "1" id = "diagram" onclick="show();">
	<label class="login-field-icon fui-user" for="login-name"></label>
		</div>
	<input type = "file" name = "file" id = "uploadFile" class = "notVisible btn btn-large btn-primary btn-block"><br>
    <input type="reset" value="clear" class = "btn btn-large btn-primary btn-block" ><br>
    <input type="submit" value="Enter" name="submit" class = "btn btn-large btn-primary btn-block"><br>
    <a href = "remove_question.php" class = "btn btn-large btn-primary btn-block" value = "submit">Remove Questions</a><br>
</form>
<script>
	function show(){
		let c = document.getElementById('diagram');
		let f = document.getElementById("uploadFile");
		if(c.checked){
			f.classList.remove("notVisible");
		}
		else{
			f.classList.add("notVisible");
		}
}
function validate(){
		let t = document.querySelectorAll('input[type="radio"]');
		let tval = Array.prototype.slice.call(t).some(x => x.checked);
		if(tval == false){
			alert("Please select a subject!");
			return false;
		}
		let text = document.getElementById('question').innerHtml;
		text = text.trim();
		if(text == undefined || text == ""){
			alert("Insert a Question!");
			return false;
		}

	}
</script>
</body>