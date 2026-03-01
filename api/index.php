<?php

header("Content-Type: application/json");

$pdo = new PDO(
    "mysql:host=mysql;dbname=todo;charset=utf8",
    "root",
    "root"
);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {

    $id = $_GET['id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
        $stmt->execute([$id]);
        $task = $stmt->fetch(PDO::FETCH_ASSOC);

        echo json_encode($task ?: ["message" => "Task nao encontrada"]); 
    } else {
        $stmt = $pdo->query("SELECT * FROM tasks");
        echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); 
    }

    
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks);
}

if ($method === "POST") {
    
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare(
        "INSERT INTO tasks (titulo, descricao) VALUES (?, ?)"
    );

    $stmt->execute([
        $data['titulo'],
        $data['descricao']
    ]);

    echo json_encode(["message" => "Task criada"]);
}