<?php

    $koneksi = mysqli_connect ("localhost", "root", "", "ifhsnweekly");

    function tampildata($query)
    {
        global $koneksi;
        $result = mysqli_query($koneksi, $query); /// lemari
        
        $rows = []; /// wadah

        while($row = mysqli_fetch_assoc($result)) 
        {
            $rows[] = $row; /// ambil baju taruh ke wadah
        }
        return $rows;
    }
    
function hapusdata($id) 
    {
        global $koneksi;
        $query = "DELETE FROM mahasiswa WHERE id = $id";
        mysqli_query($koneksi, $query);
        return mysqli_affected_rows($koneksi);
    }

?>