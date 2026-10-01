<?php
session_start();
include("config.php");

if(isset($_SESSION['email'])){
  header("Location: dashboard.php");
  exit();
}

$error = "";

if(isset($_POST['register'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

  if(mysqli_num_rows($check) > 0){
    $error = "Email already exists";
  } else {

    mysqli_query($conn,"
    INSERT INTO users (name,email,password,role)
    VALUES ('$name','$email','$password','user')
    ");

    header("Location: login.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>
body{
margin:0;
font-family:'Segoe UI';
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:
linear-gradient(rgba(168,216,234,0.3),rgba(214,198,255,0.3)),
url("images/bg2.jpg");
background-size:cover;
}

.container{
background:rgba(255,255,255,0.2);
backdrop-filter: blur(20px);
padding:40px;
border-radius:20px;
width:300px;
text-align:center;
}

input{
width:100%;
padding:12px;
margin:10px 0;
border-radius:10px;
border:none;
}

button{
width:100%;
padding:12px;
background:#D6C6FF;
border:none;
border-radius:10px;
color:white;
cursor:pointer;
margin-top:10px;
}

.back{
background:#ccc;
color:black;
}

.error{
color:red;
margin-bottom:10px;
}

a{
display:block;
margin-top:10px;
text-decoration:none;
color:#333;
}
</style>

</head>

<body>

<div class="container">

<h2>Create Account</h2>

<?php if($error != ""){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>

<button name="register">Register</button>

</form>

<a href="login.php">Already have an account?</a>

<button class="back" onclick="goHome()">⬅ Back to Home</button>

</div>

<script>
function goHome(){
  window.location.href="index.php";
}
</script>

</body>
</html>