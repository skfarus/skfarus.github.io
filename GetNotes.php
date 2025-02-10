<?php
//File for PHP/MySQL website
// Konfiguracja bazy danych
$db_host = 'mysql1.ugu.pl'; // Adres serwera bazy danych
$db_name = 'db700414'; // Nazwa bazy danych
$db_user = 'db700414'; // Użytkownik MySQL
$db_pass = 'Kotkotkot3'; // Hasło do MySQL

try {
    // Połączenie z bazą danych
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()]));
}

    // Pobranie listy klientów
    $stmt = $pdo->prepare("SELECT ID, CONTENT, TIME FROM Notatnik ORDER BY TIME, ID DESC");
    $stmt->execute();
    $notatki = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo '<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>4PGS - 4 Players Game Studio</title>
</head>
<body>';
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr><th>ID</th><th>Treść</th><th>Czas</th></tr>";

    foreach ($notatki as $notatka) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($notatka['ID']) . "</td>";
        echo "<td>" . nl2br(htmlspecialchars($notatka['CONTENT'])) . "</td>";
        echo "<td>" . htmlspecialchars($notatka['TIME']) . "</td>";
        echo "</tr>";
    }

    echo "</table>
</body>
</html>";
?>