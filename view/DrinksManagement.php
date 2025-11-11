<?php
$action = $_GET['action'] ?? 'read';
$id = $_GET['id'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $drink_name = $_POST['drink_name'] ?? '';
    $harga = $_POST['harga'] ?? 0;
    $stok = $_POST['stok'] ?? 0;
    $post_action = $_POST['action'] ?? '';
    $drink_id = $_POST['id'] ?? null;

    if ($post_action == 'create') {
        if ($Drinks->createDrinks($drink_name, $harga, $stok)) {
            header("Location: index.php?page=drinks&status=created");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal menambahkan minuman.</p>";
        }
    } elseif ($post_action == 'update') {
        if ($Drinks->updateDrinks($drink_id, $drink_name, $harga, $stok)) {
            header("Location: index.php?page=drinks&status=updated");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal memperbarui minuman.</p>";
        }
    }
} elseif ($action == 'delete' && $id) {
    if ($Drinks->deleteDrinks($id)) {
        header("Location: index.php?page=drinks&status=deleted");
        exit();
    } else {
        $message = "<p class='status cancelled'>Gagal menghapus minuman.</p>";
        $action = 'read';
    }
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'created') {
        $message = "<p class='status done'>Minuman berhasil ditambahkan!</p>";
    } elseif ($status == 'updated') {
        $message = "<p class='status done'>Minuman berhasil diperbarui!</p>";
    } elseif ($status == 'deleted') {
        $message = "<p class='status done'>Minuman berhasil dihapus!</p>";
    }
}

echo $message;

if ($action == 'create_form' || $action == 'edit_form') {
    $data = ['id' => '', 'drink_name' => '', 'harga' => '', 'stok' => ''];
    $form_title = "Tambah Minuman Baru";
    $form_action = "create";

    if ($action == 'edit_form' && $id) {
        $data = $Drinks->getDrinkById($id);
        $form_title = "Edit Minuman: " . ($data['drink_name'] ?? '');
        $form_action = "update";
        if (!$data) {
            echo "<p class='status cancelled'>Data minuman tidak ditemukan.</p>";
            $action = 'read';
        }
    }
    
    if ($action != 'read') {
    ?>
    <h2><?= $form_title ?></h2>
    <form class="data-form" method="POST" action="index.php?page=drinks">
        <input type="hidden" name="action" value="<?= $form_action ?>">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div style="margin-bottom: 10px;">
            <label for="drink_name">Nama Minuman:</label>
            <input type="text" id="drink_name" name="drink_name" value="<?= $data['drink_name'] ?>" required>
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
        <a href="index.php?page=drinks" class="btn cancel">Batal</a>
    </form>
    <?php
    }
} 

if ($action == 'read') {
?>
    <h2>Daftar Minuman</h2>
    <a href="index.php?page=drinks&action=create_form" class="btn done" style="margin-bottom: 15px; display: inline-block;">+ Tambah Minuman</a>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Minuman</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($Drinks->getAllDrinks() as $b): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b['drink_name'] ?></td>
                    <td><?= $b['harga'] ?></td>
                    <td><?= $b['stok'] ?></td>
                    <td>
                        <a href="index.php?page=drinks&action=edit_form&id=<?= $b['id'] ?>" class="btn done">Edit</a>
                        <a href="index.php?page=drinks&action=delete&id=<?= $b['id'] ?>" class="btn cancel" onclick="return confirm('Yakin ingin menghapus <?= $b['drink_name'] ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>