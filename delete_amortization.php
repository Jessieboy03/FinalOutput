<?php
include 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT customer_id FROM amortization WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $amortization = $stmt->fetch(PDO::FETCH_ASSOC);
    $customer_id = $amortization['customer_id'];

    $stmt = $conn->prepare("DELETE FROM amortization WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: view_amortization.php?customer_id=$customer_id");
    } else {
        echo "Failed to delete amortization.";
    }
} else {
    echo "Invalid request.";
}
?>
