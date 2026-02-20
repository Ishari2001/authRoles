<!-- <h2>🎫 All Tickets</h2>
<a href="<?= base_url('/admin/tickets/add') ?>">+ Add Ticket</a>
<br><br>

<table border="1" cellpadding="10" width="100%">
<tr>
   
    <th>Image</th>
    <th>Title</th>
    <th>Price</th>
    <th>Qty Left</th>
    <th>Event Date</th>
    <th>Sales Start</th>
    <th>Sales End</th>
</tr>

<?php foreach($tickets as $t): ?>
<tr>
    
<td>
    <?php if(!empty($t['image'])): ?>
        <img src="<?= base_url('uploads/tickets/'.$t['image']) ?>" width="80" alt="Ticket Image">
    <?php else: ?>
        No Image
    <?php endif; ?>
</td>
    <td><?= esc($t['title']) ?></td>
    <td>Rs. <?= number_format($t['price'],2) ?></td>
    <td><?= $t['qty'] ?></td>
    <td><?= $t['event_date'] ?></td>
    <td><?= $t['purchase_start'] ?></td>
    <td><?= $t['purchase_end'] ?></td>
</tr>
<?php endforeach; ?>

</table> -->