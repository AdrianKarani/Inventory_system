<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Inventory_system/core-system-files/init.php';
if(!logged_in()){
  login_error_redirect();
}

include 'includes/head.php';
include 'includes/navigation.php';


$sql = "SELECT * FROM products WHERE archived != 1";
$productResult = $db->query($sql);

if (isset($_GET['featured'])) {
  $id = (int)$_GET['id'];
  $featuredProd = (int)$_GET['featured'];
  $featuredsql = "UPDATE products SET featured = '$featuredProd' WHERE id = '$id'";
  $db->query($featuredsql);
  header('Location: products.php');
}
?>

<h2 class="text-center">Products</h2>
<a href="product.php?add=1" class="btn btn-success pull-right" id="add_prod">Add Product</a>
<div class="clearfix"></div>
<hr>
<table class="table table-bordered table-condensed table-striped">
  <thead>
    <th></th>
    <th>Product</th>
    <th>Price</th>
    <th>Category</th>
    <th>Feature</th>
    <th>Sold</th>
  </thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($productResult)):
          $Child_id = $product['categories'];
          $Child_sql = "SELECT * FROM categories WHERE id = '$Child_id'";
          $ChildResult = $db->query($Child_sql);
          $child = mysqli_fetch_assoc($Child_sql);

            if($child === FALSE) {
              die(mysqli_error());
          }
          $Parentid = $child['parent'];
          $Parentsql = "SELECT * FROM categories WHERE id = '$Parentid'";
          $Parentresult = $db->query($Parentsql);
          $parent = mysqli_fetch_assoc($Parentresult);
          $category = $parent['category'].' -- '.$child['category'];


    ?>
      <tr>
        <td> <a href="products.php?edit=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
             <a href="products.php?archive=<?=$product['id']?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span>
        </td>
        <td> <?=$product['title']?> </td>
        <td> <?=money($product['price']);?> </td>
        <td> <?=$category;?> </td>
        <td> <a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-<?=(($product['featured']==1)?'minus':'plus');?>"></span>
        </a> &nbsp <?=(($product['featured'] == 1)?'Featured':'');?>
      </td>
      <!-- none breaking space -->
        <td>0</td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<?php
include 'includes/footer.php';
?>
