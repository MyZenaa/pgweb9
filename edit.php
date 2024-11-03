<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "latihan7b");

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Memeriksa apakah ID telah diterima melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mengambil data berdasarkan ID
    $sql = "SELECT * FROM penduduk WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc(); // Ambil data
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak valid.";
    exit;
}

// Memproses form saat disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    // Query untuk memperbarui data
    $sql = "UPDATE penduduk SET 
            kecamatan = '$kecamatan', 
            longitude = '$longitude', 
            latitude = '$latitude', 
            luas = '$luas', 
            jumlah_penduduk = '$jumlah_penduduk' 
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('Data berhasil diperbarui.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Penduduk</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    />
    <style>
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        label {
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-light">

    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Edit Data Penduduk</h2>
            <form method="POST" action="">
                <div class="form-group row">
                    <label for="kecamatan" class="col-sm-4 col-form-label">Kecamatan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $row['kecamatan']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="longitude" class="col-sm-4 col-form-label">Longitude</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="longitude" name="longitude" value="<?php echo $row['longitude']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="latitude" class="col-sm-4 col-form-label">Latitude</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="latitude" name="latitude" value="<?php echo $row['latitude']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="luas" class="col-sm-4 col-form-label">Luas</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="luas" name="luas" value="<?php echo $row['luas']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_penduduk" class="col-sm-4 col-form-label">Jumlah Penduduk</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="jumlah_penduduk" name="jumlah_penduduk" value="<?php echo $row['jumlah_penduduk']; ?>" required>
                    </div>
                </div>
                <div class="d-flex justify-content-between mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>
