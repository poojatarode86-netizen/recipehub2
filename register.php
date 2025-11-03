<?php include 'header.php'; ?>
<h2>Create Account</h2>
<div class="form card">
<form method="post" autocomplete="off">
  <label>Name</label>
  <input type="text" name="name" required>
  <label>Email</label>
  <input type="email" name="email" required>
  <label>Password</label>
  <input type="password" name="password" required minlength="6">
  <input type="hidden" name="csrf" value="<?php echo csrf_token(); ?>">
  <button type="submit" name="register">Register</button>
</form>
</div>
<?php
if($_SERVER['REQUEST_METHOD']==='POST' && csrf_check()===null && isset($_POST['register'])){
  $name = trim($_POST['name']); $email = clean($_POST['email']); $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $exists = $mysqli->prepare("SELECT id FROM users WHERE email=?"); $exists->bind_param("s",$email); $exists->execute(); $exists->store_result();
  if($exists->num_rows>0){ $_SESSION['flash']="Email already registered."; }
  else{ $stmt = $mysqli->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)"); $stmt->bind_param("sss",$name,$email,$pass); $stmt->execute();
    $_SESSION['flash']="Registration successful. Please login."; header('Location: login.php'); exit; }
}
include 'footer.php'; ?>
