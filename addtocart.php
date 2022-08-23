<?php
include_once('datahelper.php');

if(!isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] < 1){
    header('Location: login.php');
}

$message = array();

if(isset($_POST['add_to_cart'])){

    $t_id = (int)$_POST['termek_id'];

    $termek = DH::getProduct($t_id);

    if ($termek !== false && !empty($termek)){
        
        if (DH::isInCart($t_id)) {
            DH::increaseInCart($t_id);
        } else {
            DH::addToCart($t_id);
        }
        
    } else {
        $message[] = "Termék nem található";
    }

}