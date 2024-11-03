<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB GIS - Peta Kabupaten Sleman</title>
    <!-- Link Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" />
    <style>
        /* Styling Umum */
        body {
            background-color: #f8f9fa;
        }

        .content-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            border: 2px solid #007bff;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .header-container h1,
        .header-container h3 {
            margin: 0;
        }

        #map {
            width: 100%;
            height: 720px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        /* Center and widen the "Input Data" button */
        .btn-container {
            text-align: center;
            margin-top: 10px;
        }

        .btn-container .btn {
            width: 50%;
        }

        /* Fixed width for action buttons */
        .btn-action {
            width: 80px;
        }
    </style>
</head>

<body>

    <div class="content-wrapper mt-5">
        <div class="header-container">
            <h1>WEB GIS</h1>
            <h3>Peta Kabupaten Sleman</h3>
        </div>

        <div class="row g-3">
            <!-- Kolom Tabel -->
            <div class="col-md-12 p-3">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Kecamatan</th>
                            <th>ID</th>
                            <th>Longitude</th>
                            <th>Latitude</th>
                            <th>Luas</th>
                            <th>Jumlah Penduduk</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Koneksi ke database
                        $conn = new mysqli("localhost", "root", "", "latihan7b");

                        if ($conn->connect_error) {
                            die("Koneksi gagal: " . $conn->connect_error);
                        }

                        $sql = "SELECT * FROM penduduk";
                        $result = $conn->query($sql);

                        $markers = []; // Array untuk menyimpan marker

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . $row["kecamatan"] . "</td>
                                    <td>" . $row["id"] . "</td>
                                    <td>" . $row["longitude"] . "</td>
                                    <td>" . $row["latitude"] . "</td>
                                    <td>" . $row["luas"] . "</td>
                                    <td>" . $row["jumlah_penduduk"] . "</td>
                                    <td>
                                        <button onclick=\"window.location.href='edit.php?id=" . $row["id"] . "'\" class='btn btn-sm btn-success btn-action'>Edit</button>
                                        <button onclick=\"if(confirm('Apakah Anda yakin ingin menghapus data ini?')) window.location.href='delete.php?id=" . $row["id"] . "'\" class='btn btn-sm btn-danger btn-action'>Delete</button>
                                    </td>
                                </tr>";

                                // Simpan data marker ke array
                                $markers[] = [
                                    'latitude' => $row["latitude"],
                                    'longitude' => $row["longitude"],
                                    'kecamatan' => $row["kecamatan"]
                                ];
                            }
                        } else {
                            echo "<tr><td colspan='7'>Tidak ada data yang ditemukan.</td></tr>";
                        }

                        $conn->close();
                        ?>
                    </tbody>
                </table>

                <!-- Centered and Wide Button Input -->
                <div class="btn-container">
                    <button onclick="window.location.href='input.php'" class="btn btn-primary">Input Data</button>
                </div>

                <!-- Map -->
                <div id="map"></div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <script>
        var map = L.map("map").setView([-7.792151844599088, 110.36604891664561], 13);

        var basemap = L.tileLayer(
            "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }
        );
        basemap.addTo(map);

        var markers = <?php echo json_encode($markers); ?>;

        markers.forEach(function(marker) {
            if (marker.latitude && marker.longitude) {
                L.marker([marker.latitude, marker.longitude])
                    .addTo(map)
                    .bindPopup(marker.kecamatan);
            }
        });
    </script>

</body>

</html>
