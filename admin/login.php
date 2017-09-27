<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Inventory_system/core-system-files/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>

<style media="screen">
#login-form{
  width:50%;
  height:60%;
  border: 2px solid #000;
  border-radius: 15px;
  box-shadow: 7px 7px 15px rgba(0,0,0,6);
  margin: 7% auto;
  padding: 15px;
  background-color: #fff;
}
</style>
<div id="login-form">

  <div>
    <?php
    if($_POST){
        // form validation
        if(empty($_POST['email']) || empty($_POST['password'])){
          $errors[] .= 'You must provide email and password.';
        }

        // validate email
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
          $errors[] .= 'You must enter a valid email';
        }

        // password>6 characters
        if(strlen($password)<6){
          $errors[] .= 'Password must be atleast <b>six</b> characters.';
        }

        // check if user/email exists
        $query = $db->query("SELECT * FROM  login_table WHERE email = '$email'");
        $user = mysqli_fetch_assoc($query);
        $userCount = mysqli_num_rows($query);
        if($userCount < 1) {
          $errors[] .= 'That email does not exist ';
        }

        if(!password_verify($password, $user['password'])){

        }else{
            $errors[] .= 'Invalid password.';
        }

        // check for errors
        if(!empty($errors)){
          echo display_errors($errors);
        }else{
          $userid = $user['c_id'];
          login($c_id);
        }
      }
    ?>
  </div>

  <h2 class="text-center">Login</h2> <hr>
  <form action="login.php" method="post" >
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" id="email" value="<?=$email;?>" class="form-control">
    </div>
    <div class="form-group">
      <label for="password">Passsword:</label>
      <input type="password" name="password" id="password" value="<?=$password;?>" class="form-control">
    </div>
    <div class="form-group">
      <input type="submit" class="btn btn-success" value="Login">
    </div>
  </form>

</div>


<?php
include 'includes/footer.php';
?>
