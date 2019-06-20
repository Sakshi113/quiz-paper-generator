<?php 
  session_start();
  $id = $_SESSION['login_id'];
  $name = $_SESSION['name'];
?>
<!doctype html>
<html>
<head>
<title>GenerateQuiz </title>
<link rel="stylesheet" href="style.css" >
</head>
<body>
<div class="login">
    <div class="login-screen">
      <div class="app-title">
        <h1>Generate Quiz</h1>
      </div> 
  <div class = "login-form">   
  <form action="gen_quiz.php" method="post" onsubmit="return validate();">
    <div class="control-group">
      <input type="text" name = "name" class="login-field" placeholder="<?php echo $name; ?>" required>
    <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
    <div class="control-group"> 
      <input type="number" name = "quiznum" class="login-field" placeholder="Quiz Number" required>
     <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
    <p5>Choose subject </p5>
     <div class="control-group"> 
    <select name = "sub" class = "login-field">
      <option value="Select">Select</option>
  <?php
  $servername = "localhost";
$username = "root";
$password = "password";
$dbname="snehal";
$conn = mysqli_connect($servername, $username, $password,$dbname);
  $sql4 = "select subject_name,subject_code from subject,teaches where faculty_id = '$id' and subject_id=subject_code";  
  $result2 = mysqli_query($conn,$sql4);
  while($row2 = $result2->fetch_assoc())
  {
    echo '<option value ="'.$row2["subject_code"].'">'.$row2["subject_name"].'</option>';
  }
  ?>
</select>
 <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
 <div class="control-group"> 
Module <br>
<select name = "module" class="login-field">
  <option value="Select">Select</option>
  <option value="1">1</option>
  <option value="2">2</option>
  <option value="3">3</option>
  <option value="4">4</option>
  <option value="5">5</option>
</select>
 <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
 <div class="control-group"> 
<p5>Enter Scheduled Date </p5><br><br>
<input type="date" name = "sch_date" class = "box" required id = "date">
 <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
 <div class="control-group"> 
<p5>Is manual(1 for yes/0 for no): </p5>
<select name = "manual" class="login-field">
  <option value="1">0</option>
  <option value="2">1</option>  
</select>
 <label class="login-field-icon fui-user" for="login-name"></label>
  </div>
   <div class="control-group"> 
<input type = "text" name = "1marks" class="login-field" placeholder="No. of 1 marks question"> <label class="login-field-icon fui-user" for="login-name" ></label>
    </div>
     <div class="control-group"> 
<input type = "text" name = "2marks" class="login-field" placeholder="No. of 2 marks question"> <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
     <div class="control-group"> 
<input type = "text" name = "3marks" class="login-field" placeholder="No. of 3 marks question"> <label class="login-field-icon fui-user" for="login-name"></label>
    </div>
     <div class="control-group"> 
<input type = "text" name = "sets" class="login-field" placeholder="No. of sets"> <label class="login-field-icon fui-user" for="login-name"></label>
    </div>

    <input type="submit" value="Generate Paper" class = "btn btn-large btn-primary btn-block"><br>
    <input type="reset" value="clear" class = "btn btn-large btn-primary btn-block">
    
</div>
<script>
  function validate(){
    let date = document.getElementById('date').value;
    let regex = /-/g;
    d = date.replace(regex," , ");
    let dateone = new Date(d);
    let today = new Date();
    if(dateone<today){
      alert("Please give a date after today!");
      return false;
    }
  }
</script>
</form>
</body>
</html>