<?php
include 'datahelper.php';

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   DH::updateCartQuantity($update_id, $update_value);
   header('location:cart.php');
};

if(isset($_GET['remove'])){
   DH::deleteFromCart($_GET['remove']);
   if (DH::getCartCount() == 0){
      header('location:index.php');   
   } else {
      header('location:cart.php');
   }
};

if(isset($_GET['delete_all'])){
   DH::deleteCart();
   header('location:index.php');
}

?>
<?php include('_header.php') ?>


   
<div class="shopping-container" id="icons">

<section class="shopping-cart">

   <h1 class="heading">Megvásárolni kívánt termékek</h1>

   <table>

      <thead>
         <th>Kép</th>
         <th>Neve</th>
         <th>Ár</th>
         <th>Darabszám</th>
         <th>Végösszeg</th>
         <th></th>
      </thead>

      <tbody>

         <?php
         
         $cart = DH::getCart();

         $grand_total = 0;
         foreach ($cart as $cart_item){
         ?>

         <tr>
            <td><img src="img/<?= $cart_item['image']; ?>" height="100" alt=""></td>
            <td><?= $cart_item['name']; ?></td>
            <td><?= number_format($cart_item['price'], 0, "", " ") ?> Ft / db</td>
            <td>
               <form  action="" method="post">
                  <input type="hidden" name="update_quantity_id"  value="<?= $cart_item['id']; ?>" >
                  <input type="number" name="update_quantity" min="1"  value="<?= $cart_item['quantity']; ?>" >
                  <input type="submit"  value="Frissít"  name="update_update_btn icon-arrows-cw">
               </form>   
            </td>
            <td>
               <?php $sub_total = ($cart_item['price'] * $cart_item['quantity']); ?>
               <?= number_format($sub_total, 0, "", " ") ?> Ft
            </td>
            <td><a href="cart.php?remove=<?= $cart_item['id']; ?>" onclick="return confirm('Biztos eltávolítja?')" class="delete-btn"> <i class="fas fa-trash icon-trash"></i> Eltávolít</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;
         };
         ?>
         <tr class="table-bottom">
            <td><a href="index.php" class="option-btn" style="margin-top: 0;">Vásárlás folytatása</a></td>
            <td colspan="3">Teljes összeg</td>
            <td><?= number_format($grand_total, 0, "", " ") ?> Ft</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('Biztos törli a kosár egész tartalmát?');" class="delete-btn"> <i class="fas fa-trash"></i> Kosár ürítése </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">Tovább »</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>