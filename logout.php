<?php
session_start();
//1. variacio , kiűrít mindent , ami a $_SESSION tömbben van
//session_destroy();
//2. variacio, ezzel csak az adott kulcsot szedem ki a S_SESSION tömbből.
unset($_SESSION['user_id']);
//vissza írányít a login.php-ra
header('Location: login.php');
