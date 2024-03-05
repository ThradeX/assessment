<?php
if (isset($_GET['showId'])) {
    $showId = $_GET['showId'];

    if (isset($_COOKIE['cart'])) {
        $showIds = json_decode($_COOKIE['cart'], true);

        $index = array_search($showId, $showIds);

        if ($index !== false) {
            unset($showIds[$index]);

            setcookie('cart', json_encode($showIds), time() + (86400), "/");

            echo "Show removido do carrinho com sucesso.";
        } else {
            echo "O show não foi encontrado no carrinho.";
        }
    } else {
        echo "O carrinho está vazio.";
    }
} else {
    echo "ID do show não fornecido.";
}
?>