<h2>Daftar Pesanan</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Meja</th>
                    <th>Nama Member</th>
                    <th>Pesanan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh data dinamis -->
                <?php foreach ($Drinks->getAllDrinks() as $b): ?>
                <tr>
                    <td><?= $b['id'] ?></td>
                    <td><?= $b['drink_name'] ?></td>
                    <td><?= $b['harga'] ?></td>
                    <td><?= $b['stok'] ?></td>
                </tr>
                <?php endforeach; ?>

                <!-- Contoh data statis -->
                <tr>
                    <td>1</td>
                    <td>Meja 3</td>
                    <td>Andi</td>
                    <td>
                        Nasi Goreng (1x)<br>
                        Es Teh (1x)
                    </td>
                    <td>Rp 35.000</td>
                    <td><span class="status pending">Menunggu</span></td>
                    <td>
                        <button class="btn done">Selesai</button>
                        <button class="btn cancel">Batal</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Meja 5</td>
                    <td>-</td>
                    <td>
                        Mie Ayam (2x)<br>
                        Es Jeruk (2x)
                    </td>
                    <td>Rp 60.000</td>
                    <td><span class="status cooking">Dimasak</span></td>
                    <td>
                        <button class="btn done">Selesai</button>
                        <button class="btn cancel">Batal</button>
                    </td>
                </tr>
            </tbody>
        </table>