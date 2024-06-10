<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM amortization WHERE customer_id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $stmt = $conn->prepare("DELETE FROM customers WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Failed to delete customer.";
    }
} else {
    echo "Invalid request.";
}
?>
