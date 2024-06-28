<?php
//conexão com o banco de dados
require 'config.php';


$id = filter_input(INPUT_GET ,'id', FILTER_SANITIZE_NUMBER_INT);
$nome = ucwords(strtolower(filter_input(INPUT_GET, 'nome', FILTER_SANITIZE_SPECIAL_CHARS)));
$permissoes = filter_input(INPUT_GET, 'permissoes', FILTER_SANITIZE_NUMBER_INT);

if($id && $nome && $permissoes){
        $sql = $pdo->prepare("UPDATE usuarios SET nome = ?, permissoes = ? WHERE id = ?");
        $sql->bindvalue(3,$id);
        $sql->bindvalue(1,$nome);
        $sql->bindvalue(2,$permissoes);
        $sql->execute();
        header("location: ../pages/usuarios.php");
        exit;

}else{
    header("location: ../pages/usuarios.php");
exit;


}


?>