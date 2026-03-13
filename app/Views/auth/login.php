<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>System Login</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Inter',sans-serif;
}

body{
height:100vh;
background:#0f172a;
display:flex;
justify-content:center;
align-items:center;
color:#e2e8f0;
}

/* BACKGROUND EFFECT */

body::before{
content:"";
position:absolute;
width:450px;
height:450px;
background:#6366f1;
filter:blur(180px);
opacity:.35;
top:-120px;
left:-120px;
}

body::after{
content:"";
position:absolute;
width:450px;
height:450px;
background:#38bdf8;
filter:blur(180px);
opacity:.35;
bottom:-120px;
right:-120px;
}

/* LOGIN CARD */

.login-container{
position:relative;
width:380px;
background:#1e293b;
padding:40px;
border-radius:16px;
box-shadow:0 25px 60px rgba(0,0,0,.6);
border:1px solid #334155;
animation:fadeIn .6s ease;
}

/* ANIMATION */

@keyframes fadeIn{
from{
opacity:0;
transform:translateY(30px);
}
to{
opacity:1;
transform:translateY(0);
}
}

/* TITLE */

h2{
text-align:center;
margin-bottom:28px;
font-weight:600;
color:#f1f5f9;
}

/* ERROR */

.error{
background:#7f1d1d;
color:#fecaca;
padding:12px;
margin-bottom:18px;
border-radius:8px;
font-size:14px;
}

/* INPUT GROUP */

.input-group{
margin-bottom:18px;
}

.input-group label{
font-size:13px;
color:#94a3b8;
display:block;
margin-bottom:6px;
}

/* INPUT */

.input-group input{
width:100%;
padding:12px;
background:#0f172a;
border:1px solid #334155;
border-radius:8px;
color:#e2e8f0;
font-size:14px;
transition:.25s;
}

.input-group input:focus{
outline:none;
border-color:#38bdf8;
box-shadow:0 0 8px rgba(56,189,248,.4);
}

/* BUTTON */

button{
width:100%;
padding:13px;
margin-top:10px;
background:#6366f1;
border:none;
border-radius:8px;
color:white;
font-size:15px;
font-weight:600;
cursor:pointer;
transition:.25s;
}

button:hover{
background:#4f46e5;
transform:translateY(-2px);
box-shadow:0 8px 20px rgba(99,102,241,.4);
}

/* REGISTER LINK */

.register-link{
text-align:center;
margin-top:18px;
font-size:14px;
color:#94a3b8;
}

.register-link a{
color:#38bdf8;
text-decoration:none;
font-weight:600;
}

.register-link a:hover{
text-decoration:underline;
}

/* MOBILE */

@media(max-width:480px){

.login-container{
width:90%;
padding:30px;
}

}

</style>
</head>

<body>

<div class="login-container">

<h2>Login to System</h2>

<!-- ERROR MESSAGE -->
<?php if(session()->getFlashdata('error')): ?>
<div class="error">
<?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<form method="post" action="<?= base_url('/doLogin') ?>">

<div class="input-group">
<label>Email Address</label>
<input type="email" name="email" placeholder="Enter your email" required>
</div>

<div class="input-group">
<label>Password</label>
<input type="password" name="password" placeholder="Enter your password" required>
</div>

<button type="submit">
Login
</button>

<div class="register-link">
Don't have an account?
<a href="<?= base_url('/register') ?>">Register</a>
</div>

</form>

</div>

</body>
</html>