<?php
session_start();
include("config.php");

date_default_timezone_set("Asia/Riyadh");

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}

$result = mysqli_query($conn,"SELECT * FROM room");
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rooms</title>

<style>
body{
margin:0;
font-family:'Segoe UI';
background:
linear-gradient(rgba(168,216,234,0.3),rgba(214,198,255,0.3)),
url("images/bg.jpg");
background-size:cover;
}

.main{
padding:40px;
}

h2{
text-align:center;
margin-bottom:30px;
}

.rooms{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

.card{
background:rgba(255,255,255,0.9);
padding:20px;
border-radius:20px;
text-align:center;
transition:0.3s;
}

.card:hover{
transform:scale(1.05);
}

.status{
margin-top:10px;
font-weight:bold;
}

.available{
color:green;
}

.booked{
color:red;
}

button{
margin-top:15px;
padding:10px;
border:none;
border-radius:10px;
background:#A8D8EA;
color:white;
cursor:pointer;
width:100%;
}

.disabled{
background:#ccc;
cursor:not-allowed;
}

.back{
margin-top:20px;
background:#ccc;
color:black;
}
</style>

</head>

<body>

<div class="main">

<h2>🏠 Available Rooms</h2>

<div class="rooms">

<?php while($row = mysqli_fetch_assoc($result)){ 

$today = date("Y-m-d");
$now = date("H:i:s");

$check = mysqli_query($conn,"
SELECT * FROM booking 
WHERE room_id='".$row['id']."'
AND booking_date = '$today'
AND end_time > '$now'
");

$isBooked = mysqli_num_rows($check) > 0;
?>

<div class="card">

<h3><?php echo $row['name']; ?></h3>

<p class="status <?php echo $isBooked ? 'booked' : 'available'; ?>">
<?php echo $isBooked ? "🔴 Booked" : "🟢 Available"; ?>
</p>

<?php if($isBooked){ ?>
<button class="disabled" disabled>
Room Booked
</button>
<?php } else { ?>
<button onclick="viewRoom(<?php echo $row['id']; ?>)">
View Room
</button>
<?php } ?>

</div>

<?php } ?>

</div>

<button class="back" onclick="goBack()">⬅ Back</button>

</div>

<script>
function viewRoom(id){
  window.location.href="room_details.php?room="+id;
}

function goBack(){
  window.location.href="dashboard.php";
}
</script>

</body>
</html>