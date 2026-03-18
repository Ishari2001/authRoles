<div class="card" style="padding:20px; background:#f4f4f4; border-radius:10px;">

<h2>Manage Tickets</h2>

<?php if(session()->getFlashdata('success')): ?>
<div style="color:green; margin-bottom:15px;">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<!-- ✅ ADD NEW TICKET FORM -->
<form method="post" action="<?= base_url('superadmin/tickets/save') ?>" enctype="multipart/form-data" style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:20px;">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="description" placeholder="Description"></textarea>
    <input type="number" name="price" placeholder="Price" required step="0.01">
    <input type="number" name="qty" placeholder="Quantity" required>
    <input type="date" name="event_date" placeholder="Event Date">
    <input type="datetime-local" name="purchase_start" placeholder="Purchase Start">
    <input type="datetime-local" name="purchase_end" placeholder="Purchase End">
    <input type="file" name="image">
    <button type="submit">Add Ticket</button>
</form>

<!-- ✅ TICKETS TABLE -->
<table width="100%" cellpadding="10" style="border-collapse:collapse; background:#fff; border-radius:5px; overflow:hidden;">
<tr style="background:#334155; color:#fff;">
    <th>Image</th>
    <th>Title</th>
    <th>Description</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Event Date</th>
    <th>Purchase Window</th>
    <th>Actions</th>
</tr>

<?php if(!empty($tickets)): ?>
    <?php foreach($tickets as $t): ?>
    <tr style="border-bottom:1px solid #ccc; text-align:center;">
        <td>
            <?php if($t['image']): ?>
                <img src="<?= base_url('uploads/tickets/'.$t['image']) ?>" width="60">
            <?php else: ?>
                N/A
            <?php endif; ?>
        </td>
        <td><?= esc($t['title']) ?></td>
        <td><?= esc($t['description']) ?></td>
        <td>Rs <?= number_format($t['price'],2) ?></td>
        <td><?= $t['qty'] ?></td>
        <td><?= $t['event_date'] ?></td>
        <td><?= $t['purchase_start'] ?> - <?= $t['purchase_end'] ?></td>
        <td>
            <!-- ✅ FULL INLINE UPDATE FORM -->
            <form method="post" action="<?= base_url('superadmin/tickets/update') ?>" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:5px; margin-bottom:5px;">
                <input type="hidden" name="id" value="<?= $t['id'] ?>">
                <input type="text" name="title" value="<?= esc($t['title']) ?>" required>
                <textarea name="description"><?= esc($t['description']) ?></textarea>
                <input type="number" name="price" value="<?= $t['price'] ?>" required step="0.01">
                <input type="number" name="qty" value="<?= $t['qty'] ?>" required>
                <input type="date" name="event_date" value="<?= $t['event_date'] ?>">
                <input type="datetime-local" name="purchase_start" value="<?= $t['purchase_start'] ?>">
                <input type="datetime-local" name="purchase_end" value="<?= $t['purchase_end'] ?>">
                <input type="file" name="image">
                <button type="submit">Update</button>
            </form>

            <a href="<?= base_url('superadmin/tickets/delete/'.$t['id']) ?>" 
               onclick="return confirm('Delete this ticket?')" 
               style="color:red;">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="8" style="text-align:center;">No tickets found</td>
    </tr>
<?php endif; ?>

</table>
</div>