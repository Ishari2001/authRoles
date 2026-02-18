<!DOCTYPE html>
<html>
<head>
<title>Register</title>

<style>
body{
  background:#eef2f7;
  font-family:Segoe UI;
}

.box{
  width:420px;
  margin:60px auto;
  background:#fff;
  padding:30px;
  border-radius:10px;
  box-shadow:0 5px 25px rgba(0,0,0,.15);
}

input{
  width:100%;
  padding:10px;
  margin-bottom:15px;
  border:1px solid #ccc;
  border-radius:5px;
}

button{
  width:100%;
  padding:12px;
  background:#1e3c72;
  color:#fff;
  border:none;
  border-radius:5px;
}

.error{
  color:red;
  margin-bottom:10px;
}
.success{
  background:#e6ffed;
  border:1px solid #b7ebc6;
  color:#155724;
  padding:15px;
  margin-bottom:15px;
  border-radius:6px;
  font-size:14px;
}

#sponsor_name {
  font-weight: bold;
  color: #1e3c72;
  margin-top: -10px;
  margin-bottom: 15px;
  display: block;
}
.login-link{
  text-align:center;
  margin-top:18px;
  font-size:14px;
  color:#666;
}

.login-link a{
  color:#1e3c72;
  text-decoration:none;
  font-weight:600;
  transition:.3s;
}

.login-link a:hover{
  color:#16325c;
  text-decoration:underline;
}

</style>

<script>
function checkSponsor(id){
    if(id === '') {
        document.getElementById('sponsor_name').innerText = '';
        return;
    }

    fetch('<?= base_url("getSponsorName") ?>?id=' + id)
    .then(response => response.json())
    .then(data => {
        if(data.name){
            document.getElementById('sponsor_name').innerText = "Sponsor Name: " + data.name;
        } else {
            document.getElementById('sponsor_name').innerText = "Invalid Sponsor ID";
        }
    });
}
</script>

</head>
<body>

<div class="box">
<h2>User Registration</h2>

<?php if(session()->getFlashdata('error')): ?>
    <div class="error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php if(session()->getFlashdata('success')): ?>

    <div class="success">
        <p><?= session()->getFlashdata('success') ?></p>

        <hr>

        <p><strong>Your User ID:</strong>
            <?= session()->getFlashdata('new_user_id') ?>
        </p>

        <?php if(session()->getFlashdata('sponsor_id')): ?>
            <p><strong>Registered Under Sponsor ID:</strong>
                <?= session()->getFlashdata('sponsor_id') ?>
            </p>

            <p><strong>Sponsor Name:</strong>
                <?= session()->getFlashdata('sponsor_name') ?>
            </p>
        <?php else: ?>
            <p><strong>No Sponsor Used.</strong> You are an Independent User.</p>
        <?php endif; ?>

        <p style="margin-top:10px;color:#666;">
            ⚠️ Save your User ID. Others must use this ID to join under you.
        </p>
    </div>

<?php endif; ?>


<form method="post" action="<?= base_url('saveUser') ?>">

<input type="text" name="name" placeholder="Full Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<input type="number" name="sponsor_id" placeholder="Sponsor User ID (Optional)" oninput="checkSponsor(this.value)">
<small>Enter a registered user ID to assign as your sponsor</small>
<span id="sponsor_name"></span>

<button type="submit">Register</button>
<div class="login-link">
  Already have an account?
  <a href="<?= base_url('/login') ?>">Login Here</a>
</div>

</form>

</div>

</body>
</html>
