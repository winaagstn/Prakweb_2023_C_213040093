<?php  
function koneksi(){
//  Koneksi ke MySQL & memilih DB
$conn = mysqli_connect('localhost', 'root', '', 'pw') or die ('Koneksi ke database GAGAL!' . mysqli_error($conn));

return $conn;
}

function query($query){
    $conn = koneksi();
// query untuk mengambil seluruh isi dari tabel buku
    $result = mysqli_query($conn, "SELECT * FROM buku") or die ('Query GAGAL!' . mysqli_error($conn));
    mysqli_error($conn);

// looping untuk mengambil setiap data buku satu per-satu
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }

return $rows;
}

function tambah($data){
    $conn = koneksi();

    // sanitasi data (untuk melindungi data dari kegiatan jahat user)
    $judul = mysqli_real_escape_string($conn, htmlspecialchars($data['judul']));
    $penulis = mysqli_real_escape_string($conn, htmlspecialchars($data['penulis']));
    $penerbit = mysqli_real_escape_string($conn, htmlspecialchars($data['penerbit']));
    $kategori = mysqli_real_escape_string($conn, htmlspecialchars($data['kategori']));
    $gambar = mysqli_real_escape_string($conn, htmlspecialchars($data['gambar']));

    // siapkan query insert data
    $query = "INSERT INTO buku
                VALUES (null, '$judul', '$penulis', '$penerbit', '$kategori', '$gambar')";

    // insert data ke tabel buku
    mysqli_query($conn, $query) or die ('Koneksi ke database GAGAL!' . mysqli_error($conn));

    // kembalikan nilai keberhasilannya
    return mysqli_affected_rows($conn);
}

function hapus($id){
    $conn = koneksi();
    mysqli_query($conn, "DELETE FROM buku WHERE id = $id") or die ('Koneksi ke database GAGAL!' . mysqli_error($conn));
    mysqli_error($conn);

    return mysqli_affected_rows($conn);
}

function ubah($data){
    $conn = koneksi();

    // sanitasi data (untuk melindungi data dari kegiatan jahat user)
    $id = $data['id'];
    $judul = mysqli_real_escape_string($conn, htmlspecialchars($data['judul']));
    $penulis = mysqli_real_escape_string($conn, htmlspecialchars($data['penulis']));
    $penerbit = mysqli_real_escape_string($conn, htmlspecialchars($data['penerbit']));
    $kategori = mysqli_real_escape_string($conn, htmlspecialchars($data['kategori']));
    $gambar = mysqli_real_escape_string($conn, htmlspecialchars($data['gambar']));

    // siapkan query insert data
    $query = "UPDATE buku
                SET 
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                kategori = '$kategori',
                gambar = '$gambar'
                WHERE id = $id
              ";

    // update data dari tabel buku
    mysqli_query($conn, $query) or die ('Koneksi ke database GAGAL!' . mysqli_error($conn));

    // kembalikan nilai keberhasilannya
    return mysqli_affected_rows($conn);
}

?>