<?php 

require "../../harmony_privado/user-model.php";
require "../../harmony_privado/user-service.php";
require "../../harmony_privado/conexao.php";


//Cadastro baseado em parametros construct do OBJ model: (user-model.php + user-service.php) e usando a conexão PDO do OBJ model: (conexão.php).

$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao; //lógica para recuperar a variavel ação setada hard code nas paginas 

if($acao == 'inserir') {
    $usuario = new Usuario();
    $usuario->__set('email', $_POST['email']);
    $usuario->__set('senha', $_POST['senha']);
    $usuario->__set('nome', $_POST['nome']);
    $usuario->__set('telefone', $_POST['telefone']);
    $usuario->__set('apartamento', $_POST['apartamento']);

    $conexao = new Conexao();

    $userService = new UserService($conexao, $usuario);
    $userService->inserir();

} else if($acao == 'recuperar' && isset($_GET['pendentes']) ) { //logica para recuperar cadastros pendentes
    
    $usuario = new Usuario();
    $conexao = new Conexao();

    $userService = new UserService($conexao, $usuario);
    $impressao = $userService->recuperar();

} else if ($acao == 'recuperar' && isset($_GET['ativos'])) { //logica para recuperar cadastros ativos 
    
    $usuario = new Usuario();
    $conexao = new Conexao();

    $userService = new UserService($conexao, $usuario);
    $impressao = $userService->recuperarAtivos(); 

} else if ($acao == 'alterar') { //alteração do cadastro painel sindico cadastros pendentes para -> (cadastros ativos)
    
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $apartamento = $_POST['apartamento'];
    $id = $_POST['id'];

    $usuario = new Usuario();
    $conexao = new Conexao();

    $usuario->nome = $nome;
    $usuario->email = $email;
    $usuario->telefone = $telefone;
    $usuario->apartamento = $apartamento;
    $usuario->id = $id;

    $userService = new UserService($conexao, $usuario);
    $userService->atualizar();
    
    header('Location: painel_sindico_ativos.php?ativos');

} else if ($acao == 'excluir') { //logica para exclusão (inativar registro // status 3)
    
    $id = $_POST['id'];
    
    $usuario = new Usuario();
    $conexao = new Conexao();

    $usuario->id = $id;

    $userService = new UserService($conexao, $usuario);
    $userService->excluir();

    header('Location: painel_sindico_ativos.php?ativos');

} else if ($acao == 'rejeitar') { //logica para rejeitar cadastro (inativar registro // status 4)
    
    $id = $_POST['id'];
    
    $usuario = new Usuario();
    $conexao = new Conexao();

    $usuario->id = $id;

    $userService = new UserService($conexao, $usuario);
    $userService->rejeitar();

    header('Location: painel_sindico_ativos.php?pendentes');

}   else if ($acao == 'aceitar') { //logica para rejeitar cadastro (inativar registro // status 4)
    
    $id = $_POST['id'];
    
    $usuario = new Usuario();
    $conexao = new Conexao();

    $usuario->id = $id;

    $userService = new UserService($conexao, $usuario);
    $userService->aceitar();

    header('Location: painel_sindico_ativos.php?ativos');

} else if($acao == 'inserir_data') {
    $iddia = $_POST['iddias'];
    $idmorador = $_POST['idmorador'];
    $data = $_POST['iddate'];
    $status = 2;

    $usuario = new Usuario();
    $conexao = new Conexao();
    
    $usuario->status = $status;
    $usuario->data = $data;
    
    $userService = new UserService($conexao, $usuario);
    $userService->inserir_data();

    header('Location: painel_morador.php?'.$data.$iddia);

    // terminar retorno da data para marcar os dias já reservados ... 
} else if($acao == 'recuperar_reservas') { //logica para recuperar cadastros pendentes
    
    $usuario = new Usuario();
    $conexao = new Conexao();

    $userService = new UserService($conexao, $usuario);
    $impressao = $userService->recuperar_reservas();

}


    
    
?>



