<?php
// XAMPP defaults. Adjust these only if your MySQL settings are different.
function db_connect(): mysqli
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = new mysqli('localhost', 'root', '', 'price', 3306);
    $db->set_charset('utf8mb4');
    return $db;
}
