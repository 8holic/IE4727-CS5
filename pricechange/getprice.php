<?php
require_once __DIR__ . '/db.php';
$db = db_connect();
$prices = [];
$result = $db->query('SELECT name, price FROM coffeprice');
while ($row = $result->fetch_assoc()) {
    $prices[$row['name']] = (float)$row['price'];
}
$db->close();
