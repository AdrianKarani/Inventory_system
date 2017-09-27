<?php
$db = mysqli_connect('127.0.0.1','root','','hardware_inventory');

session_start();

if (mysqli_connect_error()) {
echo 'Database connection failed ,errors are: '. mysqli_connect_error();
die();
}


  require_once $_SERVER['DOCUMENT_ROOT'].'/Inventory_system/config.php';
  require_once BASEURL.'helpers/helpers.php';

  if (isset($_SESSION['SESSuser'])) {
   $userid = $_SESSION['SESSuser'];
   $query = $db->query("SELECT * FROM login_table WHERE id = '$c_id'");
   $userdata = mysqli_fetch_assoc($query);
   $fn = explode(' ', $userdata['full_name']);
   $userdata['first'] = $fn[0];
   $userdata['last'] = $fn[1];
 }

  if(isset($_SESSION['SUCCESS'])){
    echo '<div class="bg-success"><p class="text-success text-center">'.$_SESSION['SUCCESS'].'</p></div>';
    unset($_SESSION['SUCCESS']);
  }

  if(isset($_SESSION['FAILED'])){
    echo '<div class="bg-danger"><p class=" text-danger text-center">'.$_SESSION['FAILED'].'</p></div>';
    unset($_SESSION['FAILED']);
  }

?>
