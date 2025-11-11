<?php
$action = $_GET['action'] ?? 'read';
$id = $_GET['id'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $food_name = $_POST['food_name'] ?? '';
    $harga = $_POST['harga'] ?? 0;
    $stok = $_POST['stok'] ?? 0;
    $post_action = $_POST['action'] ?? '';
    $food_id = $_POST['id'] ?? null;

    if ($post_action == 'create') {
        if ($Foods->createFoods($food_name, $harga, $stok)) {
            header("Location: index.php?page=foods&status=created");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal menambahkan makanan.</p>";
        }
    } elseif ($post_action == 'update') {
        if ($Foods->updateFoods($food_id, $food_name, $harga, $stok)) {
            header("Location: index.php?page=foods&status=updated");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal memperbarui makanan.</p>";
        }
    }
} elseif ($action == 'delete' && $id) {
    if ($Foods->deleteFoods($id)) {
        header("Location: index.php?page=foods&status=deleted");
        exit();
    } else {
        $message = "<p class='status cancelled'>Gagal menghapus makanan.</p>";
        $action = 'read';
    }
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'created') {
        $message = "<p class='status done'>Makanan berhasil ditambahkan!</p>";
    } elseif ($status == 'updated') {
        $message = "<p class='status done'>Makanan berhasil diperbarui!</p>";
    } elseif ($status == 'deleted') {
        $message = "<p class='status done'>Makanan berhasil dihapus!</p>";
    }
}

echo $message;

if ($action == 'create_form' || $action == 'edit_form') {
    $data = ['id' => '', 'food_name' => '', 'harga' => '', 'stok' => ''];
    $form_title = "Tambah Makanan Baru";
    $form_action = "create";

    if ($action == 'edit_form' && $id) {
        $data = $Foods->getFoodById($id);
        $form_title = "Edit Makanan: " . ($data['food_name'] ?? '');
        $form_action = "update";
        if (!$data) {
            echo "<p class='status cancelled'>Data makanan tidak ditemukan.</p>";
            $action = 'read';
        }
    }
    
    if ($action != 'read') {
    ?>
    <h2><?= $form_title ?></h2>
    <form class="data-form" method="POST" action="index.php?page=foods">
        <input type="hidden" name="action" value="<?= $form_action ?>">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div style="margin-bottom: 10px;">
            <label for="food_name">Nama Makanan:</label>
            <input type="text" id="food_name" name="food_name" value="<?= $data['food_name'] ?>" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?= $data['harga'] ?>" required>
        </div>
        <div style="margin-bottom: 10px;">
            <label for="stok">Stok:</label>
            <input type="number" id="stok" name="stok" value="<?= $data['stok'] ?>" required>
        </div>
        
        <button type="submit" class="btn done"><?= ($form_action == 'create' ? 'Simpan' : 'Perbarui') ?></button>
        <a href="index.php?page=foods" class="btn cancel">Batal</a>
    </form>
    <?php
    }
} 

if ($action == 'read') {
?>
    <h2>Daftar Makanan</h2>
    <a href="index.php?page=foods&action=create_form" class="btn done" style="margin-bottom: 15px; display: inline-block;">+ Tambah Makanan</a>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Makanan</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($Foods->getAllFoods() as $b): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b['food_name'] ?></td>
                    <td><?= $b['harga'] ?></td>
                    <td><?= $b['stok'] ?></td>
                    <td>
                        <a href="index.php?page=foods&action=edit_form&id=<?= $b['id'] ?>" class="btn done">Edit</a>
                        <a href="index.php?page=foods&action=delete&id=<?= $b['id'] ?>" class="btn cancel" onclick="return confirm('Yakin ingin menghapus <?= $b['food_name'] ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>