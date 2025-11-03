<?php include 'header.php'; if(!isAdmin()){ echo "<p>Admins only.</p>"; include 'footer.php'; exit; } ?>
<h2>Admin Dashboard</h2>
<div class="grid">
  <div class="card">
    <h3>Users</h3>
    <table class="table">
      <tr><th>ID</th><th>Name</th><th>Email</th></tr>
      <?php
      $r = $mysqli->query("SELECT id,name,email FROM users ORDER BY id DESC");
      while($u=$r->fetch_assoc()){
        echo "<tr><td>{$u['id']}</td><td>".htmlspecialchars($u['name'])."</td><td>".htmlspecialchars($u['email'])."</td></tr>";
      }
      ?>
    </table>
  </div>
  <div class="card">
    <h3>Recipes</h3>
    <table class="table">
      <tr><th>ID</th><th>Title</th><th>Author</th><th>Category</th><th>Action</th></tr>
      <?php
      $r = $mysqli->query("SELECT r.id,r.title,r.category,u.name FROM recipes r LEFT JOIN users u ON u.id=r.user_id ORDER BY r.id DESC");
      while($x=$r->fetch_assoc()){
        $id=$x['id']; $t=htmlspecialchars($x['title']); $a=htmlspecialchars($x['name']); $c=htmlspecialchars($x['category']);
        echo "<tr><td>$id</td><td>$t</td><td>$a</td><td>$c</td><td><a class='button danger' href='delete_recipe.php?id=$id' onclick='return confirm(\"Delete recipe #$id?\")'>Delete</a></td></tr>";
      }
      ?>
    </table>
  </div>
</div>
<?php include 'footer.php'; ?>
