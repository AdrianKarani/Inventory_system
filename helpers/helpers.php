<?php
  function display_errors($errors){
    $display = '<ul class = "bg-danger">';
    foreach ($errors as $error) {
      $display .='<li class="text-danger">'.$error.'</li>';
    }
      $display .='</ul>';
      return $display;
  }

  function sanitize($dirty){
    return htmlentities($dirty, ENT_QUOTES,"UTF-8");
  }

  function money($value){
    return 'Ksh' . number_format($value,2);
  }

  function login($userid){
    $_SESSION['SESSuser'] = $c_id;
    // updates the last seen
    global $db;
    $date = date("Y-m-d H:i:s");
    $db->query("UPDATE login_table SET last_seen = '$date' WHERE c_id = '$userid'");
    $_SESSION['SUCCESS'] = 'You are now logged in';
    header('Location: index.php');
  }

  function logged_in(){
    if((isset($_SESSION['SESSuser']) && $_SESSION['SESSuser'] > 0))
    {
      return true;
    }
      return false;
    }

    function login_error_redirect($url = 'login.php'){
      $_SESSION['FAILED'] = 'You must be logged in to access that page';
      header('Location: '.$url);
    }

    function permission_error_redirect($url = 'brands.php'){
      $_SESSION['FAILED'] = 'You do not have permission to access Student Details';
      header('Location: '.$url);
    }

    function has_permission($permission = 'admin'){
      global $userdata;
      $permissions = explode(',', $userdata['permissions']);
      if(in_array($permission, $permissions,true)){
        return true;
      }else{
        return false;
      }
    }

    function r_date($date){
      return date("M d, Y h:i A", strtotime($date));
    }

    function get_category($child_id){
      global $db;
      $id = sanitize($child_id);
      $sql = "SELECT p.id AS 'pid', p.suplier_name AS 'parent', c.id AS 'cid', c.supplier_name AS 'child'
      FROM suppliers c
      INNER JOIN suppliers p
      ON c.parent = p.id
      WHERE c.id = '$id'";

      $query = $db->query($sql);
      $category = mysqli_fetch_assoc($query);
      return $category;
    }
?>
