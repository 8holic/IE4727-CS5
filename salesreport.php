<?php
require_once __DIR__ . '/pricechange/db.php';
$selectedDate = $_GET['date'] ?? date('Y-m-d');
$validDate = is_string($selectedDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $selectedDate)
    && DateTimeImmutable::createFromFormat('!Y-m-d', $selectedDate)?->format('Y-m-d') === $selectedDate;
if (!$validDate) $selectedDate = date('Y-m-d');
$products = ['Just Java', 'Cafe au Lait', 'Iced Cappuccino'];
$categories = ['NA', 'Single', 'Double'];
$productRows = []; $categoryRows = []; $popular = 'No sales on this date'; $bestProduct = null;
$error = '';
try {
    $db = db_connect();
    $nextDate = date('Y-m-d', strtotime($selectedDate . ' +1 day'));
    $stmt = $db->prepare('SELECT i.product, SUM(i.quantity) AS units, SUM(i.line_total) AS revenue
        FROM order_items i JOIN orders o ON o.id = i.order_id
        WHERE o.ordered_at >= ? AND o.ordered_at < ?
        GROUP BY i.product ORDER BY revenue DESC, units DESC, i.product');
    $stmt->bind_param('ss', $selectedDate, $nextDate); $stmt->execute();
    foreach ($stmt->get_result()->fetch_all(MYSQLI_ASSOC) as $row) $productRows[$row['product']] = $row;
    $stmt->close();
    $stmt = $db->prepare('SELECT COALESCE(i.category, \'NA\') AS category,
        SUM(i.quantity) AS units, SUM(i.line_total) AS revenue
        FROM order_items i JOIN orders o ON o.id = i.order_id
        WHERE o.ordered_at >= ? AND o.ordered_at < ? GROUP BY i.category');
    $stmt->bind_param('ss', $selectedDate, $nextDate); $stmt->execute();
    foreach ($stmt->get_result()->fetch_all(MYSQLI_ASSOC) as $row) $categoryRows[$row['category']] = $row;
    $stmt->close();
    if ($productRows) {
        $ranked = array_values($productRows);
        usort($ranked, fn($a, $b) => ((float)$b['revenue'] <=> (float)$a['revenue'])
            ?: ((int)$b['units'] <=> (int)$a['units']) ?: strcmp($a['product'], $b['product']));
        $bestProduct = $ranked[0]['product'];
        if ($bestProduct === 'Just Java') {
            $popular = 'N/A (Just Java has no shot options)';
        } else {
            $stmt = $db->prepare('SELECT i.category, SUM(i.quantity) AS units
               FROM order_items i JOIN orders o ON o.id = i.order_id
               WHERE o.ordered_at >= ? AND o.ordered_at < ? AND i.product = ?
               GROUP BY i.category ORDER BY units DESC, i.category ASC LIMIT 1');
            $stmt->bind_param('sss', $selectedDate, $nextDate, $bestProduct); $stmt->execute();
            $top = $stmt->get_result()->fetch_assoc();
            $popular = $top ? $top['category'] : 'N/A';
            $stmt->close();
        }
    }
    $db->close();
} catch (Throwable $e) { $error = 'Database error. Import the SQL file and start MySQL.'; }
function esc(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JavaJam - Daily Sales Report</title><link rel="stylesheet" href="Assets/style.css"></head>
<body><div id="wrapper"><header></header><div id="leftcolumn"><nav><ul>
<li><a href="menu.php">Menu</a></li><li><a href="menuadmin.php">Price Update</a></li><li><a href="salesreport.php">Sales Report</a></li>
</ul></nav></div><div id="rightcolumn"><h2>Daily Sales Report</h2><div class="content">
<form method="get" action="salesreport.php" class="date-form"><label for="date">Report date</label>
<input type="date" name="date" id="date" value="<?= esc($selectedDate) ?>" required>
<button class="coffee-button" type="submit">Generate Report</button></form>
<?php if ($error): ?><p class="error-message"><?= esc($error) ?></p><?php else: ?>
<h3>Sales by Product — <?= esc($selectedDate) ?></h3>
<table class="admin-table"><thead><tr><th>Product</th><th>Total Dollar Sales</th><th>Quantity Sales</th></tr></thead><tbody>
<?php foreach ($products as $product): $row = $productRows[$product] ?? null; ?>
<tr><td><?= esc($product) ?></td><td>$<?= number_format((float)($row['revenue'] ?? 0), 2) ?></td><td><?= (int)($row['units'] ?? 0) ?></td></tr>
<?php endforeach; ?></tbody></table>
<h3>Sales by Category</h3>
<table class="admin-table"><thead><tr><th>Category</th><th>Total Dollar Sales</th><th>Quantity Sales</th></tr></thead><tbody>
<?php foreach ($categories as $category): $row = $categoryRows[$category] ?? null; ?>
<tr><td><?= esc($category) ?></td><td>$<?= number_format((float)($row['revenue'] ?? 0), 2) ?></td><td><?= (int)($row['units'] ?? 0) ?></td></tr>
<?php endforeach; ?></tbody></table>
<h3>Best-Selling Product &amp; Popular Option</h3>
<?php if ($bestProduct): ?>
<p><strong>Best-selling (highest dollar sales) product:</strong> <?= esc($bestProduct) ?></p>
<p><strong>Most popular option (highest quantity sold):</strong> <?= esc($popular) ?></p>
<?php else: ?><p>No orders have been recorded for this date.</p><?php endif; ?>
<p class="helper-text">NA is used to represent Just Java. Rankings use revenue for best-selling product and quantity for most popular option.</p>
<?php endif; ?></div></div>
<footer><em>Copyright &copy; 2026 JavaJam Coffee House</em></footer></div></body></html>
