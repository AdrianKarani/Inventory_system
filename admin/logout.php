<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Inventory_system/core-system-files/init.php';
unset($_SESSION['SESSuser']);
header('Location: login.php');
?>
