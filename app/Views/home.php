<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>E-Ticket Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
*{ margin:0; padding:0; box-sizing:border-box; font-family:'Inter',sans-serif; }
body{ background:#0f172a; color:#f1f5f9; }

/* NAVBAR */
.navbar {
    display:flex; justify-content:space-between; align-items:center;
    padding:20px 8%; background:#1e293b;
}
.navbar h1 { font-size:24px; font-weight:700; color:#38bdf8; }
.navbar a { color:#f1f5f9; text-decoration:none; margin-left:20px; padding:6px 12px; border-radius:6px; transition:.3s; }
.navbar a:hover { background:#334155; }

/* HERO */
.hero {
    text-align:center; padding:60px 8%; background:#1e293b; border-radius:16px; margin:20px 8%;
}
.hero h2 { font-size:42px; margin-bottom:15px; background:linear-gradient(to right,#38bdf8,#818cf8); -webkit-background-clip:text; color:transparent; }
.hero p { font-size:18px; margin-bottom:30px; color:#cbd5e1; }

/* BUTTONS */
.btn { text-decoration:none; padding:12px 24px; border-radius:8px; font-weight:600; transition:.3s; }
.btn-primary{ background:#6366f1; color:#fff; margin-right:15px; }
.btn-primary:hover{ background:#4f46e5; }
.btn-outline{ border:1px solid #f1f5f9; color:#f1f5f9; }
.btn-outline:hover{ background:rgba(255,255,255,0.1); }

/* CARDS */
.cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(260px,1fr)); gap:25px; padding:50px 8%; }
.card {
    background:#1e293b; padding:30px; border-radius:16px; transition:.3s;
    box-shadow:0 4px 15px rgba(0,0,0,.3);
}
.card:hover { transform:translateY(-8px); box-shadow:0 10px 25px rgba(0,0,0,.5); }
.card h3{ font-size:20px; margin-bottom:12px; color:#38bdf8; }
.card p{ color:#cbd5e1; }

/* STATS SECTION */
.stats {
    display:flex; justify-content:space-around; flex-wrap:wrap; padding:50px 8%; gap:25px;
}
.stat {
    background:#1e293b; flex:1; min-width:200px; padding:30px; border-radius:16px; text-align:center;
    box-shadow:0 4px 15px rgba(0,0,0,.3);
}
.stat h3 { font-size:28px; color:#38bdf8; margin-bottom:10px; }
.stat p { color:#cbd5e1; }

/* FOOTER */
.footer { text-align:center; padding:30px; color:#64748b; border-top:1px solid #334155; }
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <h1>E-Ticket Platform</h1>
    <div>
        <a href="<?= base_url('/dashboard') ?>">Dashboard</a>
        <a href="<?= base_url('/purchase') ?>">Purchase Ticket</a>
        <a href="<?= base_url('/logout') ?>">Logout</a>
    </div>
</div>

<!-- HERO -->
<div class="hero">
    <h2>Digital Ticketing Experience</h2>
    <p>Buy, track, and manage e-tickets effortlessly. Get automatic rewards and stay updated with wallet balances in real time.</p>
    <a href="<?= base_url('/purchase') ?>" class="btn btn-primary">Buy Ticket</a>
    <a href="<?= base_url('/history') ?>" class="btn btn-outline">View History</a>
</div>

<!-- STATS -->
<div class="stats">
   
    <div class="stat">
        <h3>15</h3>
        <p>Tickets Purchased</p>
    </div>
    <div class="stat">
        <h3>10</h3>
        <p>Active Referrals</p>
    </div>
    
</div>

<!-- FEATURES CARDS -->
<div class="cards">
    <div class="card">
        <h3>Instant Ticket Purchase</h3>
        <p>Buy tickets in seconds with a secure and reliable digital workflow.</p>
    </div>
    <div class="card">
        <h3>Automatic Rewards</h3>
        <p>Earn referral bonuses instantly without any manual calculations.</p>
    </div>
    <div class="card">
        <h3>Wallet Management</h3>
        <p>Track all your transactions and wallet balances clearly from your dashboard.</p>
    </div>
    <div class="card">
        <h3>Secure & Transparent</h3>
        <p>All operations are logged and visible for full transparency and peace of mind.</p>
    </div>
</div>

<!-- FOOTER -->
<div class="footer">
© <?= date('Y') ?> E-Ticket Platform — Modern & Secure
</div>

</body>
</html>
