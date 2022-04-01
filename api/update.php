<?php
require ('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put'){
    parse_str(file_get_contents('php://input'), $input);
    $id = $input['id'] ?? null;
    $title = $input['title'] ?? null;
    $body = $input['body'] ?? null;

    $id = filter_var($id);
    $title = filter_var($title);
    $body = filter_var($body);

    if($id && $title && $body){
        $sql =  $pdo->prepare("SELECT * FROM post WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $sql = $pdo->prepare("UPDATE post SET title = :title, body = :body WHERE id = :id");
            $sql->bindValue(':id',$id);
            $sql->bindValue('title',$title);
            $sql->bindValue('body', $body);
            $sql->execute();

            $array['result'] = [
                'id' => $id,
                'title' => $title,
                'body' => $body
            ];
            
        } else {
            $array['error'] = 'info user not exist';
        }
    } else {
        $array['error'] = 'Tem que enviar todas as informação(id, title and body)';
    }
} else {
    $array['error'] = 'Metodo não está correto, apenas PUT';
}
require ('../return.php');