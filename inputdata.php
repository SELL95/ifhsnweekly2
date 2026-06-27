<?php
require 'fungsi.php';

if(isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $jurusan = $_POST['prodi']; 
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    
    $foto = $_FILES['foto']['name'];
    $lokasi_sementara = $_FILES['foto']['tmp_name'];
    $folder_tujuan = 'asset/img/';
    if($foto != "") {
        move_uploaded_file($lokasi_sementara, $folder_tujuan . $foto);
    }

    // Perintah memasukkan data ke database
    $query = "INSERT INTO mahasiswa (nama, nim, jurusan, email, no_hp, foto)
              VALUES ('$nama', '$nim', '$jurusan', '$email', '$no_hp', '$foto')";

    mysqli_query($koneksi, $query);

    // Jika data berhasil masuk, munculkan notifikasi lalu PINDAH otomatis ke halaman mahasiswa
    if(mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                document.location.href = 'mahasiswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Data gagal ditambahkan!');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Input Data Mahasiswa</title>
    <link rel="stylesheet" href="asset/img/style.css">
</head>
<body>

    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <td><a href="index.php">Home</a></td>
            <td><a href="profil.php">Profile</a></td>
            <td><a href="contact.php">Contact</a></td>
            <td><a href="mahasiswa.php">Mahasiswa</a></td>
            <td><a href="inputdata.php">Input Data</a></td>
        </tr>
    </table>

    <br>
    <h2>Input Data Mahasiswa</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <table border="1" cellspacing="0" cellpadding="10">
            <tr>
                <td><label for="nama">Nama</label></td>
                <td>:</td>
                <td><input type="text" name="nama" id="nama" required /></td>
            </tr>
            <tr>
                <td><label for="nim">NIM</label></td>
                <td>:</td>
                <td><input type="number" name="nim" id="nim" required /></td>
            </tr>
            <tr>
                <td><label for="prodi">Program Studi</label></td>
                <td>:</td>
                <td><input type="text" name="prodi" id="prodi" required /></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td>:</td>
                <td><input type="email" name="email" id="email" required /></td>
            </tr>
            <tr>
                <td><label for="no_hp">No. Hp</label></td>
                <td>:</td>
                <td><input type="number" name="no_hp" id="no_hp" required /></td>
            </tr>
           <tr>
    <td><label for="foto">Foto</label></td>
    <td>:</td>
    <td><input type="file" name="foto" id="foto" accept="image/*"></td>
</tr>
            <tr>
                <td colspan="3" style="text-align: left;">
                    <input type="submit" name="submit" value="Kirim Data" />
                </td>
            </tr>
        </table>
    </form>

</body>
</html>