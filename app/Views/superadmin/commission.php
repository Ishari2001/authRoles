<div class="card">
<h3>Commission Logs</h3>

<table width="100%" cellpadding="10" style="border-collapse:collapse;">

<tr style="background:#334155;color:#fff;">
<th>Receiver</th>
<th>From User</th>
<th>Amount</th>
<th>Date</th>
</tr>

<?php foreach($commissions as $c): ?>
<tr style="border-bottom:1px solid #444;">

<td><?= esc($c['sponsor_name'] ?? 'N/A') ?></td>
<td><?= esc($c['from_name'] ?? 'N/A') ?></td>
<td>Rs <?= number_format($c['amount'],2) ?></td>
<td><?= date('Y-m-d', strtotime($c['created_at'])) ?></td>

</tr>
<?php endforeach; ?>

</table>

</div>