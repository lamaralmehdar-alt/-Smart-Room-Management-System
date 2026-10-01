<?php
session_start();

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sensors</title>

<style>
body{
margin:0;
font-family:'Segoe UI';
background:
linear-gradient(rgba(168,216,234,0.3),rgba(214,198,255,0.3)),
url("images/bg.jpg");
background-size:cover;
display:flex;
}

.main{
margin:auto;
width:400px;
padding:30px;
}

.box{
background:rgba(255,255,255,0.9);
padding:25px;
border-radius:20px;
text-align:center;
}

.sensor{
margin-top:15px;
padding:12px;
background:#fff;
border-radius:10px;
}

button{
width:100%;
padding:10px;
margin-top:15px;
border:none;
border-radius:10px;
background:#A8D8EA;
color:white;
cursor:pointer;
}
</style>

</head>

<body>

<div class="main">
<div class="box">

<h2>📡 Sensors</h2>

<div class="sensor">🌡 Temperature: 24°C</div>
<div class="sensor">💧 Humidity: 60%</div>
<div class="sensor">🔥 Smoke: Safe</div>

<button onclick="goBack()">⬅ Back</button>

</div>
</div>

<script>
function goBack(){
  window.location.href="dashboard.php";
}
</script>

</body>
</html>