<?php
include('./database/connection.php');

require_once './components/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/global.css">
    <link rel="stylesheet" href="./style/complete.css">
</head>
<body>
    <!-- Seu menu de navegação, se necessário -->

    <div class="complete-container">
        <?php
        // Salvar os dados da compra na tabela 'purchases'
        if (isset($_SESSION['id'])) {
            $userId = $_SESSION['id'];
            $totalAmount = $_POST['total_amount']; // Supondo que o valor total seja enviado pelo formulário
            $paymentOption = $_POST['payment_option']; // Supondo que a opção de pagamento seja enviada pelo formulário

            // Inserir dados da compra na tabela 'purchases'
            $sql = "INSERT INTO purchases (user_id, total_amount, payment_option) VALUES ($userId, $totalAmount, '$paymentOption')";
            $result = $mysqli->query($sql);

            if ($result) {
                // Exibir a mensagem de sucesso
                echo '<h2>CHECKOUT COMPLETE!</h2>';
                echo '<p>Your payment is successful and the order is now complete.</p>';

                foreach ($_SESSION['quantity'] as $showId => $quantity) {
                    $updateSql = "UPDATE shows SET bought = bought + $quantity WHERE id_show = $showId";
                    $updateResult = $mysqli->query($updateSql);
                    
                    // Verificar se a atualização foi bem-sucedida
                    if (!$updateResult) {
                        // Lidar com o erro, se necessário
                        echo '<h2>Error</h2>';
                        echo '<p>There was an error updating the bought quantity for some shows.</p>';
                        exit(); // Encerrar o script se ocorrer um erro
                    }
                }

                setcookie('cart', '', time() - 3600, '/');

            } else {
                // Tratar caso a inserção na tabela 'purchases' falhe
                echo '<h2>Error</h2>';
                echo '<p>There was an error processing your order. Please try again later.</p>';
            }
        } else {
            // O usuário não está logado, redirecione para a página de login
            header("Location: login.php");
            exit();
        }
        ?>
        <div class="btn">
            <button><a href="home.php">Close</a></button>
        </div>
    </div>

    <!-- Seu código JavaScript, se necessário -->

</body>
</html>

<?php
require_once './components/footer.php';
?>