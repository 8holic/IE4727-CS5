<?php
require __DIR__ . '/pricechange/getprice.php';
function dollars(float $n): string { return number_format($n, 2, '.', ''); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JavaJam Coffee House - Menu</title>
    <link rel="stylesheet" href="Assets/style.css">
</head>
<body>
<div id="wrapper">
    <header></header>
    <div id="leftcolumn">
        <nav><ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="menu.php">Menu</a></li>
            <li><a href="musics.html">Music</a></li>
            <li><a href="jobs.html">Jobs</a></li>
        </ul></nav>
    </div>
    <div id="rightcolumn">
        <h2>Coffee at JavaJam</h2>
        <div class="content">
            <p>Select your drinks and quantities, then check out.</p>
            <form id="orderForm" method="post" action="checkout.php">
                <table class="order-table">
                    <thead><tr><th>Product</th><th>Description / Selection</th><th>Quantity</th><th>Subtotal</th></tr></thead>
                    <tbody>
                    <tr>
                        <th scope="row">Just Java</th>
                        <td>Regular house blend, decaffeinated coffee, or flavor of the day.<br>
                            <strong>Endless Cup $<?= dollars($prices['Just_Java']) ?></strong></td>
                        <td><label for="QtyJava">Quantity</label>
                            <input type="number" id="QtyJava" name="QtyJava" min="0" max="999" step="1" value="0"
                                   data-price="<?= dollars($prices['Just_Java']) ?>"></td>
                        <td>$<input type="text" id="Price_Java" aria-label="Just Java subtotal" readonly value="0.00"></td>
                    </tr>
                    <tr>
                        <th scope="row">Cafe au Lait</th>
                        <td>House blended coffee infused into a smooth, steamed milk.<br>
                            <label class="option"><input type="radio" id="Qty_Cafe_Single" name="CafeShot" value="single"
                                data-price="<?= dollars($prices['Cafe_au_Lait_single']) ?>"> Single $<?= dollars($prices['Cafe_au_Lait_single']) ?></label>
                            <label class="option"><input type="radio" id="Qty_Cafe_Double" name="CafeShot" value="double"
                                data-price="<?= dollars($prices['Cafe_au_Lait_double']) ?>"> Double $<?= dollars($prices['Cafe_au_Lait_double']) ?></label>
                        </td>
                        <td><label for="QtyCafe">Quantity</label>
                            <input type="number" id="QtyCafe" name="QtyCafe" min="0" max="999" step="1" value="0"></td>
                        <td>$<input type="text" id="Price_Cafe" aria-label="Cafe au Lait subtotal" readonly value="0.00"></td>
                    </tr>
                    <tr>
                        <th scope="row">Iced Cappuccino</th>
                        <td>Sweetened espresso blended with icy-cold milk and served in a chilled glass.<br>
                            <label class="option"><input type="radio" id="Qty_Cap_Single" name="CapShot" value="single"
                                data-price="<?= dollars($prices['Iced_Cappuccino_sing']) ?>"> Single $<?= dollars($prices['Iced_Cappuccino_sing']) ?></label>
                            <label class="option"><input type="radio" id="Qty_Cap_Double" name="CapShot" value="double"
                                data-price="<?= dollars($prices['Iced_Cappuccino_doub']) ?>"> Double $<?= dollars($prices['Iced_Cappuccino_doub']) ?></label>
                        </td>
                        <td><label for="QtyCap">Quantity</label>
                            <input type="number" id="QtyCap" name="QtyCap" min="0" max="999" step="1" value="0"></td>
                        <td>$<input type="text" id="Price_Cap" aria-label="Iced Cappuccino subtotal" readonly value="0.00"></td>
                    </tr>
                    </tbody>
                    <tfoot><tr><th colspan="3" class="total-label">Total Price</th>
                        <td>$<input type="text" id="TotalPrice" aria-label="Order total" readonly value="0.00"></td></tr></tfoot>
                </table>
                <div class="actions"><button type="submit" class="coffee-button">Check-Out</button></div>
            </form>
        </div>
    </div>
    <footer><em>Copyright &copy; 2026 JavaJam Coffee House</em><br>
        <a href="menuadmin.php">Admin: Update Prices</a> · <a href="salesreport.php">Daily Sales Report</a></footer>
</div>
<script src="MenuUpdate.js"></script>
</body>
</html>
