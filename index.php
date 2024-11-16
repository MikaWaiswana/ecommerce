<?php
require_once(__DIR__ . '/Config/init.php');

// Menyiapkan ProductController untuk mengambil data produk
$productController = new ProductController();
$products = $productController->index(); // Mengambil semua produk

// Handle restore produk yang telah dihapus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["restoreProductId"])) {
    $productController->restore($_POST["restoreProductId"]);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Sertakan CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Sertakan custom CSS untuk tampilan -->
    <style>
        .table th, .table td {
            vertical-align: middle;
        }
        
        .table thead {
            background-color: #f8f9fa;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
        }

        .table-container {
            margin-top: 30px;
        }

        .action-buttons a, .action-buttons form {
            margin-right: 5px;
        }

        .action-buttons form {
            display: inline;
        }

        .table-container h2 {
            margin-top: 40px;
        }

        .btn-primary {
            margin-left: 10px;
        }
        
        th {
            text-align: center;
        }

        .tdid {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Product List</h1>
        
        <!-- Tombol untuk menambahkan produk baru -->
        <div class="d-flex justify-content-between mb-3">
            <a href="allcategory.php" class="btn btn-primary">All Categories</a>
            <a href="View/product/create.php" class="btn btn-success">Add New Product</a>
        </div>
        
        <?php if (!empty($products)): ?>
            <div class="table-container">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="col-1">ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th> <!-- Menambahkan kolom Stock -->
                            <th class="col-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="tdid"><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['price']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td> <!-- Menampilkan stok produk -->
                                <td class="action-buttons">
                                    <div class="btn-group">
                                        <a href="View/product/detail.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Detail</a>
                                        <a href="View/product/update.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="View/product/delete.php?id=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm">Delete</a>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>

        
        <!-- Form to restore a deleted product -->
        <form method="POST">
            <input type="hidden" name="restoreProductId" value="<?php echo $product['id']; ?>">
            <button type="submit" class="btn btn-secondary">Restore</button>
        </form>
    </div>
</body>

</html>
