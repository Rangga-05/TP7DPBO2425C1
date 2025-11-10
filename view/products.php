<?php
//ambil semua data supplier dari database lewat class supplier
$suppliers_list = $supplier->getAllSuppliers();
?>

<br>
<hr> <br>

<h2>List Produk</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Kode</th>
        <th>Supplier</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
    <?php
    //loop untuk tampilin semua produk
    foreach ($product->getAllProducts() as $p): 
    ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= $p['name'] ?></td>
        <td><?= $p['code'] ?></td>
        <td><?= $p['supplier_name'] ?></td> <td><?= number_format($p['price'], 0, ',', '.') ?></td>
        <td><?= $p['stock'] ?></td>
        <td>
            <a href="?page=products&action=edit&id=<?= $p['id'] ?>">Edit</a> | 
            <a href="?page=products&action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Are you sure you want to delete this product?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br>
<hr> <br>

<!-- untuk input input dan aksi form tambah produk -->
<h2>Tambah Produk Baru</h2>
<form method="POST">
    <input type="hidden" name="action" value="create_product">
    
    <p>
        <label>Nama:</label>
        <input type="text" name="name" required>
    </p>
    <p>
        <label>Kode:</label>
        <input type="text" name="code" required>
    </p>
    <p>
        <label>Supplier:</label>
        <select name="supplier_id" required>
            <?php foreach ($suppliers_list as $s): ?>
                <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label>Harga:</label>
        <input type="number" name="price" required>
    </p>
    <p>
        <label>Stok:</label>
        <input type="number" name="stock" required>
    </p>
    
    <button type="submit">Tambahkan Produk</button>
</form>