<!-- <h2>Tickets</h2>

<a href="<?= base_url('/admin/tickets/create') ?>">Add Ticket</a>

<table border="1" cellpadding="10">
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Event Date</th>
    <th>Image</th>
    <th>Action</th>
</tr>

<?php foreach($tickets as $t): ?>
<tr>
    <td><?= $t['id'] ?></td>
    <td><?= esc($t['title']) ?></td>
    <td><?= $t['price'] ?></td>
    <td><?= $t['qty'] ?></td>
    <td><?= $t['event_date'] ?></td>

    <td>
        <?php if($t['image']): ?>
            <img src="<?= base_url('uploads/tickets/'.$t['image']) ?>" width="60">
        <?php endif; ?>
    </td>

    <td>
        <a href="<?= base_url('/admin/tickets/delete/'.$t['id']) ?>">Delete</a>
    </td>
</tr>
<?php endforeach; ?>

</table> -->