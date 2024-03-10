<?php
include('./database/connection.php');

require_once './components/header.php';

if (!isset($_SESSION['quantity'])) {
    $_SESSION['quantity'] = array();
}

if (isset($_COOKIE['cart'])) {
    $showIds = json_decode($_COOKIE['cart'], true);

    if (!empty($showIds)) {
        $inIds = implode(',', array_map('intval', $showIds));
        $sql = "SELECT * FROM shows WHERE id_show IN ($inIds)";
        $res = $mysqli->query($sql);

        if ($res && $res->num_rows > 0) {
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
            hr.send();x
        }

        function redirectToPayment(totalAmount) {
            var showIds = JSON.parse('<?php echo json_encode($showIds); ?>');
            var quantities = JSON.parse('<?php echo json_encode($_SESSION['quantity']); ?>');
            var queryString = '';

            // Adiciona os IDs dos shows e suas quantidades à queryString
            showIds.forEach(function(showId, index) {
                queryString += 'showIds[]=' + showId + '&quantity[]=' + quantities[showId];
                if (index < showIds.length - 1) {
                    queryString += '&'; // Adiciona '&' para separar os parâmetros
                }
            });

            queryString += '&totalAmount=' + totalAmount; // Adiciona o totalAmount à queryString

            window.location.href = 'payment.php?' + queryString;
        }

        function updateQuantity(showId, newQuantity) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/update-quantity.php?showId=' + showId + '&quantity=' + newQuantity, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText); // Exibir a resposta do servidor (opcional)
                    location.reload(); // Recarregar a página para refletir a atualização da quantidade
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>

    <div class="checkout-content">
    <h1>Your Cart</h1>
        <?php
        $totalCartAmount = 0; // Variável para armazenar o total geral do carrinho

        $sql = "SELECT *, (s.max_tickets - s.bought) AS available_tickets FROM shows s WHERE s.id_show IN ($inIds)";
        $res = $mysqli->query($sql);

        // Loop para exibir os shows no carrinho
        while ($row = $res->fetch_assoc()) {
            $showId = $row['id_show'];
            $quantity = isset($_SESSION['quantity'][$showId]) ? $_SESSION['quantity'][$showId] : 0;
            $totalAmount = $row['price'] * $quantity;
            $totalCartAmount += $totalAmount;
            $availableTickets = $row['available_tickets'];

            echo '
            <div class="card">

                <div class="image" style="background-image: url(' . $row['image_show'] . '); background-size: cover;"></div>
            
                <div class="info-rows">
                    <div class="id-row">
                        <h2>ID</h2>
                        <p class="id">' . $row['id_show'] . '</p>
                    </div>
                    <div class="name-row">
                        <h2>NAME</h2>
                        <p class="name">' . $row['name_show'] . '</p>
                    </div>
                    <div class="price-row">
                        <h2>PRICE</h2>
                        <p class="price">$' . $row['price'] . '</p>
                    </div>
                    <div class="quantity-row">
                        <h2>QUANTITY</h2>
                        <input type="number" id="quantity_' . $row['id_show'] . '" value="' . $quantity . '" min="1" max="' . $availableTickets . '" onchange="updateQuantity(' . $row['id_show'] . ', this.value)" oninput="validity.valid||(value=``)">
                    </div>
                </div>
                
            </div>';
        }
        ?>

        <div class="total-row">
            <h2>TOTAL:</h2>
            <p>$<?php echo $totalCartAmount;?></p>
        </div>

        <button onclick="redirectToPayment(<?php echo $totalCartAmount; ?>)">Confirm</button>
    </div>

</body>

</html>

<?php
        } else {
            echo '<div class="error" style="background-color: red;">
                <h1>Your Cart</h1>
                <p>No shows on your cart</p>
            </div>';
        }
    } else {
        echo '
        <div class="error">
            <h1>Your Cart</h1>
            <p>Your cart is empty</p>
        </div>';
    }
} else {
    echo '<div class="error">
        <h1>Your Cart</h1>
        <p>Your cart is empty</p>
    </div>';
}

require_once './components/footer.php';
?>