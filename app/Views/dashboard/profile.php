<h2>My Profile</h2>

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
<h3>
Rs <?= number_format(array_sum(array_column($commissions,'amount')),2) ?>
</h3>
</div>

</div>

<div class="card">
<h3>My Purchased Tickets</h3>

<?php if($purchases): ?>

<?php
$ticketCounts = [];
foreach($purchases as $p){
    $id = $p['ticket_id'];

    if(!isset($ticketCounts[$id])){
        $ticketCounts[$id] = [
            'title' => $p['title'],
            'price' => $p['price'],
            'image' => $p['image'],
            'count' => 1,
            'last_purchase' => $p['created_at']
        ];
    }else{
        $ticketCounts[$id]['count']++;
        $ticketCounts[$id]['last_purchase'] = $p['created_at'];
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

        <p><b>Last Purchase:</b><br><?= $t['last_purchase'] ?></p>

    </div>

</div>

<?php endforeach; ?>

</div>

<?php else: ?>
<p class="no-data">No purchases yet</p>
<?php endif; ?>
</div>


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
        } else {
            echo "Ticket";
        }
        ?>
        </h4>

        <p><b>From User:</b> <?= esc($c['from_user']) ?></p>

        <p><b>Commission:</b>  
        <span class="amount">Rs <?= number_format($c['amount'],2) ?></span>
        </p>

        <p><b>Date:</b><br><?= $c['created_at'] ?></p>

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
    font-family: 'Inter',sans-serif;
    background:#f8fafc;
    margin:0;
    padding:40px;
    color:#334155;
}

/* PROFILE HEADER */

.profile-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:#ffffff;
    padding:25px 30px;
    border-radius:16px;
    box-shadow:0 10px 40px rgba(0,0,0,0.05);
    margin-bottom:35px;
}



.profile-details{
    flex:1;
    margin-left:20px;
}

.profile-details h2{
    margin:0;
    font-size:22px;
    color:#0f172a;
}

.profile-details p{
    margin:4px 0;
    color:#64748b;
}

.wallet-box{
    text-align:right;
}

.wallet-box span{
    font-size:13px;
    color:#64748b;
}

.wallet-box h3{
    margin:0;
    font-size:22px;
    color:#2563eb;
}

/* STATS */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-bottom:40px;
}

.stat-card{
    background:#ffffff;
    padding:20px;
    border-radius:14px;
    box-shadow:0 8px 25px rgba(0,0,0,0.05);
}

.stat-card span{
    font-size:13px;
    color:#64748b;
}

.stat-card h3{
    margin:8px 0 0 0;
    font-size:22px;
    color:#0f172a;
}

/* SECTION TITLE */

h3{
    margin-top:40px;
    margin-bottom:20px;
    font-size:20px;
    color:#0f172a;
}

/* GRID */

.ticket-grid,
.commission-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(260px,1fr));
    gap:22px;
}

/* CARD */

.ticket-card,
.commission-card{
    background:#ffffff;
    border-radius:16px;
    overflow:hidden;
    border:1px solid #e2e8f0;
    transition:all .25s ease;
}

.ticket-card:hover,
.commission-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}

/* IMAGE */

.ticket-image img,
.commission-image img{
    width:100%;
    height:170px;
    object-fit:cover;
}

/* CONTENT */

.ticket-info,
.commission-info{
    padding:18px;
}

.ticket-info h4,
.commission-info h4{
    margin:0 0 8px 0;
    font-size:16px;
    color:#0f172a;
}

.ticket-info p,
.commission-info p{
    font-size:14px;
    margin:4px 0;
    color:#475569;
}

/* COMMISSION */

.amount{
    color:#16a34a;
    font-weight:600;
}

/* EMPTY */

.no-data{
    padding:25px;
    text-align:center;
    background:#fff;
    border-radius:10px;
    border:1px dashed #cbd5e1;
}
</style>