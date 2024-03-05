<?php
include('./database/connection.php');

require_once './components/header.php';

if (isset($_COOKIE['cart'])) {
    $showIds = json_decode($_COOKIE['cart'], true);

    $inIds = implode(',', array_map('intval', $showIds));
    $sql = "SELECT * FROM shows WHERE id_show IN ($inIds)";
    $res = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/checkout.css">

     <script>
        function removeItem(showId) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/remove-item.php?showId=' + showId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send();
        }

        function redirectToPayment() {
            var showIds = JSON.parse('<?php echo json_encode($showIds); ?>');
            var queryString = showIds.map(id => 'showIds[]=' + id).join('&');
            window.location.href = 'payment.php?' + queryString;
        }

        // function clearCart() {
        //     var xhr = new XMLHttpRequest();
        //     xhr.open('GET', './components/clear-cart.php', true);
        //     xhr.onload = function() {
        //         if (xhr.status == 200) {
        //             console.log(xhr.responseText); // Exibir a resposta do servidor (opcional)
        //             // Recarregar a página para limpar o carrinho após a operação
        //             location.reload();
        //         }
        //     };
        //     xhr.send();
        // }
    </script>
</head>
<body>
    <h1>Seu Carrinho</h1>

    <ul class="cart-list">
        <?php
        while ($row = $res->fetch_object()) {
            echo '
            <li class="cart-item">
                <!-- Seus códigos HTML para exibir informações do show no carrinho -->
                <div class="cart-item-details">
                    <h2>' . $row->name_show . '</h2>
                    <!-- Adicione outras informações do show aqui -->
                </div>
                <div class="cart-item-actions">
                    <button onclick="removeItem(' . $row->id_show . ')">REMOVE ITEM</button>
                </div>
            </li>';
        }
        ?>
    </ul>

    <button onclick="redirectToPayment()">CONFIRM</button>

    <!-- <button onclick="clearCart()">CLEAR CART</button> -->
</body>
</html>

<?php
} else {
    echo '<h1>Seu Carrinho</h1>';
    echo '<p>O seu carrinho está vazio.</p>';
}

require_once './components/footer.php';
?>