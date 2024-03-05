<?php
if (isset($_GET['showId'])) {
    $showId = $_GET['showId'];

    if (!isset($_COOKIE['cart'])) {
        $cart = array();
    } else {
        $cart = json_decode($_COOKIE['cart'], true);
    }
    $cart[] = $showId;
    setcookie('cart', json_encode($cart), time() + (86400), "/");

    echo "Show adicionado ao carrinho com sucesso.";
} else {
    echo "ID do show não fornecido.";
}
?>