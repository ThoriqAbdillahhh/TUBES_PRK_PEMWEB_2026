<?php
require_once __DIR__ . '/../../includes/auth_admin.php';
require_once __DIR__ . '/../../includes/csrf.php';
require_once __DIR__ . '/../../config/database.php'; // menyediakan $pdo

// Pesan singkat setelah tambah, edit, atau hapus. Hanya kode yang diizinkan yang ditampilkan.
$pesanTeks = [
    'tambah' => 'Berita berhasil ditambahkan.',
    'edit'   => 'Berita berhasil diperbarui.',
    'hapus'  => 'Berita berhasil dihapus.',
];
$kode = $_GET['pesan'] ?? '';
$pesan = $pesanTeks[$kode] ?? '';

// Ambil daftar berita beserta nama kategori dan penulisnya.
$stmt = $pdo->prepare(
    'SELECT b.id_berita, b.judul_berita, b.gambar_url, b.tanggal_publikasi,
            k.nama_kategori, u.nama_lengkap
       FROM berita b
       JOIN kategori k ON k.id_kategori = b.id_kategori
       JOIN users u ON u.id_user = b.id_user
      ORDER BY b.tanggal_publikasi DESC'
);
$stmt->execute();
$daftarBerita = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - KabarSih</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-800">
<?php include __DIR__ . '/../../includes/admin_nav.php'; ?>

<main class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Kelola Berita</h1>
        <a href="tambah.php" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">+ Tambah Berita</a>
    </div>

    <?php if ($pesan !== ''): ?>
        <div class="bg-emerald-100 text-emerald-800 rounded p-3 mb-4"><?= e($pesan) ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-100 text-left">
                <tr>
                    <th class="p-3">Gambar</th>
                    <th class="p-3">Judul</th>
                    <th class="p-3">Kategori</th>
                    <th class="p-3">Penulis</th>
                    <th class="p-3">Tanggal</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!$daftarBerita): ?>
                <tr><td colspan="6" class="p-4 text-center text-slate-500">Belum ada berita.</td></tr>
            <?php endif; ?>
            <?php foreach ($daftarBerita as $b): ?>
                <tr class="border-t align-top">
                    <td class="p-3">
                        <?php if (!empty($b['gambar_url'])): ?>
                            <img src="../../uploads/<?= e($b['gambar_url']) ?>" alt="" class="w-16 h-12 object-cover rounded">
                        <?php else: ?>
                            <span class="text-slate-400">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-3 font-medium"><?= e($b['judul_berita']) ?></td>
                    <td class="p-3"><?= e($b['nama_kategori']) ?></td>
                    <td class="p-3"><?= e($b['nama_lengkap']) ?></td>
                    <td class="p-3"><?= e(date('d M Y H:i', strtotime($b['tanggal_publikasi']))) ?></td>
                    <td class="p-3">
                        <div class="flex gap-2">
                            <a href="edit.php?id=<?= (int) $b['id_berita'] ?>" class="bg-amber-500 text-white px-3 py-1 rounded hover:bg-amber-600">Edit</a>
                            <form method="POST" action="hapus.php" onsubmit="return confirm('Hapus berita ini? Komentar di berita ini juga akan ikut terhapus.');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id_berita" value="<?= (int) $b['id_berita'] ?>">
                                <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>
</body>
</html>