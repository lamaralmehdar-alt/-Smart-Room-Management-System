<?php
session_start();

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}

$role = $_SESSION['role'] ?? "user";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard</title>

<style>
body {
  margin:0;
  font-family:'Segoe UI';
  display:flex;
  background:
  linear-gradient(rgba(168,216,234,0.3),rgba(214,198,255,0.3)),
  url("images/bg.jpg");
  background-size:cover;
}

.menu-btn{
  position:fixed;
  top:20px;
  left:20px;
  background:white;
  padding:8px 12px;
  border-radius:10px;
  cursor:pointer;
  z-index:10001;
}

.sidebar{
  position:fixed;
  left:-100%;
  top:0;
  width:240px;
  height:100%;
  background:linear-gradient(#A8D8EA,#D6C6FF);
  padding:25px;
  color:white;
  transition:0.4s;
  z-index:10000;
}

.sidebar.active{
  left:0;
}

.sidebar a{
  display:block;
  margin-bottom:10px;
  color:white;
  text-decoration:none;
  padding:10px;
  border-radius:10px;
}

.main{
  padding:80px 30px;
  width:100%;
}

.card{
  background:rgba(255,255,255,0.85);
  padding:20px;
  border-radius:15px;
  margin-bottom:20px;
}

button{
  padding:10px 20px;
  border:none;
  border-radius:10px;
  background:#A8D8EA;
  color:white;
  cursor:pointer;
  margin-top:10px;
}
</style>

</head>

<body>

<div class="menu-btn" onclick="toggleMenu()">☰</div>

<div class="sidebar" id="sidebar">
<h2>Smart Room</h2>

<a href="dashboard.php">Dashboard</a>
<a href="room.php">Rooms</a>
<a href="my_bookings.php">My Bookings</a>
<a href="account.php">My Account</a>
<a href="logout.php">Logout</a>

<?php if($role == "admin"){ ?>
<a href="admin.php">Admin Panel 👑</a>
<?php } ?>

</div>

<div class="main">

<h2>Welcome <?php echo $_SESSION['name']; ?> ✨</h2>

<!-- Explore Rooms -->
<div class="card">
<h3>🏠 Explore Rooms</h3>
<button onclick="goPage('room.php')">Browse Rooms</button>
</div>

<!-- My Bookings -->
<div class="card">
<h3>✔ Your Booking</h3>
<button onclick="goPage('my_bookings.php')">
View Your Bookings
</button>
</div>

<!-- Device Control -->
<div class="card">
<h3>🎮 Device Control</h3>
<button onclick="goPage('devicecontrol.php')">
Control Devices
</button>
</div>

<!-- Sensors -->
<div class="card">
<h3>📡 Sensors</h3>
<button onclick="goPage('sensors.php')">
View Sensors
</button>
</div>

</div>

<script>
function toggleMenu(){
  document.getElementById("sidebar").classList.toggle("active");
}

function goPage(url){
  document.getElementById("loading").style.display="flex";
  setTimeout(function(){
    window.location.href=url;
  },500);
}
</script>

<div id="loading" style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(255,255,255,0.7);
justify-content:center;
align-items:center;
font-size:20px;
z-index:9999;
">
⏳ Loading...
</div>

</body>
</html>