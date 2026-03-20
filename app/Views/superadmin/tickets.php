<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Tickets</title>

<!-- Font -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
/* =========================
   GLOBAL STYLE
========================= */
body {
    margin: 0;
    font-family: "Inter", sans-serif;
    background: linear-gradient(135deg, #0b1220, #111827);
    color: #e5e7eb;
}

/* CONTAINER */
.ticket-admin {
    max-width: 1200px;
    margin: auto;
    padding: 25px;
}

/* TITLE */
h2 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #fff;
}

/* CARD */
.card {
    background: rgba(17, 24, 39, 0.85);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    margin-bottom: 20px;
}

/* SUCCESS MESSAGE */
.success {
    background: rgba(34,197,94,0.1);
    border: 1px solid rgba(34,197,94,0.3);
    padding: 10px 12px;
    border-radius: 10px;
    color: #22c55e;
    margin-bottom: 15px;
}

/* FORM GRID */
form.add-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 12px;
}

/* INPUTS */
input, textarea {
    background: #0f172a;
    border: 1px solid #1f2937;
    color: #fff;
    padding: 10px;
    border-radius: 10px;
    font-size: 14px;
}

textarea {
    resize: vertical;
    min-height: 40px;
}

/* FOCUS */
input:focus, textarea:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
}

/* BUTTON */
button {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    padding: 10px 14px;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(59,130,246,0.4);
}

/* TABLE */
table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 12px;
    overflow: hidden;
}

/* HEADER */
thead {
    background: #1e293b;
}

/* TH TD */
th, td {
    padding: 14px;
    text-align: center;
    font-size: 14px;
}

/* ROW */
tr {
    border-bottom: 1px solid rgba(255,255,255,0.06);
}

tr:hover {
    background: rgba(59,130,246,0.08);
}

/* IMAGE */
img {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 10px;
}

/* INLINE UPDATE FORM */
td form {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

/* SMALL INPUT */
td input, td textarea {
    font-size: 12px;
    padding: 6px;
}

/* DELETE LINK */
a {
    color: #ef4444;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* EMPTY */
.empty {
    text-align: center;
    padding: 30px;
    color: #94a3b8;
}
</style>

</head>

<body>

<div class="ticket-admin">

    <h2>🎟 Manage Tickets</h2>

    <!-- SUCCESS -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- ADD FORM -->
    <div class="card">
        <form method="post" action="<?= base_url('superadmin/tickets/save') ?>" enctype="multipart/form-data" class="add-form">

            <input type="text" name="title" placeholder="Title" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="number" name="price" placeholder="Price" step="0.01" required>
            <input type="number" name="qty" placeholder="Quantity" required>
            <input type="date" name="event_date">
            <input type="datetime-local" name="purchase_start">
            <input type="datetime-local" name="purchase_end">
            <input type="file" name="image">

            <button type="submit">➕ Add Ticket</button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="card">

        <table>

            <thead>
                <tr>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Event Date</th>
                    <th>Purchase Window</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php if(!empty($tickets)): ?>
                <?php foreach($tickets as $t): ?>
                <tr>

                    <td>
                        <?php if($t['image']): ?>
                            <img src="<?= base_url('uploads/tickets/'.$t['image']) ?>">
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

                        <!-- UPDATE -->
                        <form method="post" action="<?= base_url('superadmin/tickets/update') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $t['id'] ?>">
                            <input type="text" name="title" value="<?= esc($t['title']) ?>">
                            <textarea name="description"><?= esc($t['description']) ?></textarea>
                            <input type="number" name="price" value="<?= $t['price'] ?>">
                            <input type="number" name="qty" value="<?= $t['qty'] ?>">
                            <input type="date" name="event_date" value="<?= $t['event_date'] ?>">
                            <input type="datetime-local" name="purchase_start" value="<?= $t['purchase_start'] ?>">
                            <input type="datetime-local" name="purchase_end" value="<?= $t['purchase_end'] ?>">
                            <input type="file" name="image">

                            <button type="submit">Update</button>
                        </form>

                        <!-- DELETE -->
                        <a href="<?= base_url('superadmin/tickets/delete/'.$t['id']) ?>"
                           onclick="return confirm('Delete this ticket?')">
                           Delete
                        </a>

                    </td>

                </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="8" class="empty">No tickets found</td>
                </tr>
            <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>