<h2>Daftar Makanan</h2>
<table class="data-table">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Makanan</th>
            <th>Harga</th>
            <th>Stok</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($Foods->getAllFoods() as $b): ?>
            <tr>
                <td><?= $b['id'] ?></td>
                <td><?= $b['food_name'] ?></td>
                <td><?= $b['harga'] ?></td>
                <td><?= $b['stok'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>