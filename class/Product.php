<?php
require_once 'config/db.php'; //ambil file koneksi database

class Product {
    private $db; //simpan koneksi database

    public function __construct($db_conn) {
        $this->db = $db_conn; //atur koneksi database saat class diinisialisasi
    }

    public function getAllProducts() {
        //ambil semua data produk dan juga nama supplier 
        $stmt = $this->db->prepare("SELECT p.*, s.name AS supplier_name 
                                    FROM products p 
                                    JOIN suppliers s ON p.supplier_id = s.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //kembalikan semua hasil query
    }
    
    public function getProductById($id) {
        //ambil data produk berdasarkan id
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); //kembalikan satu baris data
    }

    public function createProduct($name, $code, $supplier_id, $price, $stock) {
        //tambahkan produk baru ke tabel product
        $stmt = $this->db->prepare("INSERT INTO products (name, code, supplier_id, price, stock) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $code, $supplier_id, $price, $stock]); //jalankan query dengan data produk baru
    }

    public function updateProduct($id, $name, $code, $supplier_id, $price, $stock) {
        //ubah data produk berdasarkan id
        $stmt = $this->db->prepare("UPDATE products SET name = ?, code = ?, supplier_id = ?, price = ?, stock = ? WHERE id = ?");
        return $stmt->execute([$name, $code, $supplier_id, $price, $stock, $id]);
    }

    public function updateStock($id, $stock) {
        //update stok produk berdasarkan id
        $stmt = $this->db->prepare("UPDATE products SET stock = ? WHERE id = ?");
        return $stmt->execute([$stock, $id]);
    }

    public function deleteProduct($id) {
        //hapus produk berdasarkan id
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>