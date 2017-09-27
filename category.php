<?php
require_once 'core-system-files/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  include 'includes/left-bar.php';

  if(isset($_GET['cat'])){
    $cat_id = sanitize($_GET['cat']);
  }else{
    $cat_id = '';
  }


  $sql = "SELECT * FROM products WHERE categories = '$cat_id'";
  $productQ = $db->query($sql);
  $category = get_category($cat_id);

?>

    <!-- main content -->
    <div class="col-md-8">
      <div class="row">
        <h2 class="text-center"><?=$category['parent'].' '.$category['child']?></h2>
        <?php while($products = mysqli_fetch_assoc($productQ)) : ?>
          <div class="col-md-3">
            <h4><?= $products['title']; ?></h4>
              <img src="<?= $products['image']; ?>" alt="<?= $products['title']; ?>" class="img" />
              <p class="list-price text-danger">List Price: <s>Ksh <?= $products['list_price']; ?> </s></p>
              <p class="price">Our Price: Ksh <?= $products['price']; ?></p>
              <button type="button" class="btn btn-sm btn-success"
                onclick="detailsmodal(<?= $products['id']; ?>)">Details</button>
          </div>
        <?php endwhile; ?>
      </div>
    </div>

<?php
  include 'includes/right-bar.php';
  include 'includes/footer.php';
?>
