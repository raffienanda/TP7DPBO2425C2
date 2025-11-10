<?php
require_once 'class/Drinks.php';
require_once 'class/Foods.php';

$Drinks = new Drinks();
$Foods = new Foods();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dapur - Admin</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <?php include 'view/HeaderView.php'; ?>

    <main class="content">
        <?php include 'view/DrinksView.php'; ?>
        <?php include 'view/FoodsView.php'; ?>
    </main>

    <?php include 'view/FooterView.php'; ?>
</body>

</html>