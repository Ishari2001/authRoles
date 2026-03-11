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
/* REFERRAL CARD */

.referral-card{
    background:#1e293b;
    padding:20px 25px;
    border-radius:14px;
    width:420px;
    margin-right:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.4);
}

.ref-header h3{
    color:#38bdf8;
    margin-bottom:4px;
}

.ref-header p{
    font-size:13px;
    color:#94a3b8;
    margin-bottom:15px;
}

/* LINK BOX */

.ref-link-box{
    display:flex;
    background:#0f172a;
    border-radius:8px;
    overflow:hidden;
}

.ref-link-box input{
    flex:1;
    border:none;
    padding:10px;
    background:transparent;
    color:#f1f5f9;
    font-size:13px;
}

.ref-link-box input:focus{
    outline:none;
}

/* COPY BUTTON */

.copy-btn{
    background:#6366f1;
    border:none;
    padding:10px 18px;
    color:#fff;
    font-weight:600;
    cursor:pointer;
}

.copy-btn:hover{
    background:#4f46e5;
}

/* SHARE BUTTONS */

.share-buttons{
    margin-top:12px;
    display:flex;
    gap:10px;
}

.share{
    text-decoration:none;
    padding:6px 14px;
    border-radius:6px;
    font-size:13px;
    font-weight:600;
}

.whatsapp{
    background:#25D366;
    color:#fff;
}

.telegram{
    background:#229ED9;
    color:#fff;
}
</style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    
    <div class="ref-box">
        <div class="referral-card">

    <div class="ref-header">
        <h3>Invite Friends & Earn</h3>
        <p>Share your referral link and earn commission when they buy tickets.</p>
    </div>

    <div class="ref-link-box">
        <input type="text" value="<?= $refLink ?>" id="refLink" readonly>
        <button onclick="copyLink()" class="copy-btn">Copy</button>
    </div>

    <div class="share-buttons">
        <a target="_blank" 
           href="https://wa.me/?text=Join this ticket platform <?= urlencode($refLink) ?>" 
           class="share whatsapp">WhatsApp</a>

        <a target="_blank"
           href="https://t.me/share/url?url=<?= urlencode($refLink) ?>" 
           class="share telegram">Telegram</a>
    </div>

</div>
    
</div>
</div>

<!-- HERO -->
<div class="hero">
    <h2>Digital Ticketing Experience</h2>
    <p>Buy, track, and manage e-tickets effortlessly. Get automatic rewards and stay updated with wallet balances in real time.</p>
    <a href="<?= base_url('/dashboard/index') ?>" class="btn btn-primary">Buy Ticket</a>
    <a href="<?= base_url('dashboard/profile') ?>" class="btn btn-outline">View History</a>
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
<script>
function copyLink(){
    var copyText = document.getElementById("refLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(copyText.value);
    alert("Referral Link Copied!");
}
</script>
</body>
</html>
