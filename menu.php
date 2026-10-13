<?php include 'pricechange\getprice.php'; ?>
<!DOCTYPE html>
<html lang="en">
<div id="wrapper">
<head>
    <title>JavaJam Coffee House - Menu</title>
    <link rel="stylesheet" href="Assets/style.css">
</head>


<body>

    <header></header>



        <div id="leftcolumn">
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="musics.html">Music</a></li>
                    <li><a href="jobs.html">Jobs</a></li>
                </ul>
            </nav>
        </div>

        <div id="rightcolumn">
            <h2>Coffee at JavaJam</h2>
            
            <div class="content">
                <form>
                    <table>
                        <tr>
                            <th>Just Java</th>
                            <td>
                                Regular house blend, decaffeinated coffee, or flavor of the day.<br>
                                <strong>Endless Cup $<?php echo $prices['Just_Java']; ?></strong>
                            </td>
                            <td>
                                Quantity:
                                <input type="text" id="QtyJava" name="QtyJava" size="3">
                            </td>
                            <td>
                                Subtotal:
                                $<input type="text" id="Price_Java" name="Price_Java" size="6" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th>Cafe au Lait</th>
                            <td>
                                House blended coffee infused into a smooth, steamed milk.<br>

                                <input type="radio"
                                    id="Qty_Cafe_Single"
                                    name="CafeShot"
                                    value="<?php echo $prices['Cafe_au_Lait_single']; ?>">
                                Single $<?php echo $prices['Cafe_au_Lait_single']; ?>

                                <input type="radio"
                                    id="Qty_Cafe_Double"
                                    name="CafeShot"
                                    value="<?php echo $prices['Cafe_au_Lait_double']; ?>">
                                Double $<?php echo $prices['Cafe_au_Lait_double']; ?>
                            </td>
                            <td>
                                Quantity:
                                <input type="text" id="QtyCafe" name="QtyCafe" size="3">
                            </td>
                            <td>
                                Subtotal:
                                $<input type="text" id="Price_Cafe" name="Price_Cafe" size="6" readonly>
                            </td>
                        </tr>

                        <tr>
                            <th>Iced Cappuccino</th>
                            <td>
                                Sweetened espresso blended with icy-cold milk and served in a chilled glass.<br>

                                <input type="radio"
                                    id="Qty_Cap_Single"
                                    name="CapShot"
                                    value="<?php echo $prices['Iced_Cappuccino_sing']; ?>">
                                Single $<?php echo $prices['Iced_Cappuccino_sing']; ?>

                                <input type="radio"
                                    id="Qty_Cap_Double"
                                    name="CapShot"
                                    value="<?php echo $prices['Iced_Cappuccino_doub']; ?>">
                                Double $<?php echo $prices['Iced_Cappuccino_doub']; ?>
                            </td>
                            <td>
                                Quantity:
                                <input type="text" id="QtyCap" name="QtyCap" size="3">
                            </td>
                            <td>
                                Subtotal:
                                $<input type="text" id="Price_Cap" name="Price_Cap" size="6" readonly>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="3" style="text-align: right;">
                                <strong>Total Price:</strong>
                            </td>
                            <td>
                                $<input type="text" id="TotalPrice" name="TotalPrice" size="6" readonly>
                            </td>
                        </tr>
                    </table>

                    <br>
                </form>
            </div>
        </div>



    <footer>
        <em>Copyright &copy; 2014 JavaJam Coffee House</em><br>
        <a href="mailto:bryan@ang.com">bryan@ang.com</a>
    </footer>
</div>
<script src="MenuUpdate.js"></script>
</body>
</html>