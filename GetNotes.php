<?php
// Konfiguracja bazy danych
$db_host = 'mysql1.ugu.pl';
$db_name = 'db700414';
$db_user = 'db700414';
$db_pass = 'Kotkotkot3';

try {
    // Połączenie z bazą danych
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]));
}

// Obsługa formularza
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['content'])) {
    $content = trim($_POST['content']);
    $stmt = $pdo->prepare("INSERT INTO Notatnik (CONTENT, TIME) VALUES (:content, NOW())");
    $stmt->bindParam(':content', $content);
    
    if ($stmt->execute()) {
        echo "<p>Notatka została dodana!</p>";
    } else {
        echo "<p>Błąd przy dodawaniu notatki.</p>";
    }
}

// Pobranie listy notatek
$stmt = $pdo->prepare("SELECT ID, CONTENT, TIME FROM Notatnik ORDER BY TIME DESC, ID DESC");
$stmt->execute();
$notatki = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>4PGS - 4 Players Game Studio</title>
</head>
<body>

<h2>Dodaj nową notatkę</h2>
<form method="post">
    <textarea name="content" rows="4" cols="50" required></textarea><br>
    <button type="submit">Dodaj notatkę</button>
</form>

<h2>Lista notatek</h2>
<table border='1' cellspacing='0' cellpadding='5'>
    <tr><th>ID</th><th>Treść</th><th>Czas</th></tr>
    <?php foreach ($notatki as $notatka): ?>
        <tr>
            <td><?= htmlspecialchars($notatka['ID']) ?></td>
            <td><?= nl2br(htmlspecialchars($notatka['CONTENT'])) ?></td>
            <td><?= htmlspecialchars($notatka['TIME']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
