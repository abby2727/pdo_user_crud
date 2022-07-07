<?php
    $conn = "mysql:host=localhost;dbname=pdo_user_crud";

    try {
        $pdo = new PDO($conn, 'root', '');
    } catch(PDOException $e) {
        echo $e->getMessage();
    }
?>