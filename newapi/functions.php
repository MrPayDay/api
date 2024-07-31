<?php

// Funktion, um alle Benutzer aus der Datenbank abzurufen
function getUsers($pdo) {
    $stmt = $pdo->query('SELECT * FROM data');  // SQL-Abfrage, um alle Datensätze aus der Tabelle 'data' abzurufen
    $users = $stmt->fetchAll();  // Alle Ergebnisse der Abfrage werden in ein Array umgewandelt
    echo json_encode($users);  // Konvertiert das Array in JSON und gibt es aus
}

// Funktion, um einen einzelnen Benutzer anhand der ID abzurufen
function getUser($pdo, $id) {
    $stmt = $pdo->prepare('SELECT * FROM data WHERE id = ?');  // Vorbereitete SQL-Abfrage, um einen Benutzer nach ID abzurufen
    $stmt->execute([$id]);  // Führt die Abfrage aus und bindet die ID an die Abfrage
    $user = $stmt->fetch();  // Holt das Ergebnis der Abfrage
    echo json_encode($user);  // Konvertiert das Ergebnis in JSON und gibt es aus
}

// Funktion, um einen neuen Benutzer hinzuzufügen
function addUser($pdo) {
    $input = json_decode(file_get_contents('php://input'), true);  // Liest die JSON-Daten aus der Anfrage und dekodiert sie
    if (json_last_error() !== JSON_ERROR_NONE) {  // Überprüft, ob ein JSON-Dekodierungsfehler aufgetreten ist
        echo json_encode(['error' => 'Invalid JSON data']);  // Gibt eine Fehlermeldung im JSON-Format aus
        exit;  // Beendet die Ausführung des Skripts
    }
    // Vorbereitete SQL-Abfrage, um einen neuen Benutzer in die Tabelle 'data' einzufügen
    $stmt = $pdo->prepare('INSERT INTO data (name, age, email) VALUES (?, ?, ?)');
    $stmt->execute([$input['name'], $input['age'], $input['email']]);  // Führt die Abfrage aus und bindet die Daten an die Abfrage
    echo json_encode(["id" => $pdo->lastInsertId()]);  // Gibt die ID des neu eingefügten Datensatzes im JSON-Format aus
}

// Funktion, um einen bestehenden Benutzer zu aktualisieren
function updateUser($pdo, $id) {
    $input = json_decode(file_get_contents('php://input'), true);  // Liest die JSON-Daten aus der Anfrage und dekodiert sie
    // Vorbereitete SQL-Abfrage, um einen bestehenden Benutzer in der Tabelle 'data' zu aktualisieren
    $stmt = $pdo->prepare('UPDATE data SET name = ?, age = ?, email = ? WHERE id = ?');
    $stmt->execute([$input['name'], $input['age'], $input['email'], $id]);  // Führt die Abfrage aus und bindet die Daten an die Abfrage
    echo json_encode(["message" => "User updated"]);  // Gibt eine Bestätigungsmeldung im JSON-Format aus
}

// Funktion, um einen Benutzer zu löschen
function deleteUser($pdo, $id) {
    $stmt = $pdo->prepare('DELETE FROM data WHERE id = ?');  // Vorbereitete SQL-Abfrage, um einen Benutzer nach ID zu löschen
    $stmt->execute([$id]);  // Führt die Abfrage aus und bindet die ID an die Abfrage
    echo json_encode(["message" => "User deleted"]);  // Gibt eine Bestätigungsmeldung im JSON-Format aus
}
?>
