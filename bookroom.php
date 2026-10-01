<?php
session_start();
include("config.php");

date_default_timezone_set("Asia/Riyadh");

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}

if(!isset($_GET['room'])){
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

$start_date = $_POST['start_date'] ?? "";
$end_date = $_POST['end_date'] ?? "";
$start_time = $_POST['start_time'] ?? "";
$end_time = $_POST['end_time'] ?? "";

if(isset($_POST['book'])){

  $today = date("Y-m-d");

  if($start_date < $today){
    echo "<script>alert('Start date cannot be in the past');</script>";
  }
  elseif($end_date < $start_date){
    echo "<script>alert('End date must be after start date');</script>";
  }
  elseif($start_time >= $end_time){
    echo "<script>alert('End time must be after start time');</script>";
  }
  else{

    $check = mysqli_query($conn,"
    SELECT * FROM booking 
    WHERE room_id='$room_id'
    AND (
      ('$start_date' BETWEEN booking_date AND end_date)
      OR ('$end_date' BETWEEN booking_date AND end_date)
      OR (booking_date BETWEEN '$start_date' AND '$end_date')
    )
    ");

    if(mysqli_num_rows($check) > 0){
      echo "<script>alert('Room already booked in this period');</script>";
    } else {

      mysqli_query($conn,"
      INSERT INTO booking 
      (user_id, room_id, booking_date, end_date, start_time, end_time)
      VALUES 
      ('$user_id','$room_id','$start_date','$end_date','$start_time','$end_time')
      ");

      echo "<script>
      window.location.href='room_details.php?room=$room_id&success=1';
      </script>";
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Book Room</title>

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

input{
width:100%;
padding:10px;
margin-top:10px;
border:none;
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

.back{
background:#ccc;
color:black;
}
</style>

</head>

<body>

<div class="main">
<div class="box">

<h2>🏠 <?php echo $room_name; ?></h2>

<form method="POST">

<label>Start Date</label>
<input type="date" name="start_date" required>

<label>End Date</label>
<input type="date" name="end_date" required>

<label>Start Time</label>
<input type="time" name="start_time" required>

<label>End Time</label>
<input type="time" name="end_time" required>

<button name="book">Confirm Booking</button>

</form>

<button class="back" onclick="goBack()">⬅ Back</button>

</div>
</div>

<script>
function goBack(){
  window.location.href="room.php";
}
</script>

</body>
</html>