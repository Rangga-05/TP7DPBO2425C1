<?php
require_once 'config/db.php'; //ambil file koneksi database

class Supplier {
    private $db; //simpan koneksi database

    public function __construct($db_conn) {
        $this->db = $db_conn; //atur koneksi database saat class supplier dibuat
    }

    public function getAllSuppliers() {
        //ambil semua data supplier dari tabel supplier
        $stmt = $this->db->prepare("SELECT * FROM suppliers");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); //kembalikan hasil query
    }

    public function getSupplierById($id) {
        //ambil data supplier berdasarkan id
        $stmt = $this->db->prepare("SELECT * FROM suppliers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); //kembalikan satu baris data supplier
    }

    public function createSupplier($name, $email, $phone) {
        //tambahkan data supplier baru ke database
        $stmt = $this->db->prepare("INSERT INTO suppliers (name, email, phone) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $email, $phone]); //jalankan query insert
    }

    public function updateSupplier($id, $name, $email, $phone) {
        //ubah data supplier berdasarkan id
        $stmt = $this->db->prepare("UPDATE suppliers SET name = ?, email = ?, phone = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $phone, $id]); //jalankan query update
    }

    public function deleteSupplier($id) {
        //hapus data supplier berdasarkan id
        $stmt = $this->db->prepare("DELETE FROM suppliers WHERE id = ?");
        return $stmt->execute([$id]); //jalankan query delete
    }
}
?>