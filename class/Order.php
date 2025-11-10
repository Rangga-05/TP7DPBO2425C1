<?php
require_once 'config/db.php'; //ambil file koneksi database
require_once 'Product.php'; //ambil class product untuk akses fungsi produk

class Order {
    private $db; //simpan koneksi database

    public function __construct($db_conn) {
        $this->db = $db_conn; //atur koneksi database saat class order dibuat
    }

    public function getAllOrders() {
        //ambil semua data pesanan dan nama produk yang dipesan
        $stmt = $this->db->prepare("SELECT o.*, p.name 
                                     FROM orders o
                                     JOIN products p ON o.product_id = p.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //kembalikan hasil query
    }

    public function getOrderById($id) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($product_id, $quantity) {
        //buat pesanan baru dan kurangi stok produk
        $stmt = $this->db->prepare("INSERT INTO orders (product_id, quantity, order_date) VALUES (?, ?, CURDATE())");
        
        //ambil stok produk yang dipilih
        $product = new Product($this->db);
        $stmt_product = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt_product->execute([$product_id]);
        $productData = $stmt_product->fetch();

        //cek stok cukup tidak untuk buat pesanan
        if ($productData['stock'] >= $quantity) {
            //kurangi stok sesuai sesuai jumlah pesanan
            $product->updateStock($product_id, $productData['stock'] - $quantity);
            return $stmt->execute([$product_id, $quantity]); //jalankan query untuk simpan pesanan
        }
        return false; //stok tidak cukup kembalikan false
    }

    public function cancelOrder($order_id) {
        //batalkan pesanan dan kembalikan stok produk
        $stmt = $this->db->prepare("DELETE FROM orders WHERE id = ?");

        //ambil data pesanan yang mau dibatalkan
        $stmt_get_order = $this->db->prepare("SELECT product_id, quantity FROM orders WHERE id = ?");
        $stmt_get_order->execute([$order_id]);
        $order = $stmt_get_order->fetch();

        if (!$order) {
            return false; //jika pesanan tidak ketemu, batalkan proses
        }

        $product_id = $order['product_id'];
        $quantity = $order['quantity'];

        //ambil stok produk saat ini
        $product = new Product($this->db);
        $stmt_get_productData = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt_get_productData->execute([$product_id]);
        $productData = $stmt_get_productData->fetch();

        //tambah kembali stok sesuai jumlah pesanan yang dibatalin
        $product->updateStock($product_id, $productData['stock'] + $quantity);

        //hapus data pesanan dari tabel order
        return $stmt->execute([$order_id]);
    }

    public function updateOrder($id, $product_id, $quantity) {
        //ambil data order lama
        $stmt_get = $this->db->prepare("SELECT quantity, product_id FROM orders WHERE id = ?");
        $stmt_get->execute([$id]);
        $oldOrder = $stmt_get->fetch();
        
        if (!$oldOrder) {
            return false;
        }
    
        $oldProduct = new Product($this->db);
    
        //ambil stok produk lama
        $stmt_stock = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt_stock->execute([$oldOrder['product_id']]);
        $oldStockData = $stmt_stock->fetch();
        if (!$oldStockData) return false;
        $oldStock = $oldStockData['stock'];
    
        //kembalikan stok lama
        $oldProduct->updateStock($oldOrder['product_id'], $oldStock + $oldOrder['quantity']);
    
        //ambil stok produk baru (setelah pengembalian stok)
        $stmt_stock_new = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt_stock_new->execute([$product_id]);
        $newStockData = $stmt_stock_new->fetch();
        if (!$newStockData) return false;
    
        $newStock = $newStockData['stock'];
    
        //cek stok cukup atau tidak
        if ($newStock < $quantity) {
            return false;
        }
    
        //update order
        $stmt_update = $this->db->prepare("UPDATE orders SET product_id=?, quantity=? WHERE id=?");
        $stmt_update->execute([$product_id, $quantity, $id]);
    
        //kurangi stok produk baru
        $oldProduct->updateStock($product_id, $newStock - $quantity);
    
        return true;
    }
}
?>