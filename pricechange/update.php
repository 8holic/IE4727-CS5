<?php
$conn = new mysqli('localhost', 'root', '', 'price');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['items'])) {
    $map = [
        'Just_Java' => ['Just_Java'],
        'Cafe_au_Lait' => ['Cafe_au_Lait_single', 'Cafe_au_Lait_double'],
        'Iced_Cappuccino' => ['Iced_Cappuccino_sing', 'Iced_Cappuccino_doub']
    ];

    $stmt = $conn->prepare("UPDATE coffeprice SET price = ? WHERE name = ?");

    foreach ($_POST['items'] as $item) {
        if (isset($map[$item])) {
            foreach ($map[$item] as $key) {
                if (isset($_POST['prices'][$key])) {
                    $stmt->bind_param("ds", $_POST['prices'][$key], $key);
                    $stmt->execute();
                }
            }
        }
    }
}

header("Location: ../menuadmin.php");
exit();
?>