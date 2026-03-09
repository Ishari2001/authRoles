<h2>My Profile</h2>

<div class="card">
    <p><b>Name:</b> <?= esc($user['name']) ?></p>
    <p><b>Email:</b> <?= esc($user['email']) ?></p>
    <p><b>Wallet:</b> Rs <?= number_format($user['wallet'],2) ?></p>
</div>

<div class="card">
<div class="card">
<h3>My Purchased Tickets</h3>

<?php if($purchases): ?>

<?php
// Aggregate purchases by ticket_id
$ticketCounts = [];
foreach($purchases as $p) {
    $id = $p['ticket_id'];
    if (!isset($ticketCounts[$id])) {
        $ticketCounts[$id] = [
            'title' => $p['title'],
            'price' => $p['price'],
            'count' => 1,
            'last_purchase' => $p['created_at']
        ];
    } else {
        $ticketCounts[$id]['count']++;
        $ticketCounts[$id]['last_purchase'] = $p['created_at']; // optional: last purchase date
    }
}
?>

<table border="1" cellpadding="10">
<tr>
    <th>Ticket</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Last Purchase Date</th>
</tr>

<?php foreach($ticketCounts as $t): ?>
<tr>
    <td><?= esc($t['title']) ?></td>
    <td>Rs <?= number_format($t['price'],2) ?></td>
    <td><?= $t['count'] ?></td>
    <td><?= $t['last_purchase'] ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php else: ?>
<p class="no-data">No purchases yet</p>
<?php endif; ?>
</div>


<h3>My Commission Earnings</h3>

<?php if($commissions): ?>

<table border="1" cellpadding="10">
    <tr>
        <th>From User</th>
        <th>Ticket</th>
        
        <th>Amount</th>
        <th>Date</th>
    </tr>

    <?php foreach($commissions as $c): ?>
    <tr>
        <td><?= esc($c['from_user']) ?></td>
        <td>
            <?php 
                // Try to get ticket title from purchase if available
                if(!empty($c['ticket_title'])) {
                    echo esc($c['ticket_title']);
                } else {
                    echo '-';
                }
            ?>
        </td>
        
        <td>Rs <?= number_format($c['amount'],2) ?></td>
        <td><?= $c['created_at'] ?></td>
    </tr>
    <?php endforeach; ?>

</table>

<?php else: ?>
<p>No commissions yet.</p>
<?php endif; ?>

</div>


<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f6fa;
    color: #333;
    margin: 0;
    padding: 20px;
}

h2, h3 {
    color: #1e3c72;
    margin-bottom: 15px;
}

.card {
    background: #fff;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.card p {
    font-size: 16px;
    line-height: 1.6;
    margin: 8px 0;
}

.card table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
    font-size: 14px;
}

.card table th, 
.card table td {
    padding: 12px 15px;
    text-align: left;
}

.card table th {
    background-color: #1e3c72;
    color: #fff;
    font-weight: 600;
}

.card table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.card table tr:hover {
    background-color: #e6f0ff;
}

.card table td {
    border-bottom: 1px solid #ddd;
}

p {
    margin: 0;
}

.no-data {
    color: #888;
    font-style: italic;
    padding: 10px 0;
}
</style>