<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $principal_amount = $_POST['principal_amount'];
    $interest_rate = $_POST['interest_rate'];
    $loan_term = $_POST['loan_term'];
    $start_date = $_POST['start_date'];

    $stmt = $conn->prepare("UPDATE amortization SET principal_amount = :principal_amount, interest_rate = :interest_rate, loan_term = :loan_term, start_date = :start_date WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':principal_amount', $principal_amount);
    $stmt->bindParam(':interest_rate', $interest_rate);
    $stmt->bindParam(':loan_term', $loan_term);
    $stmt->bindParam(':start_date', $start_date);

    if ($stmt->execute()) {
        header("Location: view_amortization.php?customer_id=" . $stmt->fetch(PDO::FETCH_ASSOC)['customer_id']);
    } else {
        echo "Failed to update amortization.";
    }
}
?>
