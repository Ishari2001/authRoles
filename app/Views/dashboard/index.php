<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<style>
body{
  margin:0;
  font-family:Segoe UI;
  background:#f4f6fa;
}

.header{
  background:#1e3c72;
  color:#fff;
  padding:15px 25px;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

.container{
  padding:30px;
}

.card{
  background:#fff;
  padding:20px;
  margin-bottom:20px;
  border-radius:8px;
  box-shadow:0 3px 12px rgba(0,0,0,.1);
}

.logout{
  color:#fff;
  text-decoration:none;
  background:#e74c3c;
  padding:8px 14px;
  border-radius:5px;
}
</style>

</head>
<body>

<div class="header">
  <h3>Welcome <?= esc($name) ?></h3>
  <a href="auth/logout" class="logout">Logout</a>
</div>

<div class="container">

  
  <div class="card">
    <h3>Dashboard Home</h3>
    <p>This section is visible to all roles.</p>
  </div>

  
  <?php if($role == 1): ?>
  <div class="card">
    <h3>Admin Panel</h3>
    <p>Manage Users</p>
    <p>System Settings</p>
    <p>View Reports</p>
  </div>
  <?php endif; ?>


  <?php if($role == 2 || $role == 1): ?>
  <div class="card">
    <h3>Author Tools</h3>
    <p>Create Article</p>
    <p>Edit Your Posts</p>
  </div>
  <?php endif; ?>

  
  <?php if($role == 3 || $role == 1): ?>
  <div class="card">
    <h3>Reader Access</h3>
    <p>View Articles Only</p>
  </div>
  <?php endif; ?>

  
  <?php if($role == 4 || $role == 1): ?>
<div class="card">
    <h3>Purchase E-Ticket</h3>
    

    <?php if(session()->getFlashdata('success')): ?>
        <p class="success"><?= session()->getFlashdata('success') ?></p>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <p class="error"><?= session()->getFlashdata('error') ?></p>
    <?php endif; ?>

    <?php if(!empty($tickets)): ?>
        <?php foreach($tickets as $t): ?>
            <div style="border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:6px;">
                <?php if($t['image']): ?>
                    <img src="<?= base_url('uploads/tickets/'.$t['image']) ?>" alt="<?= esc($t['title']) ?>" style="width:100px; float:left; margin-right:10px;">
                <?php endif; ?>
                <strong><?= esc($t['title']) ?></strong><br>
                Price: Rs. <?= number_format($t['price'],2) ?><br>
                Available: <?= $t['qty'] ?><br>
                Event: <?= $t['event_date'] ?><br>
                <form method="post" action="<?= base_url('dashboard/purchaseTicket') ?>" style="margin-top:5px;">
                    <input type="hidden" name="ticket_id" value="<?= $t['id'] ?>">
                    <button type="submit" style="padding:6px 12px; background:#1e3c72; color:#fff; border:none; border-radius:4px; cursor:pointer;">
                        Purchase Ticket
                    </button>
                </form>
                <div style="clear:both;"></div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No tickets available for purchase.</p>
    <?php endif; ?>
</div>
<?php endif; ?>
</div>

</body>
</html>
