<?php include 'pricechange\getprice.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>JavaJam Coffee House - Menu Admin</title>
    <link rel="stylesheet" href="Assets/style.css">
</head>
<body>
<div id="wrapper">
    <div id="leftcolumn">
        <nav>
            <ul>
                <li><a href="index.html">Product<br>Price<br>Update</a></li>
                <li><a href="salesreport.php">Sales Report</a></li>
            </ul>
        </nav>
    </div>

    <div id="rightcolumn">
        <h2>Coffee at JavaJam - Price Update</h2>
        <div class="content">
            <form action="pricechange\update.php" method="POST">
                <table>
                    <tr>
                        <th><input type="checkbox" name="items[]" value="Just_Java"> Just Java</th>
                        <td>Endless Cup $<input type="text" name="prices[Just_Java]" value="<?php echo $prices['Just_Java']; ?>" size="6"></td>
                    </tr>
                    <tr>
                        <th><input type="checkbox" name="items[]" value="Cafe_au_Lait"> Cafe au Lait</th>
                        <td>
                            Single $<input type="text" name="prices[Cafe_au_Lait_single]" value="<?php echo $prices['Cafe_au_Lait_single']; ?>" size="6">
                            Double $<input type="text" name="prices[Cafe_au_Lait_double]" value="<?php echo $prices['Cafe_au_Lait_double']; ?>" size="6">
                        </td>
                    </tr>
                    <tr>
                        <th><input type="checkbox" name="items[]" value="Iced_Cappuccino"> Iced Cappuccino</th>
                        <td>
                            Single $<input type="text" name="prices[Iced_Cappuccino_sing]" value="<?php echo $prices['Iced_Cappuccino_sing']; ?>" size="6">
                            Double $<input type="text" name="prices[Iced_Cappuccino_doub]" value="<?php echo $prices['Iced_Cappuccino_doub']; ?>" size="6">
                        </td>
                    </tr>
                </table>
                <br><button type="submit">Update Selected Prices</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>