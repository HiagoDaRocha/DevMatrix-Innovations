<?php
//conexão com o banco de dados
require 'config.php';


$id = filter_input(INPUT_GET ,'id');
$nome = ucwords(strtolower(filter_input(INPUT_GET, 'nome')));
$permissoes = filter_input(INPUT_GET, 'permissoes');

if($id && $nome && $permissoes){
        $sql = $pdo->prepare("UPDATE usuarios SET nome = ?, permissoes = ? WHERE id = ?");
        $sql->bindvalue(3,$id);
        $sql->bindvalue(1,$nome);
        $sql->bindvalue(2,$permissoes);
        $sql->execute();
        header("location: ../php/php_testes/index.php");
        exit;

}else{
    header("location: ../php/php_testes/index.php");
exit;


}


?>