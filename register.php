<?php
session_start();
include('server/connection.php');
if (isset($_SESSION['logged_in'])) {
  header('location: account.php');
  exit;
}
if (isset($_POST['register'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];

  //if passwords do not match
  if ($password !== $confirmPassword) {
    header('location: register.php?error=Passwords do not match');
    //if password is less than 6 characters
  } elseif (strlen($password) < 6) {
    header('location: register.php?error=Password must be at least 6 characters');
    //if there is no error
  } else {
    //check whether there is a user with this email or not
    $stmt1 = $conn->prepare("SELECT count(*) FROM users where user_email=?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();
    //if there is a user with this email
    if ($num_rows != 0) {
      header('location: register.php?error=user with this email already exists');
      //if no user registered with this email
    } else {
      //create a new user
      $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");

      $stmt->bind_param('sss', $name, $email, md5($password));
      //if account was created successfully
      if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['logged_in'] = true;
        header('location: account.php?register_success=You registered successfully');
        //account could not be created successfully
      } else {
        header('location: register.php?error=Could not create an account at the moment');
      }
    }
  }
}
?>
<?php include('layouts/header.php'); ?>


<!--Register-->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-3">
    <h2 class="form-weight-bold">Register</h2>
    <hr class="mx-auto">
  </div>
  <div class="mx-auto container">
    <form id="register-form" method="POST" action="register.php">
      <p style="color: red;"><?php if (isset($_GET['error'])) {
                                echo $_GET['error'];
                              } ?></p>
      <div class="form-group">
        <label for="">Name</label>
        <input type="text" class="form-control" name="name" id="register-name" placeholder="Name" required>
      </div>
      <div class="form-group">
        <label for="">Email</label>
        <input type="email" class="form-control" name="email" id="register-email" placeholder="Email" required>
      </div>
      <div class="form-group">
        <label for="">Password</label>
        <input type="password" class="form-control" name="password" id="register-password" placeholder="Password" required>
      </div>
      <div class="form-group">
        <label for="">Confirm Password</label>
        <input type="password" class="form-control" name="confirmPassword" id="register-confirm-password" placeholder="Confirm Password" required>
      </div>
      <div class="form-group">
        <input type="submit" class="btn" id="register-btn" name="register" value="Register">
      </div>
      <div class="form-group">
        <a id="login-url" class="btn" href="login.php">Do you have an account? Login</a>
      </div>
    </form>
  </div>
</section>

<?php include('layouts/footer.php'); ?>