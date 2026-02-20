<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

<style>
body{
    margin:0;
    font-family:'Inter',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a);
    height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}

.login-box{
    width:360px;
    padding:40px;
    background:#0f172a;
    border-radius:16px;
    box-shadow:0 20px 60px rgba(0,0,0,.5);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#38bdf8;
}

input{
    width:100%;
    padding:14px;
    margin-bottom:15px;
    border:none;
    border-radius:8px;
    background:#1e293b;
    color:#fff;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:8px;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:#fff;
    font-weight:600;
    cursor:pointer;
}

button:hover{
    opacity:.9;
}

.error{
    color:#f87171;
    margin-bottom:15px;
    text-align:center;
}
</style>
</head>

<body>

<div class="login-box">
    <h2>Admin Panel</h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('/admin/login') ?>">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>