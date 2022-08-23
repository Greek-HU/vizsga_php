<?php include 'addtocart.php'; ?>

<?php include('_header.php') ?>

<?php
$termekek = DH::getProducts();
if ($termekek === false){
  echo "Az adatok nem állnak rendelkezésre!";
}
?>

<main class="index_container">
  <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 fst-italic">Minden az alaptól a tetőig!</h1>
      <p class="lead my-3">Alap építés, falak, hidegburkolat, tetőtér kiépítési kellékek, szaniterek és sok más...</p>
      
    </div>
  </div>
  <div class="row mb-2" id="product">
    <?php foreach ($termekek as $termek){ ?>
      
      <form class="cards col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12" method="POST" action="">
          <div class="card">
              <img class="card-img-top img-fluid" id="t_kep" src="img/<?php print $termek['image']; ?>" height="100" alt=<?php print($termek['image']); ?>>
              <div class="card-body">
                <strong class="d-inline-block mb-2 text-primary"><?php print($termek['name']); ?></strong>
                <h3 class="card-title"></h3>
                <p class="card-text" id="megnevezes"><?= $termek['description'] ?></p>
                <p class="card-text mb-auto" id="ar"><?= $termek['price'] ?> Ft</p>
                <input type="hidden" name="termek_id" value="<?= $termek['id'] ?>">
                <button href="#" class="addToCart btn btn-primary" value="addtocart" name="add_to_cart">Kosárba</button>
              </div>
          </div>
      </form>
      
    <?php } ?>
    
  </div>

</main>

<?php include('_footer.php');