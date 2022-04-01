<?php
require ('../config.php');
$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'delete'){
    parse_str(file_get_contents('php://input'), $input);

    $id = filter_var($input['id'] ?? null);
    if($id){
        $sql =  $pdo->prepare("DELETE FROM post WHERE id = :id");
        $sql->bindValue('id', $id);
        $sql->execute();
    } else {
        $array['error'] = 'id not info';
    }

} else {
    $array['error'] = 'Method send not is ok, access DELETE';
}
require('../return.php');