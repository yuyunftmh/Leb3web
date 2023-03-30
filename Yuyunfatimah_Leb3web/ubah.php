<?php
error_reporting(E_ALL);
include_once 'koneksi.php';
if (isset($_POST['submit'])) {
  $id = $_POST['id'];
  $nama = $_POST['nama'];
  $kategori = $_POST['kategori'];
  $harga_jual = $_POST['harga_jual'];
  $harga_beli = $_POST['harga_beli'];
  $stok = $_POST['stok'];
  $file_gambar = $_FILES['file_gambar'];
  $gambar = null;
  if ($file_gambar['error'] == 0) {
    $filename = str_replace(' ', '_', $file_gambar['name']);
    $destination = dirname(__FILE__) . '/gambar/' . $filename;
    if (move_uploaded_file($file_gambar['tmp_name'], $destination)) {
      $gambar = 'gambar/' . $filename;;
    }
  }
  $sql = 'UPDATE data_barang SET ';
  $sql .= "nama = '{$nama}', kategori = '{$kategori}', ";
  $sql .= "harga_jual = '{$harga_jual}', harga_beli = '{$harga_beli}',
    stok = '{$stok}' ";
  if (!empty($gambar))
    $sql .= ", gambar = '{$gambar}' ";
  $sql .= "WHERE id_barang = '{$id}'";
  $result = mysqli_query($conn, $sql);
  header('location: index.php');
}
$id = $_GET['id'];
$sql = "SELECT * FROM data_barang WHERE id_barang = '{$id}'";
$result = mysqli_query($conn, $sql);
if (!$result) die('Error: Data tidak tersedia');
$data = mysqli_fetch_array($result);
function is_select($var, $val)
{
  if ($var == $val) return 'selected="selected"';
  return false;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link href="style.css" rel="stylesheet" type="text/css" />
  <title>Ubah Barang</title>
  <style>
    .input label {
      display: block;
      margin-bottom: 5px;
      margin-left: 40px;
      font-weight: bold;

    }

    .input input[type="text"],
    .input select,
    .input input[type="file"] {
      width: 50%;
      padding: 10px;
      border: 1px solid #ccc;
      margin-left: 40px;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .submit input[type="submit"] {
      background-color: #33C4FF;
      color: white;
      padding: 12px;
      border: none;
      margin-left: 40px;
      border-radius: 4px;
      cursor: pointer;
    }

    .submit input[type="submit"]:hover {
      background-color: #8A2BE2;
    }

    /* Style untuk preview gambar */
    .preview {
      margin-top: 10px;
      width: 50%;
      height: 200px;
      border: 1px solid #ccc;
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
    }

    h1 {
      font-size: 24px;
      text-align: center;
      width: 50%;
      margin-left: 40px;
    }

    .preview img {
      width: 100%;
      height: auto;
    }
  </style>
</head>

<body>
  <div class="container">
    <h1>Ubah Barang</h1>
    <div class="main">

      <form method="post" action="ubah.php" enctype="multipart/form-
    data">

        <div class="input">
          <label>Nama Barang</label>
          <input type="text" name="nama" value="<?php echo
                                                $data['nama']; ?>" />
        </div>
        <div class="input">
          <label>Kategori</label>
          <select name="kategori">
            <option <?php echo is_select('Komputer', $data['kategori']); ?> value="Komputer">Komputer</option>
            <option <?php echo is_select('Komputer', $data['kategori']); ?> value="Elektronik">Elektronik</option>
            <option <?php echo is_select('Komputer', $data['kategori']); ?> value="Hand Phone">Hand Phone</option>
          </select>
        </div>
        <div class="input">
          <label>Harga Jual</label>
          <input type="text" name="harga_jual" value="<?php echo
                                                      $data['harga_jual']; ?>" />
        </div>
        <div class="input">
          <label>Harga Beli</label>
          <input type="text" name="harga_beli" value="<?php echo
                                                      $data['harga_beli']; ?>" />
        </div>
        <div class="input">
          <label>Stok</label>
          <input type="text" name="stok" value="<?php echo
                                                $data['stok']; ?>" />
        </div>
        <div class="input">
          <label>File Gambar</label>
          <input type="file" name="file_gambar" />
        </div>
        <div class="submit">
          <input type="hidden" name="id" value="<?php echo
                                                $data['id_barang']; ?>" />
          <input type="submit" name="submit" value="Simpan" />
        </div>
      </form>
    </div>
  </div>
</body>

</html>