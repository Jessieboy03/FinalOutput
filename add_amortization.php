<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $principal_amount = $_POST['principal_amount'];
    $interest_rate = $_POST['interest_rate'];
    $loan_term = $_POST['loan_term'];
    $start_date = $_POST['start_date'];

    $stmt = $conn->prepare("INSERT INTO amortization (customer_id, principal_amount, interest_rate, loan_term, start_date) VALUES (:customer_id, :principal_amount, :interest_rate, :loan_term, :start_date)");
    $stmt->bindParam(':customer_id', $customer_id);
    $stmt->bindParam(':principal_amount', $principal_amount);
    $stmt->bindParam(':interest_rate', $interest_rate);
    $stmt->bindParam(':loan_term', $loan_term);
    $stmt->bindParam(':start_date', $start_date);

    if ($stmt->execute()) {
        header("Location: view_amortization.php?customer_id=$customer_id");
    } else {
        echo "Failed to add amortization.";
    }
}
?>
