<?php
// ambil data order berdasarkan id
$id = $_GET['id'];
$order_data = $order->getOrderById($id);
?>

<h2>Edit Pesanan</h2>

<form method="POST">
    <p>
        <label>Produk ID:</label>
        <input type="number" name="product_id" value="<?= $order_data['product_id'] ?>" required>
    </p>
    <p>
        <label>Kuantitas:</label>
        <input type="number" name="quantity" value="<?= $order_data['quantity'] ?>" required>
    </p>

    <button type="submit" name="update_order">Update Pesanan</button>
    <a href="?page=orders">Batal</a>
</form>

<?php
if (isset($_POST['update_order'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if ($order->updateOrder($id, $product_id, $quantity)) {
        echo "<script>alert('Pesanan berhasil diperbarui!'); window.location='?page=orders';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui pesanan! Cek stok produk.');</script>";
    }
}
?>