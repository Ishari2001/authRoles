<!DOCTYPE html>
<html>
<head>
<title>Super Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

<style>

body{
margin:0;
font-family:'Inter',sans-serif;
background:#0f172a;
color:#e2e8f0;
display:flex;
}

/* SIDEBAR */

.sidebar{
width:240px;
background:#1e293b;
height:100vh;
padding:20px;
position:fixed;
}

.sidebar h2{
color:#38bdf8;
margin-bottom:30px;
}

.sidebar a{
display:block;
color:#cbd5e1;
padding:12px;
border-radius:8px;
text-decoration:none;
margin-bottom:8px;
}

.sidebar a:hover{
background:#334155;
}

/* MAIN */

.main{
margin-left:240px;
width:100%;
padding:30px;
}

/* TOPBAR */

.topbar{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

.card{
background:#1e293b;
padding:20px;
border-radius:12px;
border:1px solid #334155;
margin-bottom:20px;
}

</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
<h2>Admin Panel</h2>

<a href="<?= base_url('superadmin/dashboard') ?>">Dashboard</a>
<a href="<?= base_url('superadmin/users') ?>">Users</a>
<a href="<?= base_url('superadmin/tickets') ?>">Tickets</a>
<a href="<?= base_url('superadmin/commissions') ?>">Commissions</a>
<a href="<?= base_url('admin/login') ?>">Logout</a>
</div>

<!-- MAIN -->
<div class="main">
    <div class="card">
<h3>System Overview</h3>

<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:20px;">

<div class="card">
Total Users<br>
<h2><?= $totalUsers ?></h2>
</div>

<div class="card">
Total Tickets<br>
<h2><?= $totalTickets ?></h2>
</div>

<div class="card">
Total Sales<br>
<h2>Rs <?= number_format($totalSales,2) ?></h2>
</div>

<div class="card">
Total Commission<br>
<h2>Rs <?= number_format($totalCommission,2) ?></h2>
</div>

</div>

</div>

<div class="topbar">
<h2>Dashboard</h2>
<span>Welcome Admin</span>
</div>