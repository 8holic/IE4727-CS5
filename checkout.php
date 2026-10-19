<?php
require_once __DIR__ . '/pricechange/db.php';
// CS5(ii): DO NOT trust subtotal / price fields from the browser.
// Recalculate from quantities, shot choices and prices in the database.
function order_qty(string $field): int {
    $value = $_POST[$field] ?? '0';
    if (!is_string($value) || !preg_match('/^\d{1,3}$/', $value) || (int)$value > 999) {
        throw new InvalidArgumentException('Invalid quantity in ' . $field . '. Use a whole number between 0 and 999.');
    }
    return (int)$value;
}
try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: menu.php'); exit;
    }
    $javaQty = order_qty('QtyJava');
    $cafeQty = order_qty('QtyCafe');
    $capQty = order_qty('QtyCap');
    if ($javaQty + $cafeQty + $capQty === 0) {
        throw new InvalidArgumentException('Choose at least one coffee before checking out.');
    }
    $items = [];
    if ($javaQty) $items[] = ['Just Java', null, $javaQty, 'Just_Java'];
    if ($cafeQty) {
        $shot = $_POST['CafeShot'] ?? '';
        if (!in_array($shot, ['single', 'double'], true)) {
            throw new InvalidArgumentException('Choose Single or Double for Cafe au Lait.');
        }
        $items[] = ['Cafe au Lait', ucfirst($shot), $cafeQty, 'Cafe_au_Lait_' . $shot];
    }
    if ($capQty) {
        $shot = $_POST['CapShot'] ?? '';
        if (!in_array($shot, ['single', 'double'], true)) {
            throw new InvalidArgumentException('Choose Single or Double for Iced Cappuccino.');
        }
        $items[] = ['Iced Cappuccino', ucfirst($shot), $capQty,
                    $shot === 'single' ? 'Iced_Cappuccino_sing' : 'Iced_Cappuccino_doub'];
    }
    $db = db_connect();
    $db->begin_transaction();
    try {
        // Lock prices for a consistent purchase; use the values currently stored in MySQL.
        $priceStmt = $db->prepare('SELECT price FROM coffeprice WHERE name = ? FOR UPDATE');
        $db->query('INSERT INTO orders () VALUES ()');
        $orderId = $db->insert_id;
        $itemStmt = $db->prepare('INSERT INTO order_items (order_id,product,category,quantity,unit_price,line_total) VALUES (?,?,?,?,?,?)');
        foreach ($items as [$product, $category, $quantity, $priceKey]) {
            $priceStmt->bind_param('s', $priceKey);
            $priceStmt->execute();
            $priceRow = $priceStmt->get_result()->fetch_assoc();
            if (!$priceRow) throw new RuntimeException('Missing product price: ' . $priceKey);
            $unitPrice = (float)$priceRow['price'];
            $lineTotal = round($unitPrice * $quantity, 2);
            $itemStmt->bind_param('issidd', $orderId, $product, $category, $quantity, $unitPrice, $lineTotal);
            $itemStmt->execute();
        }
        $priceStmt->close();
        $itemStmt->close();
        $db->commit();
    } catch (Throwable $e) {
        $db->rollback(); throw $e;
    }
    $db->close();
    header('Location: receipt.php?id=' . $orderId, true, 303);
    exit;
} catch (Throwable $e) {
    http_response_code($e instanceof InvalidArgumentException ? 400 : 500);
    $errorText = $e instanceof InvalidArgumentException ? $e->getMessage() : 'Unable to save the order. Verify database setup and try again.';
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Checkout Error</title><link rel="stylesheet" href="Assets/style.css"></head>
<body><div id="wrapper"><header></header><div class="content"><h2>Checkout could not be completed</h2>
<p class="error-message"><?= htmlspecialchars($errorText, ENT_QUOTES, 'UTF-8') ?></p><p><a href="menu.php">Return to Menu</a></p></div></div></body></html>
