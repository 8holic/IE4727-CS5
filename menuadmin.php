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
                        <th>
                            <input type="checkbox" name="items[]" value="Just_Java" id="check_just_java"> 
                            Just Java
                        </th>
                        <td>
                            Endless Cup $<input type="text" name="prices[Just_Java]" id="p1" value="<?php echo $prices['Just_Java']; ?>" size="6" disabled>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <input type="checkbox" name="items[]" value="Cafe_au_Lait" id="check_cafe"> 
                            Cafe au Lait
                        </th>
                        <td>
                            Single $<input type="text" name="prices[Cafe_au_Lait_single]" id="p2" value="<?php echo $prices['Cafe_au_Lait_single']; ?>" size="6" disabled>
                            Double $<input type="text" name="prices[Cafe_au_Lait_double]" id="p3" value="<?php echo $prices['Cafe_au_Lait_double']; ?>" size="6" disabled>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <input type="checkbox" name="items[]" value="Iced_Cappuccino" id="check_iced"> 
                            Iced Cappuccino
                        </th>
                        <td>
                            Single $<input type="text" name="prices[Iced_Cappuccino_sing]" id="p4" value="<?php echo $prices['Iced_Cappuccino_sing']; ?>" size="6" disabled>
                            Double $<input type="text" name="prices[Iced_Cappuccino_doub]" id="p5" value="<?php echo $prices['Iced_Cappuccino_doub']; ?>" size="6" disabled>
                        </td>
                    </tr>
                </table>
                <br><button type="submit">Update Selected Prices</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const originalValues = {
            'p1': document.getElementById('p1').value,
            'p2': document.getElementById('p2').value,
            'p3': document.getElementById('p3').value,
            'p4': document.getElementById('p4').value,
            'p5': document.getElementById('p5').value
        };

        function bindCheckbox(checkboxId, ...inputIds) {
            const checkbox = document.getElementById(checkboxId);
            checkbox.addEventListener('change', function() {
                inputIds.forEach(id => {
                    const input = document.getElementById(id);
                    input.disabled = !this.checked;
                    if (!this.checked) {
                        input.value = originalValues[id];
                    }
                });
            });
        }

        bindCheckbox('check_just_java', 'p1');
        bindCheckbox('check_cafe', 'p2', 'p3');
        bindCheckbox('check_iced', 'p4', 'p5');
    });
</script>
</body>
</html>