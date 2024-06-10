<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("INSERT INTO customers (name, email, phone) VALUES (:name, :email, :phone)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Failed to add customer.";
    }
}
?>
