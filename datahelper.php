<?php

include_once("conf.php");

Class DH {
    private static $_conn;
    private static $_user_id = 0;

    public static function init($server, $user, $password, $db){
        self::$_conn = new mysqli($server, $user, $password, $db);
        self::$_user_id = (int)$_SESSION['user_id'];
    }

    public static function getUserName(){
        $result = false;
        $_r = mysqli_query(self::$_conn, "SELECT user_name FROM users WHERE id = ". (int)self::$_user_id);
        if ($_r){
             $r = mysqli_fetch_assoc($_r);
             $result = $r['user_name'];
        }
        return $result;
        
    }

    public static function getProducts(int $limit = 3, int $offset = 0)
    {
        $result = [];
        $sql = "SELECT t.id, t.name, t.description, prices.price, image, manufacturers.name as gyarto_nev FROM products t 
        INNER JOIN prices ON (prices.id = t.price_id) INNER JOIN manufacturers ON (manufacturers.id = t.manufacturer_id) ";
        $sql .= "ORDER BY t.name ASC"; // ascending
        //$sql .= "ORDER BY t.megnevezes DESC"; // descending
    
        //TODO limit, offset
        $_r = mysqli_query(self::$_conn, $sql);
        if ($_r) {
           while($row = mysqli_fetch_assoc($_r)){
               $result[] = $row;
           }
        } else {
            return false;
        }
        return $result;
    }

    public static function getProduct($product_id){
        $result = false;
        $_r = mysqli_query(self::$_conn, "SELECT * FROM `products` WHERE id = " . $product_id);
        if ($_r){
            $result = mysqli_fetch_assoc($_r);
        }
        return $result;
    }

    public static function getCartCount(){
        $select_rows = mysqli_query(self::$_conn, "SELECT * FROM `carts` WHERE user_id = " . self::$_user_id) or die('query failed');
        return (int)mysqli_num_rows($select_rows);
    }

    public static function getCart(){
        $cart = array();
        $c = mysqli_query(self::$_conn, "SELECT carts.id as id, carts.quantity, products.id as product_id, products.name, products.image, prices.price
        FROM `carts` INNER JOIN products ON (products.id = carts.product_id) INNER JOIN prices ON (prices.id = products.price_id)");
        if(mysqli_num_rows($c) > 0){
           while($f = mysqli_fetch_assoc($c)){
            $cart[] = $f;
           }
        }
        return $cart;
    }

    public static function isInCart($product_id){
        $select_rows = mysqli_query(self::$_conn, "SELECT * FROM `carts` WHERE user_id = " . self::$_user_id . " AND product_id = ". (int)$product_id) or die('query failed');
        return (int)mysqli_num_rows($select_rows) > 0;
    }

    public static function addToCart($product_id){
        mysqli_query(self::$_conn, "INSERT INTO `carts`(user_id, product_id, quantity) VALUES (" . self::$_user_id ." , " . $product_id . ", 1)");
    }

    public static function increaseInCart($product_id){
        mysqli_query(self::$_conn, "UPDATE `carts` SET quantity = quantity + 1 WHERE user_id = " . self::$_user_id . " AND product_id = " . $product_id);
    }

    public static function deleteFromCart($cart_id){
        mysqli_query(self::$_conn, "DELETE FROM `carts` WHERE id = '$cart_id' AND user_id = " . self::$_user_id);
    }

    public static function deleteCart(){
        mysqli_query(self::$_conn, "DELETE FROM `carts` WHERE user_id = " . self::$_user_id);
    }

    public static function updateCartQuantity($cart_id, $qty){
        mysqli_query(self::$_conn, "UPDATE `carts` SET quantity = '$qty' WHERE id = '$cart_id' AND user_id = " . self::$_user_id);
    }

    public static function order($name, $number, $email, $method, $street, $city, $country, $prod_pcs, $pin_code, $price_total){
        //(name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')
        $detail_query = mysqli_query(self::$_conn, "INSERT INTO `orders`(name, number, email, method, street, city, country, prod_pcs, pin_code, total_price) VALUES ('$name', '$number','$email','$method','$street','$city','$country','$prod_pcs', $pin_code, '$price_total')") or die('query failed');
        return $detail_query;
    }
   
}

DH::init($server, $user, $password, $db);
