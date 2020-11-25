<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'delete') {
    parse_str(file_get_contents('php://input'), $input);
    // $id = filter_var((!empty($input['id'])) ? $input['id'] : null, FILTER_VALIDATE_INT); //php 5.4
    $id = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT); // php 7.4

    if ($id) {
        $sql = $pdo->prepare("SELECT * FROM notes WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            $sql = $pdo->prepare("DELETE FROM notes WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            http_response_code(204);
        } else {
            $data['error'] = 'ID não existe';
            http_response_code(404);
        }
    } else {
        $data['error'] = 'ID não foi enviado';
        http_response_code(400);
    }
} else {
    $data['error'] = 'Método não permitido (apenas DELETE)';
    http_response_code(405);
}
require('../return.php');