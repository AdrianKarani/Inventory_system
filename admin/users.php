<?php
  require_once '../core-system-files/init.php';

  if(!logged_in()){
    login_error_redirect();
  }

  if(!has_permission('admin')){
    permission_error_redirect('index.php');
  }

  include 'includes/head.php';
  include 'includes/navigation.php';

if(isset($_GET['delete'])){
  $delete_id = sanitize($_GET['delete']);
  $db->query("DELETE FROM users WHERE id = '$delete_id'");
  $_SESSION['SUCCESS'] = 'User has been deleted';
  header('Location: users.php');
}

$userquery = $db->query("SELECT * FROM users ORDER BY full_name");
?>

<h2 class="text-center">Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" id="add_prod">Add New User</a>
<table class="table table-bordered table-striped table-condensed">
  <thead>
    <th></th>
      <th>Name</th>
        <th>Email</th>
          <th>Join_Date</th>
            <th>Last_Seen</th>
              <th>Permissions</th>
  </thead>
  <tbody>
    <?php
    while($user = mysqli_fetch_assoc($userquery)):
    ?>
    <tr>
      <td>

        <?php if($user['id'] != $userdata['id']): ?>
        <a href="users.php?delete<?=$user['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
      <?php endif; ?>
      </td>
      <td><?=$user['full_name'];?></td>
      <td><?=$user['email'];?></td>
      <td><?=r_date($user['join_date']);?></td>
      <td><?=r_date($user['last_seen']);?></td>
      <td><?=$user['permissions'];?></td>
    </tr>
  <?php endwhile;?>
  </tbody>
</table>
<?php
  include 'includes/footer.php';
?>
