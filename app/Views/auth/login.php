<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>System Login</title>

<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:"Segoe UI",sans-serif;
}

body{
  height:100vh;
  background:linear-gradient(135deg,#1e3c72,#2a5298);
  display:flex;
  justify-content:center;
  align-items:center;
}

.login-container{
  width:380px;
  background:#fff;
  padding:35px;
  border-radius:12px;
  box-shadow:0 20px 45px rgba(0,0,0,.25);
  animation:fadeIn .6s ease-in-out;
}

@keyframes fadeIn{
  from{opacity:0;transform:translateY(20px);}
  to{opacity:1;transform:translateY(0);}
}

h2{
  text-align:center;
  margin-bottom:25px;
  color:#1e3c72;
}

.input-group{
  margin-bottom:18px;
}

.input-group label{
  font-size:14px;
  color:#555;
  display:block;
  margin-bottom:6px;
}

.input-group input{
  width:100%;
  padding:11px;
  border:1px solid #ddd;
  border-radius:6px;
  transition:.3s;
}

.input-group input:focus{
  border-color:#2a5298;
  outline:none;
  box-shadow:0 0 6px rgba(42,82,152,.3);
}

button{
  width:100%;
  padding:12px;
  background:#1e3c72;
  color:#fff;
  border:none;
  border-radius:6px;
  font-size:15px;
  cursor:pointer;
  transition:.3s;
}

button:hover{
  background:#16325c;
}


.error{
  background:#ffdddd;
  color:#b30000;
  padding:10px;
  margin-bottom:15px;
  border-radius:6px;
  font-size:14px;
}
.register-link{
  text-align:center;
  margin-top:18px;
  font-size:14px;
  color:#666;
}

.register-link a{
  color:#2a5298;
  text-decoration:none;
  font-weight:600;
  transition:.3s;
}

.register-link a:hover{
  color:#1e3c72;
  text-decoration:underline;
}

</style>
</head>
<body>

<div class="login-container">
  <h2>Login to System</h2>

  <!-- Error Message -->
  <?php if(session()->getFlashdata('error')): ?>
    <div class="error">
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>

  <form method="post" action="<?= base_url('/doLogin') ?>">
    
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="email" required>
    </div>

    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password" required>
    </div>

    <button type="submit">Login</button>
    <div class="register-link">
      Don't have an acoount ?
      <a href="<?=base_url ('/register')?>">Register</a>
    </div>
  </form>

 
</div>

</body>
</html>
