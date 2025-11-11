<?php
require_once 'class/Drinks.php';
require_once 'class/Foods.php';
require_once 'class/Tables.php';
require_once 'class/Members.php';
require_once 'class/Orders.php'; 

$Drinks = new Drinks();
$Foods = new Foods();
$Tables = new Tables();
$Members = new Members();
$Orders = new Orders();

$page = $_GET['page'] ?? 'dashboard';
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
        <?php
        switch ($page) {
            case 'foods':
                include 'view/FoodsManagement.php'; 
                break;
            case 'drinks':
                include 'view/DrinksManagement.php'; 
                break;
            case 'tables':
                include 'view/TablesManagement.php'; 
                break;
            case 'members':
                include 'view/MembersManagement.php'; 
                break;
            case 'orders':
                include 'view/OrdersManagement.php'; 
                break;
            case 'dashboard':
            default:
                include 'view/FoodsView.php'; 
                include 'view/DrinksView.php'; 
                break;
        }
        ?>
    </main>

    <?php include 'view/FooterView.php'; ?>
</body>

</html>