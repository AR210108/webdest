<?php
include('koneksi.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Rindawebdes/register1/login.php");
    exit();
}

$user_id = $_SESSION['user_id']; 

$result = $conn->query("SELECT reports.*, users.foto AS user_foto FROM reports JOIN users ON reports.user_name = users.name WHERE reports.anonim = 0");

if ($result === false) {
    echo "Error: " . $conn->error;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $report_id = $_POST['report_id'];
    $action = $_POST['action'];

    $interaction_check = $conn->query("SELECT * FROM report_interactions WHERE user_id = $user_id AND report_id = $report_id AND action = '$action'");

    if ($interaction_check->num_rows > 0) {

        $conn->query("DELETE FROM report_interactions WHERE user_id = $user_id AND report_id = $report_id AND action = '$action'");
        if ($action === 'like') {
            $conn->query("UPDATE reports SET likes = likes - 1 WHERE id = $report_id");
        } elseif ($action === 'dislike') {
            $conn->query("UPDATE reports SET dislikes = dislikes - 1 WHERE id = $report_id");
        }
    } else {
        
        $conn->query("INSERT INTO report_interactions (user_id, report_id, action) VALUES ($user_id, $report_id, '$action')");
        if ($action === 'like') {
            $conn->query("UPDATE reports SET likes = likes + 1 WHERE id = $report_id");
        } elseif ($action === 'dislike') {
            $conn->query("UPDATE reports SET dislikes = dislikes + 1 WHERE id = $report_id");
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Report - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/home.css">
    <link href="../img/MyReport-logo-RVB-couleurs-grand.png" rel="shortcut icon">
</head>
<body>
    <div class="navbar">
        <img src="../img/MyReport-logo-RVB-couleurs-grand.png" alt="My Report Logo" class="navbar-logo">
    </div>

    <div class="post-container">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <div class="post-header">
                    <img src="<?php echo htmlspecialchars($row['user_foto'] ? $row['user_foto'] : '../img/default.png'); ?>" alt="Profile" class="profile-pic">
                    <div class="post-info">
                        <h3><?php echo htmlspecialchars($row['user_name']); ?></h3>
                        <span><?php echo $row['anonim'] ? 'Anonim' : 'Public'; ?></span>
                    </div>
                </div>
                <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <?php if ($row['foto']): ?>
    <img src="<?php echo htmlspecialchars('../upload/' . $row['foto']); ?>" alt="Incident image" class="post-image">
<?php endif; ?>
                <div class="post-status" style="color: <?php echo ($row['status'] == 'Selesai') ? 'green' : (($row['status'] == 'Sedang ditindaklanjuti') ? 'orange' : 'green'); ?>;">
                    <?php echo htmlspecialchars($row['status']); ?>
                </div>
                <div class="post-actions">
                    <form method="POST">
                        <input type="hidden" name="report_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="action" value="like" class="like-btn">
                            👍 <?php echo $row['likes']; ?>
                        </button>
                        <button type="submit" name="action" value="dislike" class="dislike-btn">
                            👎 <?php echo $row['dislikes']; ?>
                        </button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <a href="formulir.php" class="add-btn">+</a>
    
    <div class="bottom-nav">
        <a href="home.php" class="nav-item">
            <i class="fas fa-home"></i>
        </a>
        <a href="myreport.php" class="nav-item">
            <i class="fas fa-file-alt"></i>
        </a>
        <a href="profile.php" class="nav-item">
            <i class="fas fa-user"></i>
        </a>
    </div>
</body>
</html>
