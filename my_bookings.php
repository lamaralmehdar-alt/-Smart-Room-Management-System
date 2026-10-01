<?php
session_start();
include("config.php");

if(!isset($_SESSION['email'])){
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['delete'])){
  $id = $_GET['delete'];

  mysqli_query($conn, "
  DELETE FROM booking 
  WHERE booking_id='$id' 
  AND user_id='$user_id'
  ");

  header("Location: my_bookings.php");
  exit();
}

$q = mysqli_query($conn, "
SELECT booking.*, room.name 
FROM booking
JOIN room ON booking.room_id = room.id
WHERE booking.user_id='$user_id'
ORDER BY booking.booking_id DESC
");

$hasBooking = ($q && mysqli_num_rows($q) > 0);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Bookings</title>

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

.card{
margin-top:15px;
padding:15px;
background:#fff;
border-radius:10px;
}

button{
width:100%;
padding:10px;
margin-top:10px;
border:none;
border-radius:10px;
background:#A8D8EA;
color:white;
cursor:pointer;
}

.delete{
background:#FF8B94;
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

<h2>📅 My Bookings</h2>

<?php if($hasBooking){ 
while($row = mysqli_fetch_assoc($q)){ ?>

<div class="card">

<p>🏠 <?php echo $row['name']; ?></p>
<p><?php echo $row['start_time']; ?> → <?php echo $row['end_time']; ?></p>

<button onclick="goRoom(<?php echo $row['room_id']; ?>)">
Go to Room
</button>

<button onclick="editBooking(<?php echo $row['room_id']; ?>)">
Edit Booking
</button>

<button class="delete" onclick="deleteBooking(<?php echo $row['booking_id']; ?>)">
Cancel Booking
</button>

</div>

<?php } } else { ?>

<p>❌ No bookings yet</p>

<button onclick="goRooms()">View Rooms</button>

<?php } ?>

<button class="back" onclick="goBack()">⬅ Back</button>

</div>
</div>

<script>
function goRoom(id){
  window.location.href="room_details.php?room="+id;
}

function goRooms(){
  window.location.href="room.php";
}

function goBack(){
  window.location.href="dashboard.php";
}

function editBooking(id){
  window.location.href="bookroom.php?room="+id+"&edit=1";
}

function deleteBooking(id){
  if(confirm("Are you sure you want to cancel this booking?")){
    window.location.href="my_bookings.php?delete="+id;
  }
}
</script>

</body>
</html>