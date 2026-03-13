<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Inter',sans-serif;
}

body{
background:#0f172a;
color:#f1f5f9;
}

/* NAVBAR */

.header{
background:#1e293b;
padding:18px 8%;
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:1px solid #334155;
}

.header h3{
color:#38bdf8;
font-size:20px;
}

.header-actions{
display:flex;
gap:12px;
}

.nav-btn{
text-decoration:none;
padding:8px 14px;
border-radius:6px;
font-size:14px;
font-weight:600;
color:white;
}

.profile-btn{
background:#6366f1;
}

.logout-btn{
background:#ef4444;
}

/* CONTAINER */

.container{
padding:40px 8%;
}

/* GRID */

.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
gap:25px;
}

/* DASHBOARD CARDS */

.card{
background:#1e293b;
padding:25px;
border-radius:14px;
box-shadow:0 8px 25px rgba(0,0,0,.3);
transition:.3s;
}

.card:hover{
transform:translateY(-6px);
}

.card h3{
color:#38bdf8;
margin-bottom:10px;
}

/* SUCCESS / ERROR */

.success{
background:#16a34a20;
padding:10px;
border-radius:6px;
margin-bottom:10px;
}

.error{
background:#ef444420;
padding:10px;
border-radius:6px;
margin-bottom:10px;
}

/* TICKETS */

.ticket-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
gap:20px;
margin-top:20px;
}

.ticket-card{
background:#1e293b;
border-radius:12px;
overflow:hidden;
box-shadow:0 8px 20px rgba(0,0,0,.4);
transition:.3s;
}

.ticket-card:hover{
transform:translateY(-5px);
}

.ticket-card img{
width:100%;
height:160px;
object-fit:cover;
}

.ticket-info{
padding:15px;
}

.ticket-info h4{
margin-bottom:6px;
}

.ticket-info p{
font-size:14px;
color:#cbd5f5;
margin-bottom:4px;
}

.buy-btn{
margin-top:8px;
padding:8px 14px;
background:#6366f1;
border:none;
color:white;
border-radius:6px;
cursor:pointer;
}

.buy-btn:hover{
background:#4f46e5;
}

/* MOBILE */

@media(max-width:768px){

.header{
flex-direction:column;
gap:10px;
text-align:center;
}

.container{
padding:25px;
}

}

</style>
</head>

<body>

<!-- HEADER -->

<div class="header">

<h3>Welcome <?= esc($name) ?></h3>

<div class="header-actions">
<a href="<?= base_url('dashboard/profile') ?>" class="nav-btn profile-btn">My Profile</a>
<a href="<?= base_url('auth/logout') ?>" class="nav-btn logout-btn">Logout</a>
</div>

</div>


<div class="container">

<div class="grid">

<?php if($role == 1): ?>
<div class="card">
<h3>Admin Panel</h3>
<p>Manage users</p>
<p>System settings</p>
<p>View reports</p>
</div>
<?php endif; ?>


<?php if($role == 2 || $role == 1): ?>
<div class="card">
<h3>Author Tools</h3>
<p>Create articles</p>
<p>Edit posts</p>
</div>
<?php endif; ?>


<?php if($role == 3 || $role == 1): ?>
<div class="card">
<h3>Reader Access</h3>
<p>View articles only</p>
</div>
<?php endif; ?>

</div>



<?php if($role == 4 || $role == 1): ?>

<div class="card" style="margin-top:30px">

<h3>Purchase E-Ticket</h3>

<?php if(session()->getFlashdata('success')): ?>
<p class="success"><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>
<p class="error"><?= session()->getFlashdata('error') ?></p>
<?php endif; ?>


<?php if(!empty($tickets)): ?>

<div class="ticket-grid">

<?php foreach($tickets as $t): ?>

<div class="ticket-card">

<?php if($t['image']): ?>
<img src="<?= base_url('uploads/tickets/'.$t['image']) ?>">
<?php endif; ?>

<div class="ticket-info">

<h4><?= esc($t['title']) ?></h4>

<p>Price: Rs <?= number_format($t['price'],2) ?></p>
<p>Available: <?= $t['qty'] ?></p>
<p>Event: <?= $t['event_date'] ?></p>

<form method="post" action="<?= base_url('dashboard/purchaseTicket') ?>">
<input type="hidden" name="ticket_id" value="<?= $t['id'] ?>">

<button class="buy-btn">Purchase Ticket</button>

</form>

</div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<p>No tickets available.</p>

<?php endif; ?>

</div>

<?php endif; ?>

</div>

</body>
</html>