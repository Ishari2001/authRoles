<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Registration</title>

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

/* REGISTER CARD */

.box{
position:relative;
width:420px;
background:#1e293b;
padding:40px;
border-radius:16px;
border:1px solid #334155;
box-shadow:0 25px 60px rgba(0,0,0,.6);
animation:fadeIn .6s ease;
}

@keyframes fadeIn{
from{opacity:0;transform:translateY(30px);}
to{opacity:1;transform:translateY(0);}
}

/* TITLE */

h2{
text-align:center;
margin-bottom:25px;
font-weight:600;
color:#f1f5f9;
}

/* INPUT */

input{
width:100%;
padding:12px;
margin-bottom:14px;
background:#0f172a;
border:1px solid #334155;
border-radius:8px;
color:#e2e8f0;
font-size:14px;
transition:.25s;
}

input:focus{
outline:none;
border-color:#38bdf8;
box-shadow:0 0 8px rgba(56,189,248,.4);
}

/* BUTTON */

button{
width:100%;
padding:13px;
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

/* ERROR */

.error{
background:#7f1d1d;
color:#fecaca;
padding:12px;
margin-bottom:16px;
border-radius:8px;
font-size:14px;
}

/* SUCCESS */

.success{
background:#064e3b;
border:1px solid #10b981;
color:#d1fae5;
padding:16px;
margin-bottom:18px;
border-radius:10px;
font-size:14px;
}

/* SPONSOR NAME */

#sponsor_name{
font-size:13px;
margin-top:-8px;
margin-bottom:14px;
color:#38bdf8;
font-weight:600;
}

/* LOGIN LINK */

.login-link{
text-align:center;
margin-top:18px;
font-size:14px;
color:#94a3b8;
}

.login-link a{
color:#38bdf8;
text-decoration:none;
font-weight:600;
}

.login-link a:hover{
text-decoration:underline;
}

/* MOBILE */

@media(max-width:480px){

.box{
width:90%;
padding:30px;
}

}

</style>

<script>
function checkSponsor(id){

if(id === ''){
document.getElementById('sponsor_name').innerText='';
return;
}

fetch('<?= base_url("getSponsorName") ?>?id=' + id)
.then(response=>response.json())
.then(data=>{

if(data.name){
document.getElementById('sponsor_name').innerText="Sponsor Name: "+data.name;
}else{
document.getElementById('sponsor_name').innerText="Invalid Sponsor ID";
}

});

}
</script>

</head>

<body>

<div class="box">

<h2>Create Your Account</h2>

<!-- ERROR -->
<?php if(session()->getFlashdata('error')): ?>
<div class="error">
<?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>


<!-- SUCCESS -->
<?php if(session()->getFlashdata('success')): ?>

<div class="success">

<p><?= session()->getFlashdata('success') ?></p>

<hr style="margin:10px 0;border-color:#065f46">

<p><strong>Your User ID:</strong>
<?= session()->getFlashdata('new_user_id') ?>
</p>

<?php if(session()->getFlashdata('sponsor_id')): ?>

<p><strong>Registered Under Sponsor ID:</strong>
<?= session()->getFlashdata('sponsor_id') ?>
</p>

<p><strong>Sponsor Name:</strong>
<?= session()->getFlashdata('sponsor_name') ?>
</p>

<?php else: ?>

<p><strong>No Sponsor Used.</strong> You are an Independent User.</p>

<?php endif; ?>

<p style="margin-top:10px;color:#94a3b8;">
⚠️ Save your User ID. Others must use this ID to join under you.
</p>

</div>

<?php endif; ?>


<form method="post" action="<?= base_url('saveUser') ?>">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email Address" required>

<input type="password" name="password" placeholder="Password" required>

<!-- OPTIONAL SPONSOR -->
<!--
<input type="number" name="sponsor_id" placeholder="Sponsor User ID (Optional)" oninput="checkSponsor(this.value)">
<span id="sponsor_name"></span>
-->

<button type="submit">Create Account</button>

<div class="login-link">
Already have an account?
<a href="<?= base_url('/login') ?>">Login</a>
</div>

</form>

</div>

</body>
</html>