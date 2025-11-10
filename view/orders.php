<?php
//ambil semua data produk untuk ditampilkan di dropdown form pesanan baru
$products_list = $product->getAllProducts();
?>

<br>
<hr> <br>

<h2>List Pesanan</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Kuantitas</th>
        <th>Tanggal Order</th>
        <th>Aksi</th>
    </tr>
    <?php
    //menampilkan semua data pesanan dari database
    foreach ($order->getAllOrders() as $o): 
    ?>
    <tr>
        <td><?= $o['id'] ?></td>
        <td><?= $o['name'] ?></td> <td><?= $o['quantity'] ?></td>
        <td><?= $o['order_date'] ?></td>
        <td>
            <a href="?page=orders&action=edit&id=<?= $o['id'] ?>">Edit</a> | 
            <a href="?page=orders&cancel=<?= $o['id'] ?>" 
               onclick="return confirm('Yakin ingin membatalkan pesanan ini? Stok produk akan dikembalikan.')">
               Cancel
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br>
<hr> <br>

<!-- untuk input input dan aksi form buat pesanan baru -->
<h2>Buat Pesanan Baru</h2>
<form method="POST">
    <input type="hidden" name="create_order" value="1"> 
    
    <p>
        <label>Produk:</label>
        <select name="product_id" required>
            <?php foreach ($products_list as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['name'] ?> (Stock: <?= $p['stock'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    <p>
        <label>Kuantitas:</label>
        <input type="number" name="quantity" required min="1">
    </p>
    
    <button type="submit">Ajukan Pesanan</button>
</form>