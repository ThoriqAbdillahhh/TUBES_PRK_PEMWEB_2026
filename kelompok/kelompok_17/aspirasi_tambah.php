<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit();
}

$stmt = $pdo->query("SELECT * FROM kategori ORDER BY nama_kategori ASC");
$kategori_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white p-8 rounded-lg shadow-md border">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Kirim Aspirasi Mahasiswa (FISIP)</h2>
        
        <form action="aspirasi_proses.php" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Judul Aspirasi</label>
                <input type="text" name="judul" required class="w-full mt-1 p-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori Isu</label>
                <select name="id_kategori" required class="w-full mt-1 p-2 border border-gray-300 rounded-md">
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_list as $kat): ?>
                        <option value="<?= $kat['id_kategori'] ?>"><?= htmlspecialchars($kat['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Isi Aspirasi & Pesan</label>
                <textarea name="isi" rows="5" required class="w-full mt-1 p-2 border border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_anonim" id="is_anonim" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                <label for="is_anonim" class="ml-2 block text-sm text-gray-900">
                    Kirim sebagai <strong>Anonim</strong> (Nama disamarkan di publik, namun identitas tetap aman tercatat di sistem)
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition font-semibold">
                Kirim Aspirasi
            </button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>