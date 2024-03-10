<?php
include('./database/connection.php');

require_once './components/header.php';

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_payment'])) {
    // Obtém os dados do formulário
    $totalAmount = $_POST['total_amount'];
    $paymentOption = $_POST['payment_option'];
    $userId = $_SESSION['id']; // Supondo que você já tenha o ID do usuário disponível na sessão

    // Insere os dados na tabela purchases
    $insertPurchaseQuery = "INSERT INTO purchases (user_id, total_amount, payment_option) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($insertPurchaseQuery);
    $stmt->bind_param("ids", $userId, $totalAmount, $paymentOption);
    $stmt->execute();
    $purchaseId = $stmt->insert_id; // Obtém o ID da compra inserida

    // Insere os detalhes da compra na tabela purchase_details
    foreach ($_SESSION['cart'] as $showId => $quantity) {
        $insertPurchaseDetailQuery = "INSERT INTO purchase_details (purchase_id, show_id, quantity) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($insertPurchaseDetailQuery);
        $stmt->bind_param("iii", $purchaseId, $showId, $quantity);
        $stmt->execute();
    }

    // Redireciona para a página de conclusão
    header("Location: complete.php");
    exit();
} else {
    // Se o formulário não foi enviado corretamente, redirecione de volta para a página de pagamento
    header("Location: checkout.php");
    exit();
}
?>



<?php
require_once './components/footer.php';
?>