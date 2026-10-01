<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Smart Room</title>

<style>
body {
  margin:0;
  font-family:'Segoe UI';
  height:100vh;
  display:flex;
  justify-content:center;
  align-items:center;
  overflow:hidden;
  background:
  linear-gradient(rgba(168,216,234,0.4),rgba(214,198,255,0.4)),
  url("images/bg.jpg");
  background-size:cover;
  background-position:center;
}

.stars {
  position:absolute;
  width:100%;
  height:100%;
  top:0;
  left:0;
  z-index:0;
}

.star {
  position:absolute;
  width:3px;
  height:3px;
  background:white;
  border-radius:50%;
  opacity:0.7;
  animation: twinkle 3s infinite ease-in-out;
}

@keyframes twinkle {
  0%,100% {opacity:0.2;}
  50% {opacity:1;}
}

.container {
  position:relative;
  z-index:2;
  background:white;
  padding:60px 50px;
  border-radius:25px;
  text-align:center;
  width:360px;
  box-shadow:0 25px 60px rgba(0,0,0,0.2);
  animation:fade 1s ease;
}

@keyframes fade {
  from {opacity:0; transform:translateY(30px);}
  to {opacity:1; transform:translateY(0);}
}

.logo {
  margin-bottom:15px;
}

.logo img {
  width:300px; 
}

.title {
  font-size:26px;
  font-weight:bold;
  color:#222;
}

.subtitle {
  color:#444;
  margin:10px 0 20px;
  font-size:14px;
}

.tagline {
  font-size:13px;
  color:#555;
  margin-bottom:25px;
}

button {
  width:100%;
  padding:14px;
  margin:10px 0;
  border:none;
  border-radius:12px;
  font-size:16px;
  cursor:pointer;
  transition:0.3s;
}

.login {
  background:#5DADE2; 
  color:white;
}

.signup {
  background:#BB8FCE; 
  color:white;
}

button:hover {
  transform:scale(1.05);
  opacity:0.9;
}
</style>

</head>

<body>

<div class="stars" id="stars"></div>

<div class="container">

<div class="logo">
<img src="images/logo.jpg">
</div>

<div class="title">Smart Room</div>

<div class="subtitle">
Control your space effortlessly
</div>

<div class="tagline">
Where technology meets tranquility
</div>

<button class="login" onclick="goLogin()">Login</button>
<button class="signup" onclick="goRegister()">Create Account</button>

</div>

<script>
function goLogin(){
  window.location.href="login.php";
}

function goRegister(){
  window.location.href="register.php";
}

const starsContainer = document.getElementById("stars");

for(let i=0;i<60;i++){
  let star = document.createElement("div");
  star.className="star";
  star.style.top=Math.random()*100+"%";
  star.style.left=Math.random()*100+"%";
  star.style.animationDuration=(Math.random()*3+2)+"s";
  starsContainer.appendChild(star);
}
</script>

</body>
</html>