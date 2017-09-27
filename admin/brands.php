<?php
  require_once '../core-system-files/init.php';
  if(!logged_in()){
    login_error_redirect();
  }

  include 'includes/head.php';
  include 'includes/navigation.php';

  // get brands from database
  $sql = "SELECT * FROM brand ORDER BY brand";
  $results = $db->query($sql);

  $errors = array();
// edit brand
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);

  $sql2 = "SELECT * FROM brand WHERE id = '$edit_id'";
  $edit_results = $db->query($sql2);
  $edit_brand = mysqli_fetch_assoc($edit_results);
}

// delete brand
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_id = sanitize($delete_id);

  $sql = "DELETE FROM brand WHERE id = '$delete_id'";
  $db->query($sql);
  header('Location: brands.php');
}

  // if add form is submitted, whatever is below this will be done
  if (isset($_POST['add'])){
    $brand = sanitize($_POST['brand']);
    //sanitize function makes sure people can't put in data that doesnt
    // check if brand is blank
    if($_POST['brand'] == ''){
      $errors[] .= 'You must enter a brand!';
    }

    // check if brand exists in database
    $sql = "SELECT * FROM brand WHERE brand = '$brand' ";
    if (isset($_GET['edit'])) {
      $sql = "SELECT * FROM brand WHERE brand = '$brand' AND id !='$edit_id'";
    }
    $result = $db->query($sql);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
      $errors[] .= $brand.' already exists in the database, please choose another brand name';
    }

    // display errors
    if (!empty($errors)) {
      echo display_errors($errors);
    }else{
      // add brand to database
      $sql = "INSERT INTO brand (brand) VALUES ('$brand')";
      if (isset($_GET['edit'])){
        $sql = "UPDATE brand SET brand = '$brand' AND id = '$edit_id'";
      }
      $db->query($sql);
      header('Location: brands.php');
    }
  }
?>
<h2 class="text-center">Brands</h2> <hr>
<!--Brand form  -->
<div class="text-center">
  <div class="">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <div class="form-group">
        <?php
          $brand_value = '';
          if (isset($_GET['edit'])) {
            $brand_value = $edit_brand['brand'];
          }else{
            if (isset($_POST['brand'])) {
              $brand_value = sanitize($_POST['brand']);
            }
          }
        ?>
        <label for="brand"><?=((isset($_GET['edit']))?'Edit':'Add a');?> Brand</label>
        <input type="text" name="brand"  id="brand" class="form-control" value="<?=$brand_value?>" placeholder="Brand name">
        <?php if (isset($_GET['edit'])) : ?>
          <a href="brands.php" class="btn btn-default">Cancel</a>
        <?php endif; ?>
        <input type="submit" name="add" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Brand" class="btn  btn-success">
      </div>
    </form>
  </div> <hr>

</div>
  <table class="table table-bordered table-striped table-auto table-condensed" style="width:auto; margin: 0 auto;">
    <thead>
      <th></th><th>Brands</th><th></th>
    </thead>
    <tbody>
      <?php while($brand = mysqli_fetch_assoc($results)): ?>
      <tr>
        <td><a href="brands.php?edit=<?=$brand['id']?>" class="btn btn-xs btn-default"><span class="gyphicon glyphicon-pencil"></span></a></td>
        <td><?= $brand['brand']?></td>
        <td><a href="brands.php?delete=<?=$brand['id']?>" class="btn btn-xs btn-default" ><span class="gyphicon glyphicon-remove-sign"></span></a></td>
      </tr>
    <?php endwhile; ?>
    </tbody>
  </table>
<?php
  include 'includes/footer.php';
?>
