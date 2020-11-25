<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'put' || $method === 'options') {
    parse_str(file_get_contents('php://input'), $input);
    // $id = filter_var((!empty($input['id'])) ? $input['id'] : null, FILTER_VALIDATE_INT); //php 5.4
    $id = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT); // php 7.4
    $title = filter_var($input['title'] ?? null);
    $body = filter_var($input['body'] ?? null);

    if ($id && $title && $body) {
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $pdo->prepare("UPDATE notes SET title = :title, body = :body WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':title', $title);
            $sql->bindValue(':body', $body);
            $sql = $sql->execute();

            $data['result'] = [
                'id' => $id,
                'title' => $title,
                'body' => $body
            ];
        } else {
            $data['error'] = 'ID não existe';
            http_response_code(404);
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