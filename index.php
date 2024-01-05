<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table, th, td {
            border: 1px solid #b1b1b1;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        button {
            padding: 8px;
            cursor: pointer;
        }
		
		
        /* Gaya Tombol tambah */
        .add-button {
            background-color: green;
            color: #fff;
        }
		.edit-button {
            background-color: #3498db;
            color: #fff;
        }

        /* Gaya Tombol Delete */
        .delete-button {
            background-color: #e74c3c;
            color: #fff;
        }
		.pagination {
            margin-top: 20px;
        }

        .pagination a {
            color: #3498db;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
        }

        .pagination a:hover {
            background-color: #f1f1f1;
        }

        .pagination .active {
            background-color: #3498db;
            color: #fff;
            border: 1px solid #3498db;
        }
    </style>
</head>
<body>

    <h2>Daftar Barang</h2>

    <!-- Form Pencarian -->
    <form action="" method="GET">
        <label for="search">Cari Barang:</label>
        <input type="text" id="search" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Cari</button>
    </form>
<!-- Tombol Tambah Barang -->
    <a href="tambah_barang.php">
        <button class="add-button" type="button">Tambah Barang</button>
    </a>

    <?php
    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pemroweb";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Inisialisasi variabel pencarian
    $searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';

    // Query untuk menghitung total baris
    $count_sql = "SELECT COUNT(*) as total FROM barang WHERE nama_barang LIKE '%$searchKeyword%'";
    $count_result = $conn->query($count_sql);
    $total_rows = $count_result->fetch_assoc()['total'];

    // Jumlah baris per halaman
    $rows_per_page = 5;

    // Jumlah total halaman
    $total_pages = ceil($total_rows / $rows_per_page);

    // Halaman saat ini
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    // Menghitung offset
    $offset = ($page - 1) * $rows_per_page;

    // Query SQL dengan LIMIT
    $sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$searchKeyword%' LIMIT $offset, $rows_per_page";
    $result = $conn->query($sql);

        // Tampilkan hasil pencarian
        echo "<table border='1'>
                <tr>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
					<th> Edit</th>
					<th> Delete</th>
                </tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row['id_barang'] . "</td>
                    <td>" . $row['nama_barang'] . "</td>
                    <td>" . $row['kategori'] . "</td>
                    <td>" . $row['harga_jual'] . "</td>
                    <td>" . $row['harga_beli'] . "</td>
                    <td>" . $row['stok_barang'] . "</td>
					<td> <button class='edit-button' type='button'>Edit Barang</button></td>
					<td><button class='delete-button' type='button'>Hapus Barang</button></td>
                </tr>";
        }
} else {
        echo "Tidak ada hasil ditemukan";
    }
	
        echo "</table></br>";
		 // Menampilkan pagination
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?search=$searchKeyword&page=$i' ";
            if ($i == $page) {
                echo "class='active'";
            }
            echo ">$i</a>";
        }
        echo "</div>";
    

    // Menampilkan pagination
   // Menghitung total baris (tanpa LIMIT)
$total_rows = $result->num_rows;

// Jumlah baris per halaman
$rows_per_page = 5;

// Jumlah total halaman
$total_pages = ceil($total_rows / $rows_per_page);

// Halaman saat ini
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Menghitung offset
$offset = ($page - 1) * $rows_per_page;

// Query SQL dengan LIMIT
$sql = "SELECT * FROM barang WHERE nama_barang LIKE '%$searchKeyword%' LIMIT $offset, $rows_per_page";



    // Tutup koneksi
    $conn->close();
    ?>

</body>
</html>