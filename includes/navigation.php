<?php
  $sql = "SELECT * FROM supplier WHERE parent = 0";
  $parent_query = $db->query($sql);
?>

<!--top navigation bar  -->
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">Gitari H.</a>
      <ul class="nav navbar-nav">
        <!-- t starts looping from here, any value with parent=0 is on the navigation bar -->
        <?php while($parent = mysqli_fetch_assoc($parent_query)) : ?>
          <?php
            $parent_id = $parent['id'];
            $sql_2 = "SELECT * FROM suppliers WHERE parent = '$parent_id'";
            $child_query = $db->query($sql_2);
           ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle=dropdown> <?php echo $parent['supplier_name'] ?> <span class="caret"></span> </a>
          <!-- data-toggle - this runs a javascript function without us having us to call on the js code  -->
          <ul class="dropdown-menu" role="menu">
            <!-- loops through list comparing the parent to the id supplier   -->
          <?php while($child = mysqli_fetch_assoc($child_query)) : ?>
            <li><a href="suppliers.php?cat=<?=$child['id'];?>"> <?php echo $child['supplier_name'] ?> </a></li>
          <?php endwhile; ?>
          </ul>
        </li>
        <!-- the loop will end here -->
      <?php endwhile; ?>
      </ul>
  </div>
</nav>
