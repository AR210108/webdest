<?php
session_start();
include('../prosses/koneksi.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT kelas, name FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$kelas = $user['kelas'];
$user_name = $user['name'];
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $description = $_POST['description'];
    $waktu_kejadian = $_POST['waktu_kejadian'];
    $anonim = isset($_POST['anonim']) ? 1 : 0;

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $target_dir = "../upload/"; 
        $foto_name = time() . '_' . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto_name;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $foto = $foto_name;
            } else {
                echo "Terjadi kesalahan saat mengunggah file.";
                exit();
            }
        } else {
            echo "File yang diunggah bukan gambar.";
            exit();
        }
    }

    $status = 'Menunggu Ditanggapi';

    $stmt = $conn->prepare("INSERT INTO reports (judul, description, foto, status, user_name, user_id, waktu_kejadian, anonim) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $judul, $description, $foto, $status, $user_name, $user_id, $waktu_kejadian, $anonim);

    if ($stmt->execute()) {
        header("Location: home.php");
        exit();
    } else {
        echo "Terjadi kesalahan: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report - Formulir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/formulir.css">
    <link href="../img/MyReport-logo-RVB-couleurs-grand.png" rel="shortcut icon">
</head>
<body>
    <div class="navbar">
        <img src="../img/MyReport-logo-RVB-couleurs-grand.png" alt="My Report Logo" class="navbar-logo">
    </div>

    <div class="form-container">
        <h2>Laporkan Pengaduan</h2>
        
        <p><strong>Silakan isi formulir di bawah ini untuk melaporkan pengaduan Anda.</strong></p>
        
        <form method="POST" action="formulir.php" enctype="multipart/form-data">
            <input type="text" name="kelas" placeholder="Kelas" value="<?php echo htmlspecialchars($kelas); ?>" readonly>
            <input type="text" name="judul" placeholder="Judul Masalah" required>
            <textarea class="description-field" name="description" placeholder="Deskripsi Kejadian" required></textarea>
            <div class="input-group">
                <label for="waktu-kejadian" class="date-label">
                    <span class="icon">📅</span>
                    <input type="date" id="waktu-kejadian" class="input-field" name="waktu_kejadian" required>
                </label>
            </div>

            <div class="input-group">
                <label for="upload-foto" class="file-label">
                    <span class="icon">📷</span>
                    <input type="file" id="upload-foto" class="input-field" name="foto" accept="image/*">
                </label>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="anonim" name="anonim">
                <label for="anonim">Kirim sebagai anonim</label>
            </div>

            <button type="submit" class="submit-btn">Kirim</button>
        </form>
    </div>
</body>
</html>
