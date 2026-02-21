<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Inter',sans-serif;}
body{background:#020617;color:#fff;display:flex;}

/* SIDEBAR */
.sidebar{
    width:220px;
    height:100vh;
    background:#1e293b;
    padding:20px;
    position:fixed;
}
.sidebar h2{
    color:#38bdf8;
    text-align:center;
    margin-bottom:30px;
}
.sidebar a{
    display:block;
    padding:12px 15px;
    color:#cbd5e1;
    text-decoration:none;
    border-radius:6px;
    margin-bottom:8px;
    transition:.2s;
}
.sidebar a:hover{
    background:#0f172a;
    color:#fff;
}

/* MAIN CONTENT */
.main{
    margin-left:240px;
    padding:30px 40px;
    width:100%;
}

/* HEADER CARDS */
.card-area{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:25px;
    margin-bottom:30px;
}
.card{
    background:#1e293b;
    padding:20px;
    border-radius:12px;
    text-align:center;
}
.card h3{font-size:1.8em;color:#38bdf8;}

/* TABLES */
.section{
    margin-bottom:50px;
}
table{
    width:100%;
    border-collapse:collapse;
    background:#0f172a;
    margin-top:15px;
}
th,td{
    padding:12px;
    border-bottom:1px solid #1e293b;
    text-align:left;
}
th{background:#1e293b;color:#38bdf8;}
tr:hover{background:#111827;}
img{border-radius:6px;width:80px;}

/* BUTTONS */
.btn{
    padding:6px 12px;
    border:none;
    border-radius:6px;
    font-weight:600;
    text-decoration:none;
    cursor:pointer;
    margin-right:5px;
}
.btn-primary{background:#6366f1;color:#fff;}
.btn-primary:hover{background:#4f46e5;}
.btn-edit{background:#f59e0b;color:#fff;}
.btn-edit:hover{background:#d97706;}
.btn-danger{background:#ef4444;color:#fff;}
.btn-danger:hover{background:#dc2626;}
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>E-Ticket Admin</h2>
    <a href="<?= base_url('/admin/dashboard?view=summary') ?>">Dashboard</a>
<a href="<?= base_url('/admin/dashboard?view=users') ?>">Users</a>
<a href="<?= base_url('/admin/dashboard?view=commissions') ?>">Commissions</a>
<a href="<?= base_url('/admin/dashboard?view=tickets') ?>">Tickets</a>
</div>

<!-- MAIN CONTENT -->
<div class="main">

    <!-- SUMMARY CARDS -->
<?php if($view == 'summary'): ?>
<div class="card-area">
    <div class="card">
        <h3><?= $totalUsers ?></h3>
        <p>Total Users</p>
    </div>
    <div class="card">
        <h3>Rs. <?= number_format($totalWallet,2) ?></h3>
        <p>Total Wallet Balance</p>
    </div>
    <div class="card">
        <h3>Rs. <?= number_format($totalCommission,2) ?></h3>
        <p>Total Commission Paid</p>
    </div>
</div>
<?php endif; ?>

<!-- USERS TABLE -->
<?php if($view == 'users'): ?>
<div class="section">
    <h3>All Users & Wallet Balances</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Wallet Balance</th>
        </tr>
        <?php foreach($users as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= esc($u['name']) ?></td>
            <td><?= esc($u['email']) ?></td>
            <td>Rs. <?= number_format($u['wallet'],2) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>

<!-- COMMISSION TABLE -->
<?php if($view == 'commissions'): ?>
<div class="section">
    <h3>Commission Transactions</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Buyer</th>
            <th>Sponsor Earned</th>
            <th>Commission Amount</th>
            <th>Date</th>
        </tr>
        <?php foreach($commissions as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= esc($c['buyer_name']) ?></td>
            <td><?= esc($c['sponsor_name']) ?></td>
            <td>Rs. <?= number_format($c['amount'],2) ?></td>
            <td><?= $c['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
<?php endif; ?>

<!-- TICKETS TABLE + ADD FORM -->
<?php if($view == 'tickets'): ?>
<div class="section">
    <h3>Tickets Management</h3>
   

    <table>
    <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Event Date</th>
        <th>Sales Start</th>
        <th>Sales End</th>
        <th>Actions</th>
    </tr>

    <?php if(!empty($tickets)): ?>
        <?php foreach($tickets as $t): ?>
        <tr>
            <td><?= $t['id'] ?></td>

            <td>
                <?php if(!empty($t['image'])): ?>
                    <img src="<?= base_url('uploads/tickets/'.$t['image']) ?>" width="60">
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

            <!-- ✅ ACTION BUTTONS -->
            <td>
                <button class="btn btn-sm btn-primary"
                        onclick="editTicket(<?= $t['id'] ?>)">
                    Edit
                </button>

                <button class="btn btn-sm btn-danger"
                        onclick="deleteTicket(<?= $t['id'] ?>)">
                    Delete
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9" style="text-align:center;">No Tickets Found</td>
        </tr>
    <?php endif; ?>
</table>

    <!-- ADD NEW TICKET FORM -->
    <div style="margin-top:40px; padding:20px; background:#1e293b; border-radius:12px;">
        <h2>➕ Add New Ticket</h2>
        <form method="post" action="<?= base_url('/admin/tickets/save') ?>" enctype="multipart/form-data">
            <label>Title</label><br>
            <input type="text" name="title" required><br><br>

            <label>Description</label><br>
            <textarea name="description"></textarea><br><br>

            <label>Price</label><br>
            <input type="number" name="price" step="0.01" required><br><br>

            <label>Quantity Available</label><br>
            <input type="number" name="qty" required><br><br>

            <label>Event Date</label><br>
            <input type="date" name="event_date"><br><br>

            <label>Ticket Sale Start</label><br>
            <input type="datetime-local" name="purchase_start" required><br><br>

            <label>Ticket Sale End</label><br>
            <input type="datetime-local" name="purchase_end" required><br><br>

            <label>Ticket Image</label><br>
            <input type="file" name="image"><br><br>

            <button type="submit" class="btn btn-primary">Create Ticket</button>
        </form>
    </div>

</div>
<?php endif; ?>
        </table>
    </div>

</div>

<div id="ticketModal" style="display:none; position:fixed; inset:0; background:#00000090;">
  <div style="background:#1e293b; width:500px; margin:80px auto; padding:25px; border-radius:10px;">
    <h3>Edit Ticket</h3>

    <form id="editForm">
        <input type="hidden" name="id" id="ticket_id">

        <label>Title</label>
        <input type="text" name="title" id="title"><br><br>

        <label>Description</label>
        <textarea name="description" id="description"></textarea><br><br>

        <label>Price</label>
        <input type="number" name="price" id="price"><br><br>

        <label>Qty</label>
        <input type="number" name="qty" id="qty"><br><br>

        <label>Event Date</label>
        <input type="date" name="event_date" id="event_date"><br><br>

        <label>Sales Start</label>
        <input type="datetime-local" name="purchase_start" id="purchase_start"><br><br>

        <label>Sales End</label>
        <input type="datetime-local" name="purchase_end" id="purchase_end"><br><br>

        <label>Change Image</label>
        <input type="file" name="image"><br><br>

        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" onclick="closeModal()">Cancel</button>
    </form>
  </div>
</div>
<script>
function editTicket(id){
    fetch("<?= base_url('/admin/ticket/get') ?>",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:"id="+id
    })
    .then(res=>res.json())
    .then(data=>{
        document.getElementById('ticket_id').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('description').value = data.description;
        document.getElementById('price').value = data.price;
        document.getElementById('qty').value = data.qty;
        document.getElementById('event_date').value = data.event_date;
        document.getElementById('purchase_start').value = data.purchase_start.replace(' ','T');
        document.getElementById('purchase_end').value = data.purchase_end.replace(' ','T');

        document.getElementById('ticketModal').style.display='block';
    });
}

function closeModal(){
    document.getElementById('ticketModal').style.display='none';
}

document.getElementById('editForm').onsubmit = function(e){
    e.preventDefault();

    let formData = new FormData(this);

    fetch("<?= base_url('/admin/ticket/update') ?>",{
        method:"POST",
        body:formData
    }).then(()=>{
        location.reload();
    });
}

function deleteTicket(id){
    if(!confirm("Delete Ticket?")) return;

    fetch("<?= base_url('/admin/ticket/delete') ?>",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:"id="+id
    }).then(()=>{
        location.reload();
    });
}
</script>
</body>
</html>