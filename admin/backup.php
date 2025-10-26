<?php
session_start();
require_once '../app/core/Database.php';
require_once '../app/models/UserModel.php';

// Check authorization and admin rights
if (!isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit();
}

$userModel = new UserModel();
if (!$userModel->isAdmin($_SESSION['user_id'])) {
    header('Location: /profile.php');
    exit();
}

// Функция бэкапа
function createBackup() {
    try {
        $backupDir = __DIR__ . '/../backups/';

        // Create backups directory if not exists
        if (!is_dir($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $backupFile = $backupDir . 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $db = Database::getInstance()->getConnection();

        $backupContent = "-- MySQL Backup\n";
        $backupContent .= "-- Created: " . date('Y-m-d H:i:s') . "\n\n";

        // Получаем все таблицы
        $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            // Структура таблицы
            $backupContent .= "--\n-- Table structure for `$table`\n--\n";
            $createTable = $db->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
            $backupContent .= $createTable['Create Table'] . ";\n\n";

            // Данные таблицы
            $backupContent .= "--\n-- Data for `$table`\n--\n";
            $rows = $db->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $columns = [];
                $values = [];

                foreach ($row as $column => $value) {
                    $columns[] = "`$column`";
                    if ($value === null) {
                        $values[] = 'NULL';
                    } else {
                        $values[] = "'" . addslashes($value) . "'";
                    }
                }

                $backupContent .= "INSERT INTO `$table` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n";
            }
            $backupContent .= "\n";
        }

        // Сохраняем файл
        if (file_put_contents($backupFile, $backupContent)) {
            return true;
        }

        return false;

    } catch (Exception $e) {
        error_log("Backup error: " . $e->getMessage());
        return false;
    }
}

// Функция удаления бэкапа
function deleteBackup($fileName) {
    $backupDir = __DIR__ . '/../backups/';
    $filePath = $backupDir . $fileName;

    // Проверяем, что файл существует и это SQL файл бэкапа
    if (file_exists($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'sql' && strpos($fileName, 'backup_') === 0) {
        return unlink($filePath);
    }
    return false;
}

// АВТОМАТИЧЕСКИЙ БЭКАП ПРИ ЗАХОДЕ НА СТРАНИЦУ (1 раз в день)
$backupFlagFile = __DIR__ . '/../backups/last_backup.date';
$today = date('Y-m-d');

$autoBackupMessage = '';
$manualMessage = '';

// Проверяем, делали ли сегодня бэкап
if (!file_exists($backupFlagFile) || file_get_contents($backupFlagFile) !== $today) {
    if (createBackup()) {
        file_put_contents($backupFlagFile, $today);
        $autoBackupMessage = "✅ Automatic backup created for today (" . $today . ")";
    } else {
        $autoBackupMessage = "❌ Automatic backup failed";
    }
}

// Очистка старых бэкапов (больше 7 дней)
function cleanOldBackups() {
    $backupDir = __DIR__ . '/../backups/';
    if (!is_dir($backupDir)) return;

    $files = glob($backupDir . 'backup_*.sql');
    $keepTime = strtotime('-7 days');

    foreach ($files as $file) {
        if (filemtime($file) < $keepTime) {
            unlink($file);
        }
    }
}

cleanOldBackups();

// Обработка действий
if ($_POST) {
    // Ручное создание бэкапа
    if (isset($_POST['create_backup'])) {
        if (createBackup()) {
            file_put_contents($backupFlagFile, $today); // Обновляем дату
            $manualMessage = "✅ Manual backup created successfully!";
        } else {
            $manualMessage = "❌ Failed to create backup";
        }
    }

    // Удаление бэкапа
    if (isset($_POST['delete_backup'])) {
        $fileName = $_POST['file_name'] ?? '';
        if ($fileName && deleteBackup($fileName)) {
            $manualMessage = "✅ Backup '$fileName' deleted successfully!";
            // Перенаправляем на эту же страницу чтобы избежать повторной отправки формы
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            $manualMessage = "❌ Failed to delete backup";
        }
    }
}

// Получение списка бэкапов
function getBackups() {
    $backupDir = __DIR__ . '/../backups/';
    if (!is_dir($backupDir)) return [];

    $files = glob($backupDir . 'backup_*.sql');
    $backups = [];

    foreach ($files as $file) {
        if (filesize($file) > 0) { // Показываем только непустые файлы
            $backups[] = [
                'name' => basename($file),
                'size' => round(filesize($file) / 1024, 2) . ' KB',
                'date' => date('Y-m-d H:i:s', filemtime($file))
            ];
        }
    }

    // Сортируем по дате (новые сверху)
    usort($backups, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $backups;
}

$backups = getBackups();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Backup - NEWS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<?php include '../header.php'; ?>

<div class="admin-container">
    <aside class="admin-sidebar">
        <h2>Admin Panel</h2>
        <nav>
            <ul>
                <li><a href="/admin/">Dashboard</a></li>
                <li><a href="/admin/news/manage.php">Manage News</a></li>
                <li><a href="/admin/news/create.php">Create News</a></li>
                <li><a href="/admin/backup.php">Backup</a></li>
                <li><a href="/app/controller/logout.php">Logout</a></li>
            </ul>
        </nav>
    </aside>

    <main class="admin-main">
        <h1>Database Backup</h1>

        <!-- Авто-бэкап сообщение -->
        <?php if (!empty($autoBackupMessage)): ?>
            <div class="message <?php echo strpos($autoBackupMessage, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $autoBackupMessage; ?>
            </div>
        <?php endif; ?>

        <!-- Ручной бэкап сообщение -->
        <?php if (!empty($manualMessage)): ?>
            <div class="message <?php echo strpos($manualMessage, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $manualMessage; ?>
            </div>
        <?php endif; ?>

        <!-- Простая форма -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
            <h3>📦 Quick Backup</h3>
            <form method="POST">
                <button type="submit" name="create_backup" class="btn btn-primary">
                    Create Backup Now
                </button>
            </form>
            <p><small>Automatic backup created daily when you visit this page</small></p>
        </div>

        <!-- Список бэкапов -->
        <div style="background: #f8f9fa; padding: 20px; border-radius: 5px;">
            <h3>📋 Backup Files</h3>

            <?php if (empty($backups)): ?>
                <p>No backups yet. Create your first backup above.</p>
            <?php else: ?>
                <p>Found <?php echo count($backups); ?> backup file(s)</p>

                <?php foreach ($backups as $backup): ?>
                    <div class="backup-item">
                        <div class="backup-info">
                            <strong><?php echo $backup['name']; ?></strong><br>
                            <small>Size: <?php echo $backup['size']; ?> | Date: <?php echo $backup['date']; ?></small>
                        </div>
                        <div class="backup-actions">
                            <a href="/admin/download-backup.php?file=<?php echo urlencode($backup['name']); ?>"
                               class="btn btn-download">
                                Download
                            </a>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="file_name" value="<?php echo $backup['name']; ?>">
                                <button type="submit" name="delete_backup" class="btn btn-delete"
                                        onclick="return confirm('Are you sure you want to delete backup <?php echo $backup['name']; ?>?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php include '../footer.php'; ?>
</body>
</html>