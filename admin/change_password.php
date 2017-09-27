<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/Shop/core-system-files/init.php';

// if(!logged_in()){
//   login_error_redirect();
// }


include 'includes/head.php';
global $userdata;
$hashed = $userdata['password'];

$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);

$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);

$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($password);
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
        if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
          $errors[] .= 'You must fill in all fields.';
        }

        // password>6 characters
        if(strlen($password)<6){
          $errors[] .= 'Password must be atleast <b>six</b> characters.';
        }

        // if new password matches confirmed
        if($password != $confirm){
          $errors[] = 'The new password and confirm new password do not match';
        }

        if(!password_verify($old_password, $hashed)){

        }else{
            $errors[] .= 'Your old password does not match our records.';
        }

        // check for errors
        if(!empty($errors)){
          echo display_errors($errors);
        }else{
      // change password

        }
      }
    ?>
  </div>

  <h2 class="text-center">Change Password</h2> <hr>
  <form action="change_password.php" method="post" >
    <div class="form-group">
      <label for="old_password">Old Password:</label>
      <input type="password" name="email" id="old_password" value="<?=$old_password;?>" class="form-control">
    </div>
    <div class="form-group">
      <label for="password">New Passsword:</label>
      <input type="password" name="password" id="password" value="<?=$password;?>" class="form-control">
    </div>
    <div class="form-group">
      <label for="confirm">Confirm New Password:</label>
      <input type="password" name="confirm" id="confirm" value="<?=$confirm;?>" class="form-control">
    </div>
    <div class="form-group">
      <a href="index.php" class="btn btn-default">Cancel</a>
      <input type="submit" class="btn btn-primary" value="Change">
    </div>
  </form>

  <p class="text-right"> <a href="/Shop/index.php" alt='Home'>Visit site</a></p>
</div>


<?php
include 'includes/footer.php';
?>
