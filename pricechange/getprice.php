<?php
$conn = new mysqli("localhost", "root", "", "price");

$result = $conn->query("SELECT name, price FROM coffeprice");
$prices = [];
while($row = $result->fetch_assoc()) {
    $prices[$row['name']] = $row['price'];
}
$conn->close();
?>