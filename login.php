<?php include 'header.php'; ?>
<h2>Login</h2>
<div class="form card">
<form method="post" autocomplete="off">
  <label>Email</label>
  <input type="email" name="email" required>
  <label>Password</label>
  <input type="password" name="password" required>
  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
  <button type="submit" name="login">Login</button>
</form>
</div>
<?php
if($_SERVER['REQUEST_METHOD']==='POST' && csrf_check()===null && isset($_POST['login'])){
  $email = clean($_POST['email']);
  $stmt = $mysqli->prepare("SELECT id,name,email,password FROM users WHERE email=? LIMIT 1");
  $stmt->bind_param("s",$email); $stmt->execute(); $res = $stmt->get_result();
  if($u = $res->fetch_assoc()){
    if(password_verify($_POST['password'], $u['password'])){
      $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email']];
      $_SESSION['flash'] = "Welcome back, ".$u['name']."!"; header('Location: index.php'); exit;
    }
  }
  $_SESSION['flash'] = "Invalid email or password.";
}
include 'footer.php'; ?>
