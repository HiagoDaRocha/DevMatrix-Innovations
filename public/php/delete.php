<?php
//conexão com o banco de dados
require 'config.php';

$id = filter_input(INPUT_GET, 'id');

    if($id){
        
        $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        $sql->bindvalue(1,$id);
        $sql->execute();
        header("location: ../pages/usuarios.php");
        exit;

}else{
    header("location: ../pages/usuarios.php");


}




?>