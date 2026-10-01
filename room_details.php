<?php
session_start();
include("config.php");

date_default_timezone_set("Asia/Riyadh");

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}

if(!isset($_GET['room']) || empty($_GET['room'])){
  echo "Room not found";
  exit();
}

$room_id = intval($_GET['room']);
$user_id = $_SESSION['user_id'];

$roomQuery = mysqli_query($conn,"SELECT name FROM room WHERE id='$room_id'");
$roomData = mysqli_fetch_assoc($roomQuery);

if(!$roomData){
  echo "Room not found";
  exit();
}

$room_name = $roomData['name'];

$status = "none";
$start = "";
$end = "";

$now = date("H:i:s");
$today = date("Y-m-d");

$query = mysqli_query($conn, "
SELECT * FROM booking 
WHERE user_id='$user_id' 
AND room_id='$room_id'
AND booking_date='$today'
AND end_time > '$now'
ORDER BY booking_id DESC
LIMIT 1
");

if(mysqli_num_rows($query) > 0){

  $row = mysqli_fetch_assoc($query);

  $start = $row['start_time'];
  $end = $row['end_time'];

  if($now < $start){
    $status = "not_started";
  }
  elseif($now >= $start && $now <= $end){
    $status = "active";
  }
  else{
    $status = "none";
  }

}else{
  $status = "none";
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Room Details</title>

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

.success{
background:#DFFFD6;
color:#2E7D32;
padding:10px;
border-radius:10px;
margin-bottom:10px;
}

.timer{
margin-top:10px;
font-weight:bold;
color:#333;
}

.device{
display:flex;
justify-content:space-between;
margin-top:15px;
padding:12px;
background:#fff;
border-radius:10px;
cursor:pointer;
transition:0.3s;
}

.device.active{
background:#FFF9E6;
box-shadow:0 0 15px rgba(255,223,100,0.8);
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

.back{
background:#ccc;
color:black;
}
</style>

</head>

<body>

<div class="main">
<div class="box">

<?php if(isset($_GET['success'])){ ?>
<div class="success">✅ Booking successful</div>
<?php } ?>

<h2>🏠 <?php echo $room_name; ?></h2>

<?php if($status == "active"){ ?>

<p>🟢 Booking Active</p>

<div class="timer" id="timer"></div>

<div class="device" onclick="toggle(this)">💡 Light</div>
<div class="device" onclick="toggle(this)">🌀 Fan</div>
<div class="device" onclick="toggle(this)">🪟 Curtain</div>

<?php } elseif($status == "not_started"){ ?>

<p>⏳ Your booking starts at <?php echo $start; ?></p>

<?php } else { ?>

<p>⚠️ No booking found</p>
<button onclick="goBook()">Book Room</button>

<?php } ?>

<button class="back" onclick="goBack()">⬅ Back</button>

</div>
</div>

<script>
function toggle(el){
  el.classList.toggle("active");
}

function goBook(){
  window.location.href="bookroom.php?room=<?php echo $room_id; ?>";
}

function goBack(){
  window.location.href="dashboard.php";
}

let endTime = "<?php echo $end; ?>";

function updateTimer(){
  if(!endTime) return;

  let now = new Date();

  let parts = endTime.split(":");
  let end = new Date();
  end.setHours(parts[0]);
  end.setMinutes(parts[1]);
  end.setSeconds(parts[2]);

  let diff = end - now;

  if(diff <= 0){
    document.getElementById("timer").innerHTML = "⛔ Time Ended";

    setTimeout(() => {
      location.reload();
    }, 2000);

    return;
  }

  let minutes = Math.floor(diff / 60000);
  let seconds = Math.floor((diff % 60000) / 1000);

  document.getElementById("timer").innerHTML =
    "⏳ Remaining: " + minutes + "m " + seconds + "s";
}

setInterval(updateTimer,1000);
</script>

</body>
</html>