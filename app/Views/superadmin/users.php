<div class="card">
<h3>System Overview</h3>

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-top:20px;">

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


<!-- USERS TABLE -->
<div class="card">
<h3>All Users</h3>

<?php if(session()->getFlashdata('success')): ?>
<div style="color:green;margin-bottom:10px;">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<table width="100%" cellpadding="10" style="margin-top:15px;border-collapse:collapse;">
<tr style="background:#334155;color:#fff;">
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Wallet</th>
    <th>Role</th>
    <th>Action</th>
</tr>

<?php foreach($users as $u): ?>
<tr style="border-bottom:1px solid #444;">

<td><?= $u['id'] ?></td>
<td><?= esc($u['name']) ?></td>
<td><?= esc($u['email']) ?></td>
<td>Rs <?= number_format($u['wallet'],2) ?></td>

<td>
<?php
    if($u['role'] == 1) echo '👑 Super Admin';
    elseif($u['role'] == 2) echo '🧑 Admin';
    else echo '👤 User';
?>
</td>

<td>
<a href="<?= base_url('superadmin/users/delete/'.$u['id']) ?>" 
   onclick="return confirm('Delete this user?')" 
   style="color:red;">
   Delete
</a>
</td>

</tr>
<?php endforeach; ?>

</table>

</div>