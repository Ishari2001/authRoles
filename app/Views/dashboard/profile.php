<div class="dashboard-container">

<!-- PROFILE TOP -->
<div class="profile-top">

    <div>
        <h2>My Profile</h2>
        <p class="sub">Manage your tickets and earnings</p>
    </div>

    <div class="profile-nav">
        <a href="<?= base_url('dashboard') ?>" class="btn-buy">🎫 Buy Ticket</a>
    </div>

</div>


<!-- PROFILE HEADER -->
<div class="profile-header">

    <div class="profile-details">
        <h2><?= esc($user['name']) ?></h2>
        <p><?= esc($user['email']) ?></p>
    </div>

    <div class="wallet-box">
        <span>Wallet Balance</span>
        <h3>Rs <?= number_format($user['wallet'],2) ?></h3>
    </div>

</div>


<!-- STATS -->
<div class="stats-grid">

<div class="stat-card">
<span>Total Tickets</span>
<h3><?= count($purchases) ?></h3>
</div>

<div class="stat-card">
<span>Total Commissions</span>
<h3><?= count($commissions) ?></h3>
</div>

<div class="stat-card">
<span>Total Earnings</span>
<h3>Rs <?= number_format(array_sum(array_column($commissions,'amount')),2) ?></h3>
</div>

</div>


<!-- PURCHASED TICKETS -->
<h3>My Purchased Tickets</h3>

<?php if($purchases): ?>

<?php
$ticketCounts = [];

foreach($purchases as $p){

$id = $p['ticket_id'];

if(!isset($ticketCounts[$id])){

$ticketCounts[$id] = [
'title'=>$p['title'],
'price'=>$p['price'],
'image'=>$p['image'],
'count'=>1,
'last_purchase'=>$p['created_at']
];

}else{

$ticketCounts[$id]['count']++;
$ticketCounts[$id]['last_purchase']=$p['created_at'];

}

}
?>

<div class="ticket-grid">

<?php foreach($ticketCounts as $t): ?>

<div class="ticket-card">

<div class="ticket-image">

<?php if(!empty($t['image'])): ?>

<img src="<?= base_url('uploads/tickets/'.$t['image']) ?>">

<?php else: ?>

<img src="<?= base_url('uploads/no-image.png') ?>">

<?php endif; ?>

</div>

<div class="ticket-info">

<h4><?= esc($t['title']) ?></h4>

<p><b>Price:</b> Rs <?= number_format($t['price'],2) ?></p>

<p><b>Quantity:</b> <?= $t['count'] ?></p>


<!-- <p><b>Last Purchase:</b><br>

<?php

$date=date('Y-m-d',strtotime($t['last_purchase']));
$today=date('Y-m-d');

if($date==$today){

echo "Today";

}else{

echo date('d M Y',strtotime($t['last_purchase']));

}

?> -->



</p>

</div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<p class="no-data">No purchases yet</p>

<?php endif; ?>


<!-- COMMISSIONS -->

<h3>My Commission Earnings</h3>

<?php if($commissions): ?>

<div class="commission-grid">

<?php foreach($commissions as $c): ?>

<div class="commission-card">

<div class="commission-image">

<?php if(!empty($c['ticket_image'])): ?>

<img src="<?= base_url('uploads/tickets/'.$c['ticket_image']) ?>">

<?php else: ?>

<img src="<?= base_url('uploads/no-image.png') ?>">

<?php endif; ?>

</div>

<div class="commission-info">

<h4>

<?php

if(!empty($c['ticket_title'])){

echo esc($c['ticket_title']);

}else{

echo "Ticket";

}

?>

</h4>

<p><b>From User:</b> <?= esc($c['from_user']) ?></p>

<p><b>Commission:</b>
<span class="amount">Rs <?= number_format($c['amount'],2) ?></span>
</p>



<!-- <p><b>Date:</b><br>

<?php

$date=date('Y-m-d',strtotime($c['created_at']));
$today=date('Y-m-d');

if($date==$today){

echo "Today";

}else{

echo date('d M Y',strtotime($c['created_at']));

}

?> -->

</p>

</div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>

<p class="no-data">No commissions yet.</p>

<?php endif; ?>


</div>



<style>

/* GLOBAL */

body{
font-family:'Inter',sans-serif;
background:#0f172a;
margin:0;
padding:40px;
color:#e2e8f0;
}

.dashboard-container{
max-width:1200px;
margin:auto;
}


/* TOP BAR */

.profile-top{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

.profile-top h2{
margin:0;
font-size:28px;
}

.sub{
color:#94a3b8;
font-size:14px;
}


/* BUTTON */

.btn-buy{
background:#6366f1;
padding:10px 18px;
border-radius:8px;
text-decoration:none;
color:#fff;
font-weight:600;
}

.btn-buy:hover{
background:#4f46e5;
}


/* PROFILE HEADER */

.profile-header{
display:flex;
justify-content:space-between;
align-items:center;
background:#1e293b;
padding:28px;
border-radius:16px;
box-shadow:0 10px 30px rgba(0,0,0,.4);
margin-bottom:30px;
}

.profile-details h2{
margin:0;
}

.profile-details p{
color:#94a3b8;
margin-top:6px;
}


/* WALLET */

.wallet-box span{
color:#94a3b8;
font-size:13px;
}

.wallet-box h3{
margin-top:6px;
font-size:24px;
color:#38bdf8;
}


/* STATS */

.stats-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:20px;
margin-bottom:40px;
}

.stat-card{
background:#1e293b;
padding:22px;
border-radius:14px;
border:1px solid #334155;
}

.stat-card span{
font-size:13px;
color:#94a3b8;
}

.stat-card h3{
margin-top:6px;
color:#38bdf8;
}


/* SECTION TITLE */

h3{
margin-top:40px;
margin-bottom:18px;
color:#38bdf8;
}


/* GRID */

.ticket-grid,
.commission-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
gap:22px;
}


/* CARDS */

.ticket-card,
.commission-card{
background:#1e293b;
border-radius:16px;
overflow:hidden;
border:1px solid #334155;
transition:.25s;
}

.ticket-card:hover,
.commission-card:hover{
transform:translateY(-6px);
box-shadow:0 15px 35px rgba(0,0,0,.6);
}


/* IMAGE */

.ticket-image img,
.commission-image img{
width:100%;
height:170px;
object-fit:cover;
}


/* INFO */

.ticket-info,
.commission-info{
padding:18px;
}

.ticket-info h4,
.commission-info h4{
margin:0 0 8px 0;
}

.ticket-info p,
.commission-info p{
font-size:14px;
color:#cbd5e1;
}


/* COMMISSION COLOR */

.amount{
color:#22c55e;
font-weight:600;
}


/* EMPTY */

.no-data{
padding:25px;
text-align:center;
background:#1e293b;
border-radius:12px;
border:1px dashed #334155;
color:#94a3b8;
}


/* MOBILE */

@media(max-width:768px){

body{
padding:20px;
}

.profile-top{
flex-direction:column;
align-items:flex-start;
gap:10px;
}

.profile-header{
flex-direction:column;
align-items:flex-start;
gap:15px;
}

}

</style>