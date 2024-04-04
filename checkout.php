<?php
include('./database/connection.php');

require_once './components/header.php';

if (!isset($_SESSION['quantity'])) { // Checking if the 'quantity' session variable is set.
    $_SESSION['quantity'] = array(); // Initializing 'quantity' session variable if not set.
}

$inIds = ''; // Initializing a variable to store the comma-separated list of show IDs.

if (isset($_COOKIE['cart'])) { // Checking if the 'cart' cookie is set.
    $showIds = json_decode($_COOKIE['cart'], true); // Decoding the 'cart' cookie value to retrieve show IDs.

    if (!empty($showIds)) { // Checking if the list of show IDs is not empty.
        $inIds = implode(',', array_map('intval', $showIds)); // Converting show IDs to comma-separated string for SQL query.
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="./style/global.css">
     <link rel="stylesheet" href="./style/checkout.css">

     <script>
        function removeItem(showId) { // Function to remove an item from the cart.
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/remove-item.php?showId=' + showId, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    console.log(xhr.responseText);
                    location.reload(); // Reloading the page after removing an item.
                }
            };
            hr.send();x
        }

        function redirectToPayment(totalAmount) { // Function to redirect to payment page with show IDs, quantities, and total amount.
            var showIds = JSON.parse('<?php echo json_encode($showIds); ?>');
            var quantities = JSON.parse('<?php echo json_encode($_SESSION['quantity']); ?>');
            var queryString = '';

            // Adiciona os IDs dos shows e suas quantidades à queryString
            showIds.forEach(function(showId, index) {
                queryString += 'showIds[]=' + showId + '&quantity[]=' + quantities[showId];
                if (index < showIds.length - 1) {
                    queryString += '&'; // Adding '&' to separate parameters.
                }
            });

            queryString += '&totalAmount=' + totalAmount; // Adding total amount to the query string.

            window.location.href = 'payment.php?' + queryString; // Redirecting to payment page with query string.
        }

        function updateQuantity(showId, newQuantity) { // Function to update the quantity of a show in the cart.
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './components/update-quantity.php?showId=' + showId + '&quantity=' + newQuantity, true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    // console.log(xhr.responseText);
                    location.reload(); // Reloading the page to reflect quantity update.
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
        $totalCartAmount = 0; // Variable to store the total cart amount.

        $sql = "SELECT *, (s.max_tickets - s.bought) AS available_tickets FROM shows s WHERE s.id_show IN ($inIds)";
        $res = $mysqli->query($sql);

        // Loop to display shows in the cart.
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
                        <h2>ID: &nbsp;</h2>
                        <p class="id">' . $row['id_show'] . '</p>
                    </div>
                    <div class="name-row">
                        <h2>NAME: &nbsp;</h2>
                        <p class="name">' . $row['name_show'] . '</p>
                    </div>
                    <div class="price-row">
                        <h2>PRICE: &nbsp;</h2>
                        <p class="price">$' . $row['price'] . '</p>
                    </div>
                    <div class="quantity-row">
                        <h2>QUANTITY: &nbsp;</h2>
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

        <button class="confirm-btn" onclick="redirectToPayment(<?php echo $totalCartAmount; ?>)">Confirm</button>
    </div>

</body>

</html>

<?php
    }
} else { // Displaying a message if the cart is empty.
    echo '
    <div class="empty-cart">
        <h1 style="margin-top: 50px; margin-bottom: 30px; color: #2741B2; font-size: 4em; text-align: center">Your Cart</h1>
        <h2 style="text-align: center;">Your cart is empty</h2>
    </div>';
}

require_once './components/footer.php';
?>