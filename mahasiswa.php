<?php

    require 'fungsi.php';
    if (isset($_POST['simpan_ubah'])) {
        $nim       = $_POST['nim'];
        $nama      = $_POST['nama'];
        $jurusan   = $_POST['jurusan'];
        $email     = $_POST['email'];
        $no_hp     = $_POST['no_hp'];
        $foto_lama = $_POST['foto_lama']; 
        if ($_FILES['foto']['error'] === 4) {
            $foto = $foto_lama; 
        } else {
            $foto = $_FILES['foto']['name'];
            $lokasi_sementara = $_FILES['foto']['tmp_name'];
            $folder_tujuan = 'asset/img/';
            move_uploaded_file($lokasi_sementara, $folder_tujuan . $foto);
        }
        $query_update = "UPDATE mahasiswa SET 
                         nama = '$nama', 
                         jurusan = '$jurusan', 
                         email = '$email', 
                         no_hp = '$no_hp',
                         foto = '$foto' 
                         WHERE nim = '$nim'";

        if (mysqli_query($koneksi, $query_update)) { 
            echo "<script>
                    alert('Data berhasil diubah!');
                    window.location.href = 'mahasiswa.php';
                  </script>";
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
    $qmahasiswa = "SELECT * FROM mahasiswa"; /// karena query ke tabel mahasiswa
    $mahasiswas = tampildata($qmahasiswa); /// menghasilkan mahasiswa dalam wadah
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB INFORMATIKA C 2026</title>
    <link rel="stylesheet" href="asset/img/style.css">
<style>
.modal {
    display: none; /* Sembunyikan secara default */
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); 
}

/* Kotak Form Edit */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* Jarak dari atas */
    padding: 25px;
    border-radius: 8px; /* Ujung agak melengkung */
    width: 40%; /* Lebar pop-up */
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    font-family: Arial, sans-serif;
}

/* Tombol Tutup (X) */
.close-btn {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}
.close-btn:hover { color: red; }

/* Desain Input Form agar Rapi */
.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    text-align: left;
}
.form-group input {
    width: 100%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.btn-simpan {
    background-color: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    margin-top: 10px;
}
.btn-simpan:hover { background-color: #45a049; }
</style>
</head>
<body>
    <hr>
    <h1>WEB INFORMATIKA C 2026</h1>
    <hr>
    
    <table border="1" cellspacing="0" cellpadding="10px">
        <tr>
            <td>
                <a href="index.php">Home</a>
            </td>
            <td>
                <a href="profil.php">Profile</a>
            </td>
            <td>
                <a href="contact.php">Contact</a>
            </td>
            <td>
                <a href="mahasiswa.php">Data Mahasiswa</a>
            </td>
            <td>
                <a href="inputdata.php">Input Data</a>
            </td> 
        </tr>
    </table>
    
    <h3>Data Mahasiswa</h3>
    <div>
        <a href="inputdata.php">Kembali ke Home</a>
        <button>Tambah Data</button>
    </div>
    <br><br>
    
    <table border="1" cellspacing="0" cellpadding="5px">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Jurusan</th>
            <th>Email</th>
            <th>No.HP</th>
            <th>Foto</th> 
            <th>Aksi</th>
        </tr>
        
        <?php
        $no = 1;
        foreach($mahasiswas as $mhs) 
            {
        ?>
        
        <tr>
            <td align="center"><?php echo $mhs['id']; ?></td>
            <td><?php echo $mhs['nama']; ?></td>
            <td align="center"><?php echo $mhs['nim']; ?></td>
            <td align="center"><?php echo $mhs['jurusan']; ?></td>
            <td align="center"><?php echo $mhs['email']; ?></td>
            <td><?php echo $mhs['no_hp']; ?></td>
            
            <td align="center">
                <?php 
                if($mhs['foto'] != NULL) { 
                    echo '<img src="asset/img/' . $mhs['foto'] . '" width="80" height="80">';
                } else {
                    echo "Tidak ada foto";
                }
                ?>
            </td>

            <td align="center">
                <button type="button" onclick="document.getElementById('editModal<?= $mhs['nim']; ?>').style.display='block'">Edit</button>
                <a href="hapus data.php?id=<?php echo $mhs['id']; ?>" onclick="return confirm('Yakin ingin menghapus data?')"><button>Hapus</button></a>
            </td>
        </tr>

        <div id="editModal<?= $mhs['nim']; ?>" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="document.getElementById('editModal<?= $mhs['nim']; ?>').style.display='none'">&times;</span>
                <h3 style="margin-top: 0; text-align: left;">Edit Data Mahasiswa</h3>
                
                <form action="" method="POST" enctype="multipart/form-data" style="text-align: left;">
                    
                    <input type="hidden" name="foto_lama" value="<?= $mhs['foto']; ?>">
                    
                    <div class="form-group">
                        <label>NIM</label>
                        <input type="text" name="nim" value="<?= $mhs['nim']; ?>" readonly style="background-color: #eee;">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" value="<?= $mhs['nama']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Jurusan</label>
                        <input type="text" name="jurusan" value="<?= $mhs['jurusan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="<?= $mhs['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label>No. HP</label>
                        <input type="text" name="no_hp" value="<?= $mhs['no_hp']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Foto Baru</label>
                        <small style="color: gray;">(Kosongkan jika tidak ingin mengubah foto)</small>
                        <input type="file" name="foto" accept="image/*">
                    </div>
                    
                    <button type="submit" name="simpan_ubah" class="btn-simpan">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        
        <?php
        } 
        ?>
    </table>

    <br><br>

    <table border="1" cellspacing="0" cellpadding="5px">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>UTS</th>
            <th>UAS</th>
            <th>Tugas</th>
            <th>Foto</th>
        </tr>
        <tr>
            <td align="center">1</td>
            <td>Rangga</td>
            <td align="center">85</td>
            <td align="center">88</td>
            <td align="center">95</td>
            <td align="center"><img src="asset/img/rangga.jpeg" width="80" height="80"></td>
        </tr>
        <tr>
            <td align="center">2</td>
            <td>Vincent</td>
            <td align="center">80</td>
            <td align="center">90</td>
            <td align="center">90</td>
            <td align="center"><img src="asset/img/vincent.jpg" width="80" height="80"></td>
        </tr>
        <tr>
            <td align="center">3</td>
            <td>Sir Bradpit</td>
            <td align="center">85</td>
            <td align="center">87</td>
            <td align="center">95</td>
            <td align="center"><img src="asset/img/sir%20bradpit.jpg" width="80" height="80"></td>
        </tr>
    </table>
    
    <hr>
    
    <h3>Latihan</h3>
    <table border="1" cellpadding="20px" cellspacing="0">
        <tr>
            <td>1,1</td>
            <td>1,2</td>
            <td>1,3</td>
            <td>1,4</td>
        </tr>
        <tr>
            <td>2,1</td>
            <td colspan="2" rowspan="2" align="center" style="font-size: 30px;">wleeeeeee</td>
            <td>2,4</td>
        </tr>
        <tr>
            <td>3,1</td>
            <td>3,4</td>
        </tr>
        <tr>
            <td>4,1</td>
            <td>4,2</td>
            <td>4,3</td>
            <td>4,4</td>
        </tr>
    </table>
</body>
</html>