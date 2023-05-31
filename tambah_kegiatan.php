<?php 
require_once 'koneksi.php';
if (!isset($_SESSION['id_user'])) {
	header("Location: login.php");
	exit;
}

$id_user = $_SESSION['id_user'];
$data_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id_user'"));

if (isset($_POST['btnTambah'])) {
	$isi_kegiatan = nl2br($_POST['isi_kegiatan']);
	$tenggat_waktu = $_POST['tenggat_waktu'];
	$pengeluaran = $_POST['pengeluaran'];

	$tambah_kegiatan = mysqli_query($koneksi, "INSERT INTO kegiatan VALUES ('', '$id_user', '$isi_kegiatan', '$tenggat_waktu', 'belum')");

	if ($tambah_kegiatan) {
		$id_kegiatan = mysqli_insert_id($koneksi);
		$tambah_pengeluaran = mysqli_query($koneksi, "INSERT INTO pengeluaran VALUES ('', '$pengeluaran', '$id_kegiatan')");

		echo "
			<script>
				alert('kegiatan berhasil ditambahkan!')
				window.location.href='index.php'
			</script>
		";
		exit;
	} else {
		echo "
			<script>
				alert('kegiatan gagal ditambahkan!')
				window.location.href='index.php'
			</script>
		";
		exit;
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>TAMBAH KEGIATAN</title>
	<link rel="icon" href="img/logo.jpg">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<nav>
	  <ul>
	    <li><a href="profile.php">Selamat Datang, <?= $data_user['nama_lengkap']; ?></a></li>
	    <li><a href="index.php">Daftar Kegiatan</a></li>
	    <li><a href="tambah_kegiatan.php">Tambah Kegiatan</a></li>
	    <li class="right"><a href="logout.php">Logout</a></li>
	  </ul>
	</nav>
	<div class="container">
		<button type="button" onclick="return window.history.back()" class="button">Kembali</button>
		<h1>Tambah Kegiatan</h1>
		<form method="post">
			<div class="form-group">
				<label for="isi_kegiatan" class="form-label">Isi Kegiatan</label>
				<textarea name="isi_kegiatan" id="isi_kegiatan" class="form-input" required></textarea>
			</div>
			<div class="form-group">
				<label for="tenggat_waktu" class="form-label">Tenggat Waktu</label>
				<input type="datetime-local" name="tenggat_waktu" id="tenggat_waktu" class="form-input" required value="<?= date('Y-m-d H:i'); ?>">
			</div>
			<div class="form-group">
				<label for="pengeluaran" class="form-label">Pengeluaran yang digunakan (Rp.)</label>
				<input type="number" name="pengeluaran" id="pengeluaran" class="form-input" required>
			</div>
			<div class="form-group">
				<button type="submit" name="btnTambah" class="button">Tambah</button>
			</div>
		</form>
	</div>
</body>
</html>