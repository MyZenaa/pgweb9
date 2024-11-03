<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "latihan7b");

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika form dikirim, proses data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $kecamatan = $_POST["kecamatan"];
    $longitude = $_POST["longitude"];
    $latitude = $_POST["latitude"];
    $luas = $_POST["luas"];
    $jumlah_penduduk = $_POST["jumlah_penduduk"];

    // Prepared statement untuk menambah data
    $stmt = $conn->prepare("INSERT INTO penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddi", $kecamatan, $longitude, $latitude, $luas, $jumlah_penduduk);

    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data - WEB GIS</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    />
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            background-color: #f8f9fa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .btn-container {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="form-container">
            <h2>Input Data Penduduk</h2>
            <form action="input.php" method="POST" class="mt-4">
                <div class="form-group row">
                    <label for="kecamatan" class="col-sm-4 col-form-label">Kecamatan:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="kecamatan" name="kecamatan" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="longitude" class="col-sm-4 col-form-label">Longitude:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="longitude" name="longitude" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="latitude" class="col-sm-4 col-form-label">Latitude:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="latitude" name="latitude" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="luas" class="col-sm-4 col-form-label">Luas:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="luas" name="luas" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jumlah_penduduk" class="col-sm-4 col-form-label">Jumlah Penduduk:</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="jumlah_penduduk" name="jumlah_penduduk" required>
                    </div>
                </div>
                <br>
                <div class="btn-container mt-4">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin membatalkan?')">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>