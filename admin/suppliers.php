<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Inventory_system/core-system-files/init.php';
// if(!logged_in()){
//   login_error_redirect();
// }


include 'includes/head.php';
include 'includes/navigation.php';


$sql = "SELECT * FROM suppliers WHERE parent = 0";
$result = $db->query($sql);
$errors = array();
$supplier = '';
$parent = '';

// edit supplier section
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  $edsql = "SELECT * FROM suppliers WHERE id = '$edit_id'";
  $edresult = $db->query($edsql);
  $edsupplier = mysqli_fetch_assoc($edresult);
}

// delete supplier section
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $delete_id = (int)$_GET['delete'];
  $delete_id = sanitize($delete_id);
  $sql = "SELECT * FROM suppliers WHERE id = '$delete_id'";
  $result = $db->query($sql);
  $supplier = mysqli_fetch_assoc($result);
  if ($supplier['parent'] == 0) {
    $delsql = "DELETE FROM suppliers WHERE id = '$delete_id'";
    $db->query($delsql);

  }
  $delsql = "DELETE FROM suppliers WHERE id = '$delete_id'";
  $db->query($delsql);
  header('Location:  suppliers.php');
}

// process form
if (isset($_POST) && !empty($_POST)) {
  $editparent = sanitize($_POST['parent']);
  $supplier = sanitize($_POST['supplier']);
  $sqlForm = "SELECT * FROM suppliers WHERE supplier_name = '$supplier' AND parent = '$editparent'";
  if (isset($_GET['edit'])) {
    $id = $edsupplier['id'];
    $sqlForm = "SELECT * FROM suppliers WHERE supplier_name = '$supplier' AND parent = '$editparent' AND id != '$id'";
  }
  $formresult = $db->query($sqlForm);
  $count = mysqli_num_rows($formresult);

  // if form is blank
  if ($supplier == '') {
    $errors[] .= 'The supplier cannot be left blank.';
  }

  // if the supplier already exists in the database
  if ($count > 0) {
    $errors[] .= $supplier. ' already exists. Please choose another.';
  }

  // display errors or insert database
  if (!empty($errors)){
  // display errors
  $display = display_errors($errors); ?>
  <script>
    jQuery('document').ready(function(){
      jQuery('#errors').html('<?=$display; ?>');
    });
  </script>
  <?php

  }else {
    // update and add a new supplier into the database
      $upsql = "INSERT INTO suppliers (supplier_name, parent) VALUES ('$supplier' , '$editparent') ";
      if (isset($_GET['edit'])) {
        $upsql = "UPDATE suppliers SET supplier_name = '$supplier', parent = '$editparent' WHERE id = '$edit_id' ";
      }
      $db->query($upsql);
      header('Location: suppliers.php');
    }
  }
   $supplier_value = '';
   $parent_value = 0;
   if(isset($_GET['edit'])){
     $supplier_value = $edsupplier['supplier_name'];
     $parent_value = $edsupplier['parent'];
   }else {
     if (isset($_POSt)) {
       $supplier_value = $supplier;
       $parent_value = $editparent;
     }
   }
  ?>

<h2 class="text-center">Suppliers</h2> <hr>
<div class="row">

  <!-- supplier form -->
  <div class="col-md-6">
    <form class="form" action="suppliers.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post" >
      <legend><?=((isset($_GET['edit']))?'Edit':'Add a');?> Supplier</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label for="parent">Item type</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0"<?=(($parent_value == 0)?' selected="selected"':'')?>>Item type</option>
          <?php while($parent = mysqli_fetch_assoc($result)) : ?>
          <option value="<?=$parent['id'];?>"<?=(($parent_value == $parent['id'])?' selected="selected"':'')?>><?=$parent['supplier_name'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="supplier">Supplier</label>
        <input type="text" id="supplier" name="supplier" value="<?=$supplier_value;?>"  class="form-control">
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Add a New');?> Supplier">
      </div>
    </form>
  </div>

<!-- supplier table -->
  <div class="col-md-6">
    <table class="table table-bordered" >
      <thead>
        <th>Supplier</th>
        <th>Item type</th>
        <th></th>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM suppliers WHERE parent = 0";
        $result = $db->query($sql);

            while($parent = mysqli_fetch_assoc($result)):
            $parent_id = (int)$parent['id'];
            $sql2 = "SELECT * FROM suppliers WHERE parent = '$parent_id'";
            $child_result = $db->query($sql2);
        ?>
        <tr class="bg-primary">
          <td><?=$parent['supplier_name'];?></td>
          <td></td>
          <td>
            <a href="suppliers.php?edit=<?=$parent['id'];?>" class="btn btn-xs btn default"><span class="glyphhicon glyphicon-pencil"></span></a>
            <a href="suppliers.php?delete=<?=$parent['id'];?>" class="btn btn-xs btn default"><span class="glyphhicon glyphicon-remove"></span></a>
          </td>
        </tr>
        <?php
          while($child =mysqli_fetch_assoc($child_result) ):
        ?>
        <tr class="bg-info">
          <td><?=$child['supplier_name'];?></td>
          <td><?=$parent['supplier_name'];?></td>
          <td>
            <a href="suppliers.php?edit=<?=$child['id'];?>" class="btn btn-xs btn default"><span class="glyphhicon glyphicon-pencil"></span></a>
            <a href="suppliers.php?delete=<?=$child['id'];?>" class="btn btn-xs btn default"><span class="glyphhicon glyphicon-remove"></span></a>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php endwhile;?>
      </tbody>
    </table>
  </div>
</div>
