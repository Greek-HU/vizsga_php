<?php

@include 'datahelper.php';

if(isset($_POST['order_btn'])){

   $name = $_POST['name'];
   $number = $_POST['number'];
   $email = $_POST['email'];
   $method = $_POST['method'];
   //$flat = $_POST['flat'];
   $street = $_POST['street'];
   $city = $_POST['city'];
   //$state = $_POST['state'];
   $country = $_POST['country'];
   $pin_code = $_POST['pin_code'];


   $cart = DH::getCart();

   $prod_pcs = array();
   $price_total = 0;
   foreach ($cart as $cart_item){
      $prod_pcs[] = $cart_item['name'] .' ('. $cart_item['quantity'] .') ';
      $product_price = ($cart_item['price'] * $cart_item['quantity']);
      $price_total += $product_price;
   }

   $total_product = implode(', ',$prod_pcs);
   $detail_query = DH::order($name, $total_product, $price_total);
   
   if($detail_query){
      echo "
      <div class='order-message-container'>
      <div class='message-container'>
         <h3>Köszönjük a vásárlást!</h3>
         <div class='order-detail'>
            <span>".$total_product."</span>
            <span class='total'> Összesen : ".$price_total."Ft</span>
         </div>
         <div class='customer-details'>
            <p> Az ön neve : <span>".$name."</span> </p>
            <p> Telefonszáma : <span>".$number."</span> </p>
            <p> E-mail címe : <span>".$email."</span> </p>
            <p> Póstázási/Számlázási címe : <span>".$street.", ".$city.", ".$country." - ".$pin_code."</span> </p>
            <p> Fizetési mód : <span>".$method."</span> </p>
         </div>
            <a href='index.php' class='btn'>Tovább a vásárláshoz</a>
         </div>
      </div>
      ";
      DH::deleteCart();
      
   }

}

?>

<?php include('_header.php'); ?>

<div class="container">

<section class="checkout-form">

   <h1 class="heading">Rendelés véglegesítése</h1>

   <form action="" method="post">

   <div class="display-order">
      <?php
      $total = 0;
      $grand_total = 0;
      if (DH::getCartCount() > 0) {
         foreach (DH::getCart() as $cart_item){
            $total_price = ($cart_item['price'] * $cart_item['quantity']);
            $grand_total = $total += $total_price;
         ?>
      <span><?= $cart_item['name']; ?>(<?= $cart_item['quantity']; ?>)</span>
      <?php }
      } else {
         echo "<div class='display-order'><span>A kosara üres!</span></div>";
      }
      ?>
      <span class="grand-total"> Teljes összeg : <?= $grand_total; ?> Ft</span>
   </div>

      <div class="flex">
         <div class="inputBox">
            <span>Teljes név</span>
            <input type="text" placeholder="az ön neve" name="name" required>
         </div>
         <div class="inputBox">
            <span>Telefonszám</span>
            <input type="number" placeholder="az ön telefonszáma" name="number" required>
         </div>
         <div class="inputBox">
            <span>Email cím</span>
            <input type="email" placeholder="az email címe" name="email" required>
         </div>
         <div class="inputBox">
            <span>Fizetés módja</span>
            <select name="method">
               <option value="Utánvét" selected>Kézpénz</option>
               <option  value="Bank kártya"class="icon-cc-visa">Bank Kártya</option>
               <option value="paypal">Utánvét</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Irányítószám</span>
            <input type="text" placeholder="" name="pin_code" required>
         </div>
         <div class="inputBox">
            <span>Utca neve</span>
            <input type="text" placeholder="" name="street" required>
         </div>
         <div class="inputBox">
            <span>Város</span>
            <input type="text" placeholder="" name="city" required>
         </div>
         <div class="inputBox">
            <span>Ország</span>
            <input type="text" placeholder="e.g. maharashtra" name="country" required>
         </div>
         
      </div>
      <input type="submit" value="Megrendel" name="order_btn" class="btn">
   </form>

</section>

</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include('_footer.php'); ?> 