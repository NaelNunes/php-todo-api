<?php

header("Content-Type: application/json");

$pdo = new PDO(
    "mysql:host=mysql;dbname=todo;charset=utf8",
    "root",
    "root"
);

$method = $_SERVER['REQUEST_METHOD'];

if ($method === "GET") {
    $stmt = $pdo->query("SELECT *FROM tasks");
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($tasks);
}