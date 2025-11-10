<!-- untuk input input dan aksi form update supplier -->
<h3>Edit Supplier</h3>

<form method="POST">
    <input type="hidden" name="action" value="update_supplier">
    <input type="hidden" name="id" value="<?= $supplier_data['id'] ?>">

    <p>
        <label>Nama:</label>
        <input type="text" name="name" value="<?= $supplier_data['name'] ?>" required>
    </p>
    <p>
        <label>Email:</label>
        <input type="text" name="email" value="<?= $supplier_data['email'] ?>" required>
    </p>
    <p>
        <label>No Telp:</label>
        <input type="text" name="phone" value="<?= $supplier_data['phone'] ?>" required>
    </p>

    <button type="submit">Update Supplier</button>
    <a href="?page=suppliers">Batal</a>
</form>