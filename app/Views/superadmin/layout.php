<!DOCTYPE html>
<html>
<head>
<title>Super Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:#020617;
    color:#e2e8f0;
    display:flex;
}

/* SIDEBAR */
.sidebar{
    width:250px;
    height:100vh;
    background:linear-gradient(180deg,#0f172a,#020617);
    padding:25px 15px;
    position:fixed;
    border-right:1px solid #1e293b;
}

.sidebar h2{
    color:#38bdf8;
    text-align:center;
    margin-bottom:30px;
    font-weight:700;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 15px;
    color:#cbd5e1;
    text-decoration:none;
    border-radius:10px;
    margin-bottom:8px;
    transition:0.3s;
}

.sidebar a:hover{
    background:#1e293b;
    transform:translateX(5px);
    color:#fff;
}

.sidebar a.active{
    background:#38bdf8;
    color:#000;
    font-weight:600;
}

/* MAIN */
.main{
    margin-left:250px;
    width:100%;
    padding:30px 40px;
}

/* TOPBAR */
.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.topbar h2{
    font-size:22px;
    font-weight:600;
}

.topbar span{
    background:#1e293b;
    padding:8px 15px;
    border-radius:8px;
    font-size:13px;
}

/* CARD */
.card{
    background:#0f172a;
    padding:20px;
    border-radius:16px;
    border:1px solid #1e293b;
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 20px 40px rgba(0,0,0,0.6);
}

/* STATS GRID */
.stats{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-top:20px;
}

.stat-card{
    background:linear-gradient(135deg,#1e293b,#0f172a);
    padding:20px;
    border-radius:16px;
    border:1px solid #334155;
    position:relative;
    overflow:hidden;
}

.stat-card h4{
    font-size:14px;
    color:#94a3b8;
}

.stat-card h2{
    margin-top:10px;
    font-size:26px;
    color:#38bdf8;
}

.stat-card::after{
    content:'';
    position:absolute;
    width:100px;
    height:100px;
    background:#38bdf8;
    opacity:0.1;
    border-radius:50%;
    top:-30px;
    right:-30px;
}

/* RESPONSIVE */
@media(max-width:768px){
    .sidebar{display:none;}
    .main{margin-left:0;}
}
</style>

</head>

<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Super Admin</h2>

    <a href="<?= base_url('superadmin/dashboard') ?>" class="active">Dashboard</a>
    <a href="<?= base_url('superadmin/users') ?>">Users</a>
    <a href="<?= base_url('superadmin/tickets') ?>">Tickets</a>
    <a href="<?= base_url('superadmin/commissions') ?>">Commissions</a>
    <a href="<?= base_url('admin/login') ?>">Logout</a>
</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <h2>Dashboard Overview</h2>
        <span>👋 Welcome Admin</span>
    </div>

    <!-- STATS -->
    <div class="stats">

        <div class="stat-card">
            <h4>Total Users</h4>
            <h2><?= $totalUsers ?></h2>
        </div>

        <div class="stat-card">
            <h4>Total Tickets</h4>
            <h2><?= $totalTickets ?></h2>
        </div>

        <div class="stat-card">
            <h4>Total Sales</h4>
            <h2>Rs <?= number_format($totalSales,2) ?></h2>
        </div>

        <div class="stat-card">
            <h4>Total Commission</h4>
            <h2>Rs <?= number_format($totalCommission,2) ?></h2>
        </div>

    </div>

   
</div>

</body>
</html>