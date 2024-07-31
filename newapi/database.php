<?php
// Definiert die Datenbankverbindungsparameter
$host = "127.0.0.1";   // Datenbank-Host (z.B. localhost)
$db = "API_DATA";      // Name der Datenbank
$user = "root";        // Datenbank-Benutzername
$pass = "";            // Datenbank-Passwort
$charset = 'utf8mb4';  // Zeichensatz, der verwendet werden soll

// Erzeugt den Data Source Name (DSN) für die PDO-Verbindung
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Versucht, eine neue PDO-Verbindung zur Datenbank herzustellen
    $pdo = new PDO($dsn, $user, $pass);
    // Setzt den Fehlermodus der PDO-Instanz auf Exception, damit Fehler geworfen werden
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    // Fängt eine PDOException, wenn die Verbindung fehlschlägt, und wirft eine neue Ausnahme mit der Fehlermeldung und dem Fehlercode
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
