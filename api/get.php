<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'get') {
    $id = filter_input(INPUT_GET, 'id');
    if ($id) {
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $info = $sql->fetch(PDO::FETCH_ASSOC);

            $data['result'] = [
                'id' => $info['id'],
                'title' => $info['title'],
                'body' => $info['body']
            ];
        } else {
            http_response_code(404);
            $data['error'] = 'ID não existe';
        }
    } else {
        http_response_code(400);
        $data['error'] = 'ID não enviado';
    }
} else {
    http_response_code(405);
    $data['error'] = 'Método não permitido (apenas GET)';
}
require('../return.php');