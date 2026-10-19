<?php
require_once __DIR__ . '/pricechange/db.php';
$products = [
    'Just_Java' => 'Just Java - Endless Cup',
    'Cafe_au_Lait_single' => 'Cafe au Lait - Single',
    'Cafe_au_Lait_double' => 'Cafe au Lait - Double',
    'Iced_Cappuccino_sing' => 'Iced Cappuccino - Single',
    'Iced_Cappuccino_doub' => 'Iced Cappuccino - Double',
];
$message = '';
$errors = [];
try {
    $db = db_connect();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $selected = $_POST['selected'] ?? [];
        $updates = $_POST['prices'] ?? [];
        if (!is_array($selected) || !is_array($updates) || count($selected) === 0) {
            $errors[] = 'Select at least one product.';
        } else {
            foreach ($selected as $key) {
                if (!is_string($key) || !isset($products[$key])) {
                    $errors[] = 'Invalid product selected.';
                    continue;
                }
                $price = $updates[$key] ?? '';
                if (!is_string($price) || !preg_match('/^\d{1,3}(?:\.\d{1,2})?$/', $price) || (float)$price <= 0) {
                    $errors[] = "Enter a valid price greater than zero (up to 2 decimal places) for {$products[$key]}.";
                }
            }
        }
        if (!$errors) {
            $db->begin_transaction();
            try {
                $statement = $db->prepare('UPDATE coffeprice SET price = ? WHERE name = ?');
                foreach ($selected as $key) {
                    $newPrice = (float)$updates[$key];
                    $statement->bind_param('ds', $newPrice, $key);
                    $statement->execute();
                }
                $statement->close();
                $db->commit();
                $message = 'Price update saved. The current prices below were retrieved from MySQL.';
            } catch (Throwable $e) {
                $db->rollback();
                throw $e;
            }
        }
    }
    $result = $db->query('SELECT name, price FROM coffeprice');
    $prices = [];
    while ($row = $result->fetch_assoc()) $prices[$row['name']] = $row['price'];
    $db->close();
} catch (Throwable $e) {
    $errors[] = 'Database error. Make sure MySQL is running and the SQL file was imported.';
    $prices = [];
}
function esc(string $text): string { return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>JavaJam - Product Price Update</title><link rel="stylesheet" href="Assets/style.css"></head>
<body><div id="wrapper"><header></header>
<div id="leftcolumn"><nav><ul><li><a href="index.html">Home</a></li><li><a href="menu.php">Menu</a></li>
<li><a href="menuadmin.php">Price Update</a></li><li><a href="salesreport.php">Sales Report</a></li></ul></nav></div>
<div id="rightcolumn"><h2>Product Price Update</h2><div class="content">
<p>Check a coffee blend, enter its new selling price, then click <strong>Update Prices</strong>.</p>
<?php if ($message): ?><p class="success-message"><?= esc($message) ?></p><?php endif; ?>
<?php foreach ($errors as $error): ?><p class="error-message"><?= esc($error) ?></p><?php endforeach; ?>
<form method="post" action="menuadmin.php" id="adminPriceForm">
<table class="admin-table"><thead><tr><th>Update?</th><th>Product / Category</th><th>Current price</th><th>New price ($)</th></tr></thead><tbody>
<?php foreach ($products as $key => $label): ?>
<tr><td><input type="checkbox" name="selected[]" value="<?= esc($key) ?>" class="price-choice" data-target="price-<?= esc($key) ?>"></td>
<th scope="row"><?= esc($label) ?></th>
<td>$<?= isset($prices[$key]) ? number_format((float)$prices[$key], 2) : 'Not found' ?></td>
<td><input type="number" id="price-<?= esc($key) ?>" name="prices[<?= esc($key) ?>]" min="0.01" max="999.99" step="0.01"
placeholder="New price" disabled></td></tr>
<?php endforeach; ?>
</tbody></table>
<div class="actions"><button type="submit" class="coffee-button">Update Prices</button></div>
</form>
<p><small>Only checked products are updated. Refreshing or returning to the Menu will display the saved prices.</small></p>
</div></div>
<footer><em>Copyright &copy; 2026 JavaJam Coffee House</em></footer></div>
<script>
document.querySelectorAll('.price-choice').forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        const input = document.getElementById(this.dataset.target);
        input.disabled = !this.checked;
        input.required = this.checked;
        if (!this.checked) input.value = '';
        if (this.checked) input.focus();
    });
});
</script></body></html>
