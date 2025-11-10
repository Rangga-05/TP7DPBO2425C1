<br>
<hr> <br>

<h2>List Supplier</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>No Telp</th>
        <th>Aksi</th>
    </tr>
    <!-- menampilkan semua data pesanan dari database -->
    <?php foreach ($supplier->getAllSuppliers() as $s): ?>
    <tr>
        <td><?= $s['id'] ?></td>
        <td><?= $s['name'] ?></td>
        <td><?= $s['email'] ?></td>
        <td><?= $s['phone'] ?></td>
        <td>
            <a href="?page=suppliers&action=edit&id=<?= $s['id'] ?>">Edit</a> | 
            <a href="?page=suppliers&action=delete&id=<?= $s['id'] ?>" onclick="return confirm('Are you sure you want to delete this supplier?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<br>
<hr> <br>

<!-- untuk input input dan aksi form tambah supplier baru -->
<h2>Tambah Supplier Baru</h2>
<form method="POST">
    <input type="hidden" name="action" value="create_supplier">

    <p>
        <label>Nama:</label>
        <input type="text" name="name" required>
    </p>
    <p>
        <label>Email:</label>
        <input type="email" name="email" required>
    </p>
    <p>
        <label>No Telp:</label>
        <input type="text" name="phone">
    </p>
    
    <button type="submit">Tambahkan Supplier</button>
</form>