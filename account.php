<?php
session_start();
include("config.php");

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_POST['update'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(!empty($password)){
    mysqli_query($conn, "
    UPDATE users 
    SET name='$name', email='$email', password='$password'
    WHERE user_id='$user_id'
    ");
  } else {
    mysqli_query($conn, "
    UPDATE users 
    SET name='$name', email='$email'
    WHERE user_id='$user_id'
    ");
  }

  $_SESSION['name'] = $name;
  $_SESSION['email'] = $email;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Account</title>

<style>
body{
margin:0;
font-family:'Segoe UI';
background:
linear-gradient(rgba(168,216,234,0.3),rgba(214,198,255,0.3)),
url("images/bg.jpg");
background-size:cover;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.container{
background:rgba(255,255,255,0.9);
padding:30px;
border-radius:20px;
width:380px;
}

h2{text-align:center;}

.field{
margin-top:10px;
}

input{
width:100%;
padding:10px;
margin-top:5px;
border-radius:10px;
border:none;
}

button{
width:100%;
padding:12px;
margin-top:15px;
border:none;
border-radius:10px;
background:#A8D8EA;
color:white;
cursor:pointer;
}

.back{
background:#ccc;
color:black;
}
</style>

</head>

<body>

<div class="container">

<h2>My Account 👤</h2>

<form method="POST">

<div class="field">
<label>Name</label>
<input type="text" name="name" value="<?php echo $_SESSION['name']; ?>" required>
</div>

<div class="field">
<label>Email</label>
<input type="email" name="email" value="<?php echo $_SESSION['email']; ?>" required>
</div>

<div class="field">
<label>New Password</label>
<input type="password" name="password" placeholder="Leave empty if no change">
</div>

<button name="update">Update Profile</button>

</form>

<button class="back" onclick="goBack()">⬅ Back</button>

</div>

<script>
function goBack(){
  window.location.href="dashboard.php";
}
</script>

</body>
</html>