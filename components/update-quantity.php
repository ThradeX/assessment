<?php
session_start();

if (isset($_GET['showId']) && isset($_GET['quantity'])) {
    $showId = intval($_GET['showId']);
    $quantity = intval($_GET['quantity']);

    // Salvar a nova quantidade na sessão
    $_SESSION['quantity'][$showId] = $quantity;

    echo 'Quantity updated successfully.';
} else {
    echo 'Invalid parameters.';
}
?>