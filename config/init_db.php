<?php
require_once __DIR__ . '/db.php';
$pdo = get_db();
$productsCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$imagesCount = $pdo->query("SELECT COUNT(*) FROM product_images")->fetchColumn();
$categoriesCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();

echo "SUCCESS:\n";
echo "Categories Seeded: $categoriesCount\n";
echo "Products Seeded: $productsCount\n";
echo "Images Seeded: $imagesCount\n";
