<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="/Inventory_system/admin/index.php" class="navbar-brand">Gitari H. admin</a>
      <ul class="nav navbar-nav">
        <li><a href="users.php">Users</a></li>
        <li><a href="orders.php">Orders</a></li>
        <li><a href="suppliers.php">Suppliers</a></li>

        <?php if(has_permission('admin')): ?>
        <li><a href="users.php">Users</a></li>
        <?php endif; ?>
        <li>
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hello, <?=$userdata['first'];?> <span class="caret"></span>
          </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="change_password.php">Change password</a></li>
            <li><a href="logout.php">Log out</a></li>
          </ul>
        </li>
        <!-- <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle=dropdown> <?php echo $parent['supplier name'] ?> <span class="caret"></span> </a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#"> <?php echo $child['supplier name'] ?> </a></li>
          </ul>
        </li> -->
      </ul>
  </div>
</nav>
