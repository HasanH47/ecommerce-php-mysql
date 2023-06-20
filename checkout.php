<?php
session_start();

if (!empty($_SESSION['cart']) && isset($_POST['checkout'])) {
  //let user in
} else {
  //send user to hom page
  header('location: index.php');
}
?>
<?php include('layouts/header.php'); ?>


<!--Checkout-->
<section class="my-5 py-5">
  <div class="container text-center mt-3 pt-3">
    <h2 class="form-weight-bold">Check Out</h2>
    <hr class="mx-auto">
  </div>
  <div class="mx-auto container">
    <form id="checkout-form" method="POST" action="server/place_order.php">
      <div class="form-group checkout-small-element">
        <label for="">Name</label>
        <input type="text" class="form-control" name="name" id="checkout-name" placeholder="Name" required>
      </div>
      <div class="form-group checkout-small-element">
        <label for="">Email</label>
        <input type="email" class="form-control" name="email" id="checkout-email" placeholder="Email" required>
      </div>
      <div class="form-group checkout-small-element">
        <label for="">Phone Number</label>
        <input type="tel" class="form-control" name="phone" id="checkout-phone" placeholder="Phone Number" required>
      </div>
      <div class="form-group checkout-small-element">
        <label for="">City</label>
        <input type="text" class="form-control" name="city" id="checkout-city" placeholder="City" required>
      </div>
      <div class="form-group checkout-large-element">
        <label for="">Address</label>
        <input type="text" class="form-control" name="address" id="checkout-address" placeholder="Address" required>
      </div>
      <div class="form-group checkout-btn-container">
        <p>Total amount: $ <?php echo $_SESSION['total']; ?></p>
        <input type="submit" class="btn" id="checkout-btn" name="place_order" value="Place Order">
      </div>
    </form>
  </div>
</section>

<?php include('layouts/footer.php'); ?>