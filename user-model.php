<?php 
//modelo de OBJ usuario para recebimentos de dados via POST.
class Usuario {
    private $ID;
    private $id_status = 2 ; //status 1,2 (Default = 2 (pendente))
    private $id_acesso = 1; //acessos 1, 2, 3 (Default = 1 (morador))
    private $email;
    private $senha;
    private $nome;
    private $telefone;
    private $apartamento;
    private $data_cadastro;

    public function __set($atributo, $valor) {
        $this->$atributo = $valor;

    }
    

    public function __get($atributo) {
        return $this->$atributo;
    }

}

?>