<?php

function getUsers() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM data');
    $users = $stmt->fetchAll();
    echo json_encode($users);
}

function getUser($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM data WHERE id = ?');
    $stmt->execute([$id]);
    $user = $stmt->fetch();
    echo json_encode($user);
}

function addUser() {
    global $pdo;
    $input = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare('INSERT INTO data (name, age ,email) VALUES (?, ?, ?)');
    $stmt->execute([$input['name'], $input['age'], $input['email']]);
    echo json_encode(["id" => $pdo->lastInsertId()]);
}

function updateUser($id) {
    global $pdo;
    $input = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare('UPDATE data SET name = ?, age = ?, email = ? WHERE id = ?');
    $stmt->execute([$input['name'], $input['age'], $input['email'], $id]);
    echo json_encode(["message" => "User updated"]);
}

function deleteUser($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM data WHERE id = ?');
    $stmt->execute([$id]);
    echo json_encode(["message" => "User deleted"]);
}
?>
