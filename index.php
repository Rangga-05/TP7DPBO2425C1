<?php
//hubungkan ke file konfigurasi dan class utama
require_once 'config/db.php';
require_once 'class/Product.php';
require_once 'class/Supplier.php';
require_once 'class/Order.php';

//buat koneksi ke database
$database = new Database();
$db = $database->connect();

//buat instance untuk setiap class
$product = new Product($db);
$supplier = new Supplier($db);
$order = new Order($db);

//jika ada permintaan untuk buat pesanan baru
if (isset($_POST['create_order'])) {
    $order->createOrder($_POST['product_id'], $_POST['quantity']);
}
//jika ada permintaan untuk batalkan pesanan
if (isset($_GET['cancel'])) {
    $order->cancelOrder($_GET['cancel']);
}

//menangani aksi yang dikirim melalui method post
if (isset($_POST['action'])) {
    
    //aksi untuk buat produk baru
    if ($_POST['action'] == 'create_product') {
        $product->createProduct(
            $_POST['name'], 
            $_POST['code'], 
            $_POST['supplier_id'], 
            $_POST['price'], 
            $_POST['stock']
        );
        header("Location: ?page=products");
        exit;
    }
    
    //aksi untuk update data produk
    if ($_POST['action'] == 'update_product') {
        $product->updateProduct(
            $_POST['id'],
            $_POST['name'], 
            $_POST['code'], 
            $_POST['supplier_id'], 
            $_POST['price'], 
            $_POST['stock']
        );
        header("Location: ?page=products");
        exit;
    }

    //aksi untuk buat supplier baru
    if ($_POST['action'] == 'create_supplier') {
        $supplier->createSupplier(
            $_POST['name'], 
            $_POST['email'], 
            $_POST['phone']
        );
        header("Location: ?page=suppliers");
        exit;
    }

    //aksi untuk update data supplier
    if ($_POST['action'] == 'update_supplier') {
        $supplier->updateSupplier(
            $_POST['id'],
            $_POST['name'], 
            $_POST['email'], 
            $_POST['phone']
        );
        header("Location: ?page=suppliers");
        exit;
    }
}

//menangani aksi yang dikirim melalui method post
if (isset($_GET['action'])) {
    //hapus produk berdasarkan id
    if ($_GET['action'] == 'delete' && isset($_GET['page']) && $_GET['page'] == 'products' && isset($_GET['id'])) {
        $product->deleteProduct($_GET['id']);
        header("Location: ?page=products");
        exit;
    }
    //hapus supplier berdasarkan id
    if ($_GET['action'] == 'delete' && isset($_GET['page']) && $_GET['page'] == 'suppliers' && isset($_GET['id'])) {
        $supplier->deleteSupplier($_GET['id']);
        header("Location: ?page=suppliers");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sistem Daftar Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- header utama -->
    <?php include 'view/header.php'; ?>
    <main>
        <!-- menu navigasi -->
        <h2>Menu</h2>
        <nav>
            <a href="?page=products">Produk</a> | <a href="?page=suppliers">Suppliers</a> | <a href="?page=orders">Pesanan</a>
        </nav>

        <?php
        //menentukan halaman dan aksi yang sedang diakses 
        $page = $_GET['page'] ?? 'home'; 
        $action = $_GET['action'] ?? 'view'; 

        //jika halaman produk diakses
        if ($page == 'products') {
            if ($action == 'edit' && isset($_GET['id'])) {
                $product_data = $product->getProductById($_GET['id']);
                include 'view/productEdit.php';
            } else {
                include 'view/products.php';
            }
        } 
        //jika halaman supplier diakses
        elseif ($page == 'suppliers') {
            if ($action == 'edit' && isset($_GET['id'])) {
                $supplier_data = $supplier->getSupplierById($_GET['id']);
                include 'view/supplierEdit.php';
            } else {
                include 'view/suppliers.php';
            }
        }
        //jika halaman pesanan diakses
        elseif ($page == 'orders') {
            if ($action == 'edit' && isset($_GET['id'])) {
                $order_data = $order->getOrderById($_GET['id']);
                include 'view/orderEdit.php';
            } else {
                include 'view/orders.php';
            }
        } 
        //halaman default ketika tidak ada parameter page
        else {
            echo "<p>Selamat Datang Di Menu Utama</p>";
        }
        ?>
    </main>
    <!-- buat footer -->
    <?php include 'view/footer.php'; ?>
</body>
</html>