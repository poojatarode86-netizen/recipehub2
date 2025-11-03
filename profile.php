<?php include 'header.php'; if(!isLoggedIn()){ header('Location: login.php'); exit; } ?>
<h2>My Recipes</h2>
<div class="grid">
<?php
$uid = currentUser()['id'];
$res = $mysqli->prepare("SELECT id,title,category,image FROM recipes WHERE user_id=? ORDER BY created_at DESC");
$res->bind_param("i",$uid);
$res->execute();
$rows = $res->get_result();
while($r = $rows->fetch_assoc()){
  $img = $r['image'] ? 'uploads/'.$r['image'] : 'https://picsum.photos/seed/rp'.$r['id'].'/600/400';
  echo '<div class="card recipe-card">';
  echo '<img class="recipe-img" src="'.htmlspecialchars($img).'" alt="">';
  echo '<h3>'.htmlspecialchars($r['title']).'</h3>';
  echo '<p class="meta"><span class="badge">'.htmlspecialchars($r['category']).'</span></p>';
  echo '<div class="actions"><a class="button secondary" href="edit_recipe.php?id='.$r['id'].'">Edit</a> ';
  echo '<a class="button danger" href="delete_recipe.php?id='.$r['id'].'" onclick="return confirm(\'Delete this recipe?\')">Delete</a></div>';
  echo '</div>';
}
if($rows->num_rows===0){ echo '<div class="card"><p class="kicker">No recipes yet. <a href="add_recipe.php">Add your first recipe</a>.</p></div>'; }
?>
</div>
<?php include 'footer.php'; ?>
