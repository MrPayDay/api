<?php
// Setzt den Content-Type Header auf JSON, damit der Client weiß, dass die Antwort im JSON-Format ist.
header("Content-Type: application/json");

// Importiert die notwendigen Dateien für die Datenbankverbindung und zusätzliche Funktionen.
require 'database.php';
require 'functions.php';

// Liest die HTTP-Methode der aktuellen Anfrage (z.B. GET, POST, PUT, DELETE).
$method = $_SERVER['REQUEST_METHOD'];

// Liest die URI der aktuellen Anfrage.
$request_uri = $_SERVER['REQUEST_URI'];

// Liest den Namen des aktuell ausgeführten Scripts.
$script_name = $_SERVER['SCRIPT_NAME'];

// Extrahiert den Pfad von der URI, indem der Scriptname entfernt wird.
$path = str_replace($script_name, '', $request_uri);

// Zerlegt den extrahierten Pfad in einzelne Teile, die durch '/' getrennt sind.
$request = explode('/', trim($path, '/'));

// Stellt sicher, dass die ID korrekt extrahiert wird, falls sie vorhanden ist, und konvertiert sie in einen ganzzahligen Wert.
$id = isset($request[0]) ? (int)$request[0] : null;

// Switch-Anweisung, die je nach HTTP-Methode unterschiedliche Funktionen aufruft.
switch($method) {
    case 'GET':
        // Wenn die Methode GET ist und eine ID vorhanden ist, rufe die Funktion getUser() mit der ID auf.
        if($id) {
            getUser($pdo, $id);
        } else {
            // Wenn keine ID vorhanden ist, rufe die Funktion getUsers() auf.
            getUsers($pdo);
        }
        break;
    case 'POST':
        // Wenn die Methode POST ist, rufe die Funktion addUser() auf.
        addUser($pdo);
        break;
    case 'PUT':
        // Wenn die Methode PUT ist und eine ID vorhanden ist, rufe die Funktion updateUser() mit der ID auf.
        if($id) {
            updateUser($pdo, $id);
        }
        break;
    case 'DELETE':
        // Wenn die Methode DELETE ist und eine ID vorhanden ist, rufe die Funktion deleteUser() mit der ID auf.
        if($id) {
            deleteUser($pdo, $id);
        }
        break;
    default:
        // Wenn eine andere Methode verwendet wird, setze den HTTP-Statuscode auf 405 (Method Not Allowed) und gebe eine Fehlermeldung zurück.
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}
?>