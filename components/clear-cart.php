<?php
setcookie('cart', '', time() - 3600, '/');

echo "Carrinho limpo com sucesso.";
?>