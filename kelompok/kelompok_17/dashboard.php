<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$selected_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : '';

$kategori_stmt = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$kategori_list = $kategori_stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT a.*, k.nama_kategori 
          FROM aspirasi a 
          JOIN kategori k ON a.id_kategori = k.id_kategori 
          WHERE a.id_user = :id_user";

if (!empty($selected_kategori)) {
    $query .= " AND a.id_kategori = :id_kategori";
}
$query .= " ORDER BY a.created_at DESC";

$stmt = $pdo->prepare($query);
$params = [':id_user' => $id_user];
if (!empty($selected_kategori)) {
    $params[':id_kategori'] = $selected_kategori;
}
$stmt->execute($params);
$aspirasi_user = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="max-w-5xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Histori Aspirasi Saya</h1>
        <a href="aspirasi_tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 font-semibold">+ Buat Aspirasi Baru</a>
    </div>

    <form method="GET" action="dashboard.php" class="bg-white p-4 rounded-md shadow border mb-6 flex items-center space-x-4">
        <label class="font-medium text-gray-700">Filter Kategori:</label>
        <select name="id_kategori" onchange="this.form.submit()" class="p-2 border rounded-md">
            <option value="">Semua Kategori</option>
            <?php foreach ($kategori_list as $kat): ?>
                <option value="<?= $kat['id_kategori'] ?>" <?= $selected_kategori == $kat['id_kategori'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kat['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php if(!empty($selected_kategori)): ?>
            <a href="dashboard.php" class="text-sm text-red-600 hover:underline">Reset Filter</a>
        <?php endif; ?>
    </form>

    <div class="bg-white rounded-lg shadow border overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="p-4 font-semibold text-gray-600">Judul Aspirasi</th>
                    <th class="p-4 font-semibold text-gray-600">Kategori</th>
                    <th class="p-4 font-semibold text-gray-600">Opsi Tampil</th>
                    <th class="p-4 font-semibold text-gray-600">Status</th>
                    <th class="p-4 font-semibold text-gray-600">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($aspirasi_user) > 0): ?>
                    <?php foreach ($aspirasi_user as $asp): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 font-medium text-gray-900"><?= htmlspecialchars($asp['judul']) ?></td>
                            <td class="p-4 text-gray-600"><?= htmlspecialchars($asp['nama_kategori']) ?></td>
                            <td class="p-4">
                                <?php if ($asp['is_anonim']): ?>
                                    <span class="bg-purple-100 text-purple-800 text-xs px-2.5 py-0.5 rounded font-medium">Anonim</span>
                                <?php else: ?>
                                    <span class="bg-gray-100 text-gray-800 text-xs px-2.5 py-0.5 rounded font-medium">Publik</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <?php 
                                    $statusClass = [
                                        'Menunggu' => 'bg-yellow-100 text-yellow-800',
                                        'Ditinjau' => 'bg-blue-100 text-blue-800',
                                        'Selesai' => 'bg-green-100 text-green-800'
                                    ][$asp['status']] ?? 'bg-gray-100 text-gray-800';
                                ?>
                                <span class="text-xs px-2.5 py-0.5 rounded font-semibold <?= $statusClass ?>">
                                    <?= htmlspecialchars($asp['status']) ?>
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-500"><?= date('d M Y, H:i', strtotime($asp['created_at'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada aspirasi yang dikirim.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>