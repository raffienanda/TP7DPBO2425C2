<?php
$action = $_GET['action'] ?? 'read';
$id = $_GET['id'] ?? null;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_action = $_POST['action'] ?? '';
    $order_id = $_POST['id'] ?? null;
    $food_id = $_POST['food_id'] ?? null;
    $drink_id = $_POST['drink_id'] ?? null;
    $table_id = $_POST['table_id'] ?? null;
    $member_id = $_POST['member_id'] ?? null;

    if ($post_action == 'create') {
        if ($Orders->createOrder($food_id, $drink_id, $table_id, $member_id)) {
            header("Location: index.php?page=orders&status=created");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal menambahkan pesanan.</p>";
        }
    } elseif ($post_action == 'update') {
        if ($Orders->updateOrder($order_id, $food_id, $drink_id, $table_id, $member_id)) {
            header("Location: index.php?page=orders&status=updated");
            exit();
        } else {
            $message = "<p class='status cancelled'>Gagal memperbarui pesanan.</p>";
        }
    }
} elseif ($action == 'delete' && $id) {
    if ($Orders->deleteOrder($id)) {
        header("Location: index.php?page=orders&status=deleted");
        exit();
    } else {
        $message = "<p class='status cancelled'>Gagal menghapus pesanan.</p>";
        $action = 'read';
    }
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
    if ($status == 'created') {
        $message = "<p class='status done'>Pesanan berhasil ditambahkan!</p>";
    } elseif ($status == 'updated') {
        $message = "<p class='status done'>Pesanan berhasil diperbarui!</p>";
    } elseif ($status == 'deleted') {
        $message = "<p class='status done'>Pesanan berhasil dihapus!</p>";
    }
}

echo $message;

if ($action == 'create_form' || $action == 'edit_form') {
    $data = ['id' => '', 'food_id' => '', 'drink_id' => '', 'table_id' => '', 'member_id' => ''];
    $form_title = "Tambah Pesanan Baru";
    $form_action = "create";

    $foods_list = $Foods->getAllFoods();
    $drinks_list = $Drinks->getAllDrinks();
    $tables_list = $Tables->getAllTables();
    $members_list = $Members->getAllMembers();

    if ($action == 'edit_form' && $id) {
        $data = $Orders->getOrderById($id);
        $form_title = "Edit Pesanan ID: " . ($data['id'] ?? '');
        $form_action = "update";
        if (!$data) {
            echo "<p class='status cancelled'>Data pesanan tidak ditemukan.</p>";
            $action = 'read';
        }
    }

    if ($action != 'read') {
        ?>
        <h2><?= $form_title ?></h2>
        <form class="data-form" method="POST" action="index.php?page=orders">
            <input type="hidden" name="action" value="<?= $form_action ?>">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">

            <div style="margin-bottom: 10px;">
                <label for="food_id">Makanan:</label>
                <select id="food_id" name="food_id" required>
                    <?php foreach ($foods_list as $food): ?>
                        <option value="<?= $food['id'] ?>" <?= ($data['food_id'] == $food['id']) ? 'selected' : '' ?>>
                            <?= $food['food_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="drink_id">Minuman:</label>
                <select id="drink_id" name="drink_id" required>
                    <?php foreach ($drinks_list as $drink): ?>
                        <option value="<?= $drink['id'] ?>" <?= ($data['drink_id'] == $drink['id']) ? 'selected' : '' ?>>
                            <?= $drink['drink_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="table_id">Meja:</label>
                <select id="table_id" name="table_id" required>
                    <?php foreach ($tables_list as $table): ?>
                        <option value="<?= $table['id'] ?>" <?= ($data['table_id'] == $table['id']) ? 'selected' : '' ?>>
                            <?= $table['table_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="margin-bottom: 10px;">
                <label for="member_id">Member:</label>
                <select id="member_id" name="member_id" required>
                    <?php foreach ($members_list as $member): ?>
                        <option value="<?= $member['id'] ?>" <?= ($data['member_id'] == $member['id']) ? 'selected' : '' ?>>
                            <?= $member['member_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit"
                class="btn done"><?= ($form_action == 'create' ? 'Simpan Pesanan' : 'Perbarui Pesanan') ?></button>
            <a href="index.php?page=orders" class="btn cancel">Batal</a>
        </form>
        <?php
    }
}

if ($action == 'read') {
    ?>
    <h2>Daftar Pesanan</h2>
    <a href="index.php?page=orders&action=create_form" class="btn done"
        style="margin-bottom: 15px; display: inline-block;">+ Buat Pesanan Baru</a>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Makanan</th>
                <th>Minuman</th>
                <th>Total Harga</th>
                <th>Meja</th>
                <th>Member</th>
                <th>Tanggal Order</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Orders->getAllOrders() as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= $b['food_name'] ?></td>
                    <td><?= $b['drink_name'] ?></td>
                    <td><?= $b['food_price'] + $b['drink_price'] ?></td>
                    <td><?= $b['table_name'] ?></td>
                    <td><?= $b['member_name'] ?></td>
                    <td><?= $b['order_date'] ?></td>
                    <td>
                        <a href="index.php?page=orders&action=edit_form&id=<?= $b['id'] ?>" class="btn done">Edit</a>
                        <a href="index.php?page=orders&action=delete&id=<?= $b['id'] ?>" class="btn cancel"
                            onclick="return confirm('Yakin ingin menghapus Pesanan ID <?= $b['id'] ?>?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>