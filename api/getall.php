<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method === 'get') {
    $sql = $pdo->query("SELECT * FROM notes");
    if ($sql->rowCount() > 0) {
        $info = $sql->fetchAll(PDO::FETCH_ASSOC);

        foreach ($info as $item) {
            $data['result'][] = [
                'id' => $item['id'],
                'title' => $item['title'],
                'body' => $item['body']
            ];
        }
    }
} else {
    http_response_code(405);
    $data['error'] = 'Método não permitido (apenas GET)';
}
require('../return.php');