<?php
require_once __DIR__ . '/pricechange/db.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id <= 0) { http_response_code(400); exit('Invalid order ID.'); }
try {
    $db = db_connect();
    $orderStmt = $db->prepare('SELECT id, ordered_at FROM orders WHERE id = ?');
    $orderStmt->bind_param('i', $id);
    $orderStmt->execute();
    $order = $orderStmt->get_result()->fetch_assoc();
    if (!$order) { http_response_code(404); exit('Order not found.'); }
    $itemsStmt = $db->prepare('SELECT product, category, quantity, unit_price, line_total FROM order_items WHERE order_id = ? ORDER BY id');
    $itemsStmt->bind_param('i', $id);
    $itemsStmt->execute();
    $items = $itemsStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $db->close();
} catch (Throwable $e) { http_response_code(500); exit('Database error.'); }
function esc(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
$total = array_sum(array_map(fn($item) => (float)$item['line_total'], $items));
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JavaJam - Order Receipt</title><link rel="stylesheet" href="Assets/style.css"></head>
<body><div id="wrapper"><header></header><div class="content receipt-content">
<h2>Order saved successfully!</h2><p>Order #<?= (int)$order['id'] ?> · <?= esc($order['ordered_at']) ?></p>
<table class="admin-table"><thead><tr><th>Product</th><th>Shot</th><th>Quantity</th><th>Unit Price</th><th>Subtotal</th></tr></thead><tbody>
<?php foreach ($items as $item): ?><tr>
<td><?= esc($item['product']) ?></td><td><?= esc($item['category'] ?? 'N/A') ?></td>
<td><?= (int)$item['quantity'] ?></td><td>$<?= number_format((float)$item['unit_price'],2) ?></td>
<td>$<?= number_format((float)$item['line_total'],2) ?></td></tr><?php endforeach; ?>
</tbody><tfoot><tr><th colspan="4">Total</th><th>$<?= number_format($total,2) ?></th></tr></tfoot></table>
<p><a href="menu.php">Place another order</a> </p>
</div></div></body></html>
