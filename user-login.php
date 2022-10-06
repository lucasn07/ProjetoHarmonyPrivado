<?php 
session_start();
if(empty($_POST['email']) || empty($_POST['senha'])) {
  //preciso fazer uma impressão na tela mais pra frente para informar que o usuario precisa inserir dados. 
  echo 'Erro :(';
  header('Location: login.php');
  exit();
}
  
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  
  $dsn = 'mysql:host=localhost; dbname=bd_harmony';
  $bd_login = 'root';
  $bd_pass = '';
  
  $conexao = new PDO($dsn, $bd_login, $bd_pass);
  
 
  //query tratada com prepare para validação de email / senha / e id acesso para redirecionamento tratado.
  $query = "select email, senha, id_acesso, ID FROM tb_usuarios WHERE email = :email AND senha = MD5(:senha) AND id_acesso";
  
  $stmt = $conexao->prepare($query);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':senha', $senha);
  $stmt->execute();
  
  $verifica_login = $stmt->fetch(PDO::FETCH_OBJ);
  print_r($verifica_login);
  
  //redirecionamento de acordo com id acesso especifico de cada login. 
  if($verifica_login == !null && $verifica_login->id_acesso == '1' ) {
    $_SESSION['morador'] = $verifica_login->ID;
    header('Location: painel_morador.php');
  
  } else if($verifica_login == !null && $verifica_login->id_acesso == '2') {
    $_SESSION['porteiro'] = $verifica_login->ID;
    header('Location: painel_porteiro.php');
    
  
  } else if($verifica_login == !null && $verifica_login->id_acesso == '3') {
    $_SESSION['sindico'] = $verifica_login->ID;
    header('Location: painel_sindico.php?pendentes');
    
    
  } else {
    //mais pra frente preciso fazer uma impressão na tela avisando que login ou senha estão invalidos.
    header('Location: login.php#auth=0');
    exit();
  }

?>  
  
  
  
  
   
  
     
  












  
  
  




  

  
 


  

