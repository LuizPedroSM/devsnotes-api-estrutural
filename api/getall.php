<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'get') {
    $sql = $pdo->query("SELECT * FROM notes");
    if ($sql) {
        $info = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($info as $item) {
            $data['result'][] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'body' => $item['body']
            ];
        }
    } else {
        $data['error'] = 'Erro ao requisitar os dados do Banco';
        http_response_code(500);
    }
} else {
    http_response_code(405);
    $data['error'] = 'Método não permitido (apenas GET)';
}
require('../return.php');