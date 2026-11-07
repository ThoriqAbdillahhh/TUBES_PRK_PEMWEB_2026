<?php
// Komponen form berita bersama untuk tambah.php dan edit.php.
// Variabel yang diharapkan sebelum include:
//   $action        : tujuan form (misal "tambah.php" atau "edit.php?id=3")
//   $nilai         : ['judul' => ..., 'kategori' => ..., 'isi' => ..., 'gambar_url' => ...]
//   $kategori      : daftar kategori dari tabel kategori
//   $errors        : daftar pesan error (boleh kosong)
//   $judulHalaman  : judul di atas form
//   csrf_field() harus sudah tersedia (dari includes/csrf.php)

$judulHalaman = $judulHalaman ?? 'Form Berita';
?>
<h1 class="text-2xl font-bold mb-4"><?= e($judulHalaman) ?></h1>

<?php if (!empty($errors)): ?>
    <div class="bg-red-100 text-red-800 rounded p-3 mb-4">
        <ul class="list-disc pl-5">
            <?php foreach ($errors as $pesanError): ?>
                <li><?= e($pesanError) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?= e($action) ?>" enctype="multipart/form-data" class="bg-white rounded-lg shadow p-6 space-y-4 max-w-3xl">
    <?= csrf_field() ?>

    <div>
        <label class="block font-medium mb-1" for="judul">Judul Berita</label>
        <input type="text" id="judul" name="judul" maxlength="255" required
               value="<?= e($nilai['judul']) ?>"
               class="w-full px-3 py-2 border rounded">
    </div>

    <div>
        <label class="block font-medium mb-1" for="kategori">Kategori</label>
        <select id="kategori" name="kategori" required class="w-full px-3 py-2 border rounded">
            <option value="">-- Pilih kategori --</option>
            <?php foreach ($kategori as $k): ?>
                <option value="<?= (int) $k['id_kategori'] ?>"
                    <?= ((string) $nilai['kategori'] === (string) $k['id_kategori']) ? 'selected' : '' ?>>
                    <?= e($k['nama_kategori']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <label class="block font-medium mb-1" for="isi">Isi Berita</label>
        <textarea id="isi" name="isi" rows="10" required class="w-full px-3 py-2 border rounded"><?= e($nilai['isi']) ?></textarea>
    </div>

    <div>
        <label class="block font-medium mb-1" for="gambar">Gambar (opsional, JPG/PNG/WEBP, maks. 2 MB)</label>
        <?php if (!empty($nilai['gambar_url'])): ?>
            <img src="../../uploads/<?= e($nilai['gambar_url']) ?>" alt="" class="w-40 rounded mb-2">
            <p class="text-sm text-slate-500 mb-2">Mengunggah gambar baru akan menggantikan gambar ini.</p>
        <?php endif; ?>
        <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png,image/webp" class="w-full">
    </div>

    <div class="flex gap-2 pt-2">
        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded hover:bg-teal-700">Simpan</button>
        <a href="index.php" class="px-4 py-2 rounded border">Batal</a>
    </div>
</form>