<?php require_once 'db.php';
if(!isLoggedIn()){ header('Location: login.php'); exit; }
$id = isset($_GET['id'])?intval($_GET['id']):0;
$rec = $mysqli->query("SELECT * FROM recipes WHERE id=$id")->fetch_assoc();
if($rec && (isAdmin() || currentUser()['id']==$rec['user_id'])){
  if($rec['image'] && file_exists(__DIR__ . '/uploads/' . $rec['image'])){ @unlink(__DIR__ . '/uploads/' . $rec['image']); }
  $mysqli->query("DELETE FROM recipes WHERE id=$id");

  // Auto-backup after delete
  exportRecipes();

  $_SESSION['flash'] = "Recipe deleted.";
}
header('Location: index.php'); exit; ?>
