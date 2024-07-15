<?php
header("Content-Type: application/json");

require 'database.php';
require 'functions.php';

$method = $_SERVER['REQUEST_METHOD'];
$request_uri = $_SERVER['REQUEST_URI'];
$script_name = $_SERVER['SCRIPT_NAME'];

// Extrahiere den Pfad von der URI
$path = str_replace($script_name, '', $request_uri);
$request = explode('/', trim($path, '/'));

// Stelle sicher, dass die ID korrekt extrahiert wird
$id = isset($request[0]) ? (int)$request[0] : null;

switch($method) {
    case 'GET':
        if($id) {
            getUser($id);
        } else {
            getUsers();
        }
        break;
    case 'POST':
        addUser();
        break;
    case 'PUT':
        if($id) {
            updateUser($id);
        }
        break;
    case 'DELETE':
        if($id) {
            deleteUser($id);
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}
?>
