<?php
$action = $_GET['action'] ?? 'read';
$id = $_GET['id'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $table_name = $_POST['table_name'] ?? '';
    $post_action = $_POST['action'] ?? '';
    $table_id = $_POST['id'] ?? null;

    if ($post_action == 'create') {
        if ($Tables->createTable($table_name)) {
            header("Location: index.php?page=tables&status=created");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal menambahkan meja.</p>";
        }
    } elseif ($post_action == 'update') {
        if ($Tables->updateTable($table_id, $table_name)) {
            header("Location: index.php?page=tables&status=updated");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal memperbarui meja.</p>";
        }
    }
} elseif ($action == 'delete' && $id) {
    if ($Tables->deleteTable($id)) {
        header("Location: index.php?page=tables&status=deleted");
        exit();
    } else {
        $message = "<p class='status cancelled'>Gagal menghapus meja.</p>";
        $action = 'read';
    }
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'created') {
        $message = "<p class='status done'>Meja berhasil ditambahkan!</p>";
    } elseif ($status == 'updated') {
        $message = "<p class='status done'>Meja berhasil diperbarui!</p>";
    } elseif ($status == 'deleted') {
        $message = "<p class='status done'>Meja berhasil dihapus!</p>";
    }
}

echo $message;

if ($action == 'create_form' || $action == 'edit_form') {
    $data = ['id' => '', 'table_name' => ''];
    $form_title = "Tambah Meja Baru";
    $form_action = "create";

    if ($action == 'edit_form' && $id) {
        $data = $Tables->getTableById($id);
        $form_title = "Edit Meja: " . ($data['table_name'] ?? '');
        $form_action = "update";
        if (!$data) {
            echo "<p class='status cancelled'>Data meja tidak ditemukan.</p>";
            $action = 'read';
        }
    }
    
    if ($action != 'read') {
    ?>
    <h2><?= $form_title ?></h2>
    <form class="data-form" method="POST" action="index.php?page=tables">
        <input type="hidden" name="action" value="<?= $form_action ?>">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div style="margin-bottom: 10px;">
            <label for="table_name">Nama Meja (Ex: Reg001, VIP002):</label>
            <input type="text" id="table_name" name="table_name" value="<?= $data['table_name'] ?>" required>
        </div>
        
        <button type="submit" class="btn done"><?= ($form_action == 'create' ? 'Simpan' : 'Perbarui') ?></button>
        <a href="index.php?page=tables" class="btn cancel">Batal</a>
    </form>
    <?php
    }
} 

if ($action == 'read') {
?>
    <h2>Daftar Meja</h2>
    <a href="index.php?page=tables&action=create_form" class="btn done" style="margin-bottom: 15px; display: inline-block;">+ Tambah Meja</a>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Meja</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($Tables->getAllTables() as $b): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b['table_name'] ?></td>
                    <td>
                        <a href="index.php?page=tables&action=edit_form&id=<?= $b['id'] ?>" class="btn done">Edit</a>
                        <a href="index.php?page=tables&action=delete&id=<?= $b['id'] ?>" class="btn cancel" onclick="return confirm('Yakin ingin menghapus <?= $b['table_name'] ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>