<?php
session_start();
include("config.php");

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
  header("Location: login.php");
  exit();
}

$section = isset($_GET['section']) ? $_GET['section'] : 'rooms';

if(isset($_POST['update_user'])){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(!empty($password)){
    mysqli_query($conn,"UPDATE users SET name='$name', email='$email', password='$password' WHERE user_id='$id'");
  }else{
    mysqli_query($conn,"UPDATE users SET name='$name', email='$email' WHERE user_id='$id'");
  }
}

if(isset($_POST['update_admin'])){
  $id = $_SESSION['user_id'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  if(!empty($password)){
    mysqli_query($conn,"UPDATE users SET name='$name', email='$email', password='$password' WHERE user_id='$id'");
  }else{
    mysqli_query($conn,"UPDATE users SET name='$name', email='$email' WHERE user_id='$id'");
  }

  $_SESSION['name'] = $name;
  $_SESSION['email'] = $email;
}

if(isset($_POST['add_room'])){
  $name = $_POST['room_name'];
  mysqli_query($conn,"INSERT INTO room (name) VALUES ('$name')");
}

if(isset($_GET['delete_room'])){
  $id = $_GET['delete_room'];
  mysqli_query($conn,"DELETE FROM room WHERE id='$id'");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel</title>

<style>
body {
  margin:0;
  font-family:'Segoe UI';
  display:flex;
  background:
  linear-gradient(rgba(168,216,234,0.3),rgba(214,198,255,0.3)),
  url("images/bg2.jpg");
  background-size:cover;
  background-position:center;
}

.sidebar {
  width:240px;
  height:100vh;
  background:linear-gradient(180deg,#A8D8EA,#D6C6FF);
  padding:25px;
  color:white;
  box-shadow:0 0 25px rgba(0,0,0,0.1);
}

.sidebar h2 {
  margin-bottom:40px;
}

.sidebar a {
  display:block;
  padding:12px;
  margin-bottom:12px;
  text-decoration:none;
  color:white;
  border-radius:12px;
  transition:0.3s;
}

.sidebar a:hover {
  background:rgba(255,255,255,0.2);
  transform:translateX(8px) scale(1.05);
}

.sidebar a.active {
  background:rgba(255,255,255,0.3);
}

.main {
  flex:1;
  padding:30px;
}

.rooms {
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:20px;
}

.room-card {
  background:rgba(255,255,255,0.8);
  backdrop-filter:blur(15px);
  padding:20px;
  border-radius:18px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  transition:0.3s;
}

.room-card:hover {
  transform:translateY(-8px) scale(1.03);
}

input {
  padding:6px;
  border-radius:8px;
  border:none;
}

button {
  background:#FF8B94;
  color:white;
  border:none;
  padding:8px 12px;
  border-radius:8px;
  cursor:pointer;
}
</style>

</head>

<body>

<div class="sidebar">
  <h2>Admin 👑</h2>

  <a class="<?php echo $section=='rooms'?'active':'' ?>" href="admin.php?section=rooms">Rooms</a>
  <a class="<?php echo $section=='users'?'active':'' ?>" href="admin.php?section=users">Users</a>
  <a class="<?php echo $section=='account'?'active':'' ?>" href="admin.php?section=account">My Account</a>
  <a href="dashboard.php">⬅ Back</a>
  <a href="logout.php">Logout</a>
</div>

<div class="main">

<?php if($section == 'rooms'){ ?>

<h2>Rooms 🏠</h2>

<form method="POST" style="margin-bottom:20px;">
  <input type="text" name="room_name" placeholder="New Room Name" required>
  <button name="add_room">Add Room</button>
</form>

<div class="rooms">

<?php
$rooms = mysqli_query($conn,"SELECT * FROM room");
while($room = mysqli_fetch_assoc($rooms)){
?>

<div class="room-card">

<div>
  🏠 <?php echo $room['name']; ?><br>
  <small>ID: <?php echo $room['id']; ?></small>
</div>

<a href="admin.php?section=rooms&delete_room=<?php echo $room['id']; ?>">
  <button>Delete</button>
</a>

</div>

<?php } ?>

</div>

<?php } ?>


<?php if($section == 'users'){ ?>

<h2>Users 👥</h2>

<?php
$result = mysqli_query($conn, "SELECT * FROM users");
while($row = mysqli_fetch_assoc($result)){
?>

<div class="room-card"><form method="POST" style="display:flex; gap:10px; align-items:center; width:100%;">

<input type="hidden" name="id" value="<?php echo $row['user_id']; ?>">

<input type="text" name="name" value="<?php echo $row['name']; ?>" style="width:120px;">

<input type="email" name="email" value="<?php echo $row['email']; ?>" style="width:160px;">

<input type="password" name="password" placeholder="New Pass" style="width:120px;">

<button name="update_user">Update</button>

<?php if($row['email'] != $_SESSION['email']){ ?>
<a href="delete_user.php?id=<?php echo $row['user_id']; ?>">
  <button type="button">Delete</button>
</a>
<?php } else { ?>
<small>You</small>
<?php } ?>

</form>

</div>

<?php } ?>

<?php } ?>


<?php if($section == 'account'){ ?>

<h2>My Account 👤</h2>

<form method="POST" class="rooms">

<div class="room-card">
  <div>
    🪪 Name<br>
    <input type="text" name="name" value="<?php echo $_SESSION['name']; ?>">
  </div>
</div>

<div class="room-card">
  <div>
    📧 Email<br>
    <input type="email" name="email" value="<?php echo $_SESSION['email']; ?>">
  </div>
</div>

<div class="room-card">
  <div>
    🔐 New Password<br>
    <input type="password" name="password" placeholder="Leave empty if no change">
  </div>
</div>

<button name="update_admin">Save Changes</button>

</form>

<?php } ?>

</div>

</body>
</html>