<?php
$action = $_GET['action'] ?? 'read';
$id = $_GET['id'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_name = $_POST['member_name'] ?? '';
    $post_action = $_POST['action'] ?? '';
    $member_id = $_POST['id'] ?? null;

    if ($post_action == 'create') {
        if ($Members->createMember($member_name)) {
            header("Location: index.php?page=members&status=created");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal menambahkan member.</p>";
        }
    } elseif ($post_action == 'update') {
        if ($Members->updateMember($member_id, $member_name)) {
            header("Location: index.php?page=members&status=updated");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal memperbarui member.</p>";
        }
    }
} elseif ($action == 'delete' && $id) {
    if ($Members->deleteMember($id)) {
        header("Location: index.php?page=members&status=deleted");
        exit();
    } else {
        $message = "<p class='status cancelled'>Gagal menghapus member.</p>";
        $action = 'read';
    }
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'created') {
        $message = "<p class='status done'>Member berhasil ditambahkan!</p>";
    } elseif ($status == 'updated') {
        $message = "<p class='status done'>Member berhasil diperbarui!</p>";
    } elseif ($status == 'deleted') {
        $message = "<p class='status done'>Member berhasil dihapus!</p>";
    }
}

echo $message;

if ($action == 'create_form' || $action == 'edit_form') {
    $data = ['id' => '', 'member_name' => ''];
    $form_title = "Tambah Member Baru";
    $form_action = "create";

    if ($action == 'edit_form' && $id) {
        $data = $Members->getMemberById($id);
        $form_title = "Edit Member: " . ($data['member_name'] ?? '');
        $form_action = "update";
        if (!$data) {
            echo "<p class='status cancelled'>Data member tidak ditemukan.</p>";
            $action = 'read';
        }
    }
    
    if ($action != 'read') {
    ?>
    <h2><?= $form_title ?></h2>
    <form class="data-form" method="POST" action="index.php?page=members">
        <input type="hidden" name="action" value="<?= $form_action ?>">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <div style="margin-bottom: 10px;">
            <label for="member_name">Nama Member:</label>
            <input type="text" id="member_name" name="member_name" value="<?= $data['member_name'] ?>" required>
        </div>
        
        <button type="submit" class="btn done"><?= ($form_action == 'create' ? 'Simpan' : 'Perbarui') ?></button>
        <a href="index.php?page=members" class="btn cancel">Batal</a>
    </form>
    <?php
    }
} 

if ($action == 'read') {
?>
    <h2>Daftar Member</h2>
    <a href="index.php?page=members&action=create_form" class="btn done" style="margin-bottom: 15px; display: inline-block;">+ Tambah Member</a>
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Member</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($Members->getAllMembers() as $b): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $b['member_name'] ?></td>
                    <td>
                        <a href="index.php?page=members&action=edit_form&id=<?= $b['id'] ?>" class="btn done">Edit</a>
                        <a href="index.php?page=members&action=delete&id=<?= $b['id'] ?>" class="btn cancel" onclick="return confirm('Yakin ingin menghapus <?= $b['member_name'] ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php
}
?>