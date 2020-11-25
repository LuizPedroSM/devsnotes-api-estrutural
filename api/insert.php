<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'post') {
    $title = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');
    if ($title && $body) {
        $sql = $pdo->prepare("INSERT INTO notes (title, body) VALUES (:title, :body)");
        $sql->bindValue(':title', $title);
        $sql->bindValue(':body', $body);
        $sql->execute();
        $id = $pdo->lastInsertId();
        if ($id) {
            $data['result'] = [
                'id' => $id,
                'title' => $title,
                'body' => $body
            ];
            http_response_code(201);
        } else {
            $data['error'] = 'Erro ao cadastrar';
            http_response_code(500);
        }
    } else {
        $data['error'] = 'Campos não foram enviados';
        http_response_code(400);
    }
} else {
    $data['error'] = 'Método não permitido (apenas GET)';
    http_response_code(405);
}
require('../return.php');