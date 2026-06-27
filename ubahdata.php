<?php
// 1. Hubungkan ke file koneksi database Anda (sesuaikan nama filenya jika berbeda)
include 'fungsi.php'; 

$nim_edit = $_GET['nim'];

$query_tampil = mysqli_query($koneksi, "SELECT * FROM mahasiswa WHERE nim = '$nim_edit'");
$data = mysqli_fetch_assoc($query_tampil);

// Proses jika tombol "Simpan Perubahan" diklik
if (isset($_POST['simpan_ubah'])) {
    $nama    = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $email   = $_POST['email'];
    $no_hp   = $_POST['no_hp'];

    $query_update = "UPDATE mahasiswa SET 
                     nama = '$nama', 
                     jurusan = '$jurusan', 
                     email = '$email', 
                     no_hp = '$no_hp' 
                     WHERE nim = '$nim_edit'";

    if (mysqli_query($koneksi, $query_update)) {
        echo "<script>
                alert('Data berhasil diubah!');
                window.location.href = 'mahasiswa.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Mahasiswa</title>
    </head>
<body>

    <h2>Edit Data Mahasiswa</h2>

    <form action="" method="POST">
        <table>
            <tr>
                <td>NIM</td>
                <td>:</td>
                <td><input type="text" name="nim" value="<?= $data['nim']; ?>" readonly></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><input type="text" name="nama" value="<?= $data['nama']; ?>" required></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>:</td>
                <td><input type="text" name="jurusan" value="<?= $data['jurusan']; ?>" required></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><input type="email" name="email" value="<?= $data['email']; ?>" required></td>
            </tr>
            <tr>
                <td>No. HP</td>
                <td>:</td>
                <td><input type="text" name="no_hp" value="<?= $data['no_hp']; ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <button type="submit" name="simpan_ubah">Simpan Perubahan</button>
                    <a href="mahasiswa.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>