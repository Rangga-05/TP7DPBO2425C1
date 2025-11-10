<?php
//ambil semua data supplier dari database buat dropdown pilihan supplier
$suppliers_list = $supplier->getAllSuppliers(); 
?>

<!-- untuk input input dan aksi form update produk -->
<h3>Edit Produk</h3>

<form method="POST">
    <input type="hidden" name="action" value="update_product">
    <input type="hidden" name="id" value="<?= $product_data['id'] ?>">

    <p>
        <label>Nama:</label>
        <input type="text" name="name" value="<?= $product_data['name'] ?>" required>
    </p>
    <p>
        <label>Kode:</label>
        <input type="text" name="code" value="<?= $product_data['code'] ?>" required>
    </p>
    <p>
        <label>Supplier:</label>
        <select name="supplier_id" required>
            <?php foreach ($suppliers_list as $s): ?>
                <option value="<?= $s['id'] ?>" 
                    <?= ($s['id'] == $product_data['supplier_id']) ? 'selected' : '' ?>>
                    <?= $s['name'] ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label>Harga:</label>
        <input type="number" name="price" value="<?= $product_data['price'] ?>" required>
    </p>
    <p>
        <label>Stok:</label>
        <input type="number" name="stock" value="<?= $product_data['stock'] ?>" required>
    </p>

    <button type="submit">Update Produk</button>
    <a href="?page=products">Batal</a>
</form>