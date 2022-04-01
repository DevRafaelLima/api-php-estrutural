<?php
require ('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);
if($method === 'get'){
    $id = filter_input(INPUT_GET, 'id');

    if($id){
        $sql = $pdo->prepare("SELECT * FROM post WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            $array['result'] = [
                'id' => $data['id'],
                'title' => $data['title'],
                'boby' => $data['body']
            ];
        } else {
            $array['error'] = 'ID n existe na base de dados';
        }

    } else {
        $array['error'] = 'ID n enviado';
    }
} else {
    $array['error'] = 'Metodo invalido, aceita-se apenas metodos GET';
}

require ('../return.php');