<?php 

//Operações de "CRUD"
class UserService {

    private $conexao;
    private $usuario;

    //função construct para instanciar o objeto dinamicamente ao banco de dados com conexão PDO;
    public function __construct(Conexao $conexao, Usuario $usuario) {
        $this->conexao = $conexao->conectar();
        $this->usuario = $usuario;
    }

    public function inserir() { //create
        $query = 'insert into tb_usuarios(email, senha, nome, telefone, apartamento)values(:email, MD5(:senha), :nome, :telefone, :apartamento)'; //query para inserir registros através do painel de cadastro;
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':email', $this->usuario->__get('email'));
        $stmt->bindValue(':senha', $this->usuario->__get('senha'));
        $stmt->bindValue(':nome', $this->usuario->__get('nome'));
        $stmt->bindValue(':telefone', $this->usuario->__get('telefone'));
        $stmt->bindValue(':apartamento', $this->usuario->__get('apartamento'));
        $stmt->execute();
        
    }    
        

    public function recuperar() { //read
        $query = 'select ID, email, nome, telefone, apartamento, data_cadastro from tb_usuarios WHERE id_status = 2'; //status 2 = pendentes(esperando sindico aceitar);
        $stmt  = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    
    public function recuperarAtivos() { //read
        $query = 'select ID, email, nome, telefone, apartamento, data_cadastro from tb_usuarios WHERE id_status = 1'; //status 1 = ativos(cadastros ativos aceitos pelo sindico);
        $stmt  = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
    

    public function atualizar() { //update
        $query = 'update tb_usuarios set email = :email, nome = :nome, telefone = :telefone, apartamento = :apartamento WHERE tb_usuarios . ID = :id'; //query de alteração de cadastros;
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':email', $this->usuario->__get('email'));
        $stmt->bindValue(':nome', $this->usuario->__get('nome'));
        $stmt->bindValue(':telefone', $this->usuario->__get('telefone'));
        $stmt->bindValue(':apartamento', $this->usuario->__get('apartamento'));
        $stmt->bindValue(':id', $this->usuario->__get('id'));
        $stmt->execute();

    }
    
    public function excluir() { //delete (inativar)
        $query = 'update tb_usuarios set id_status = 3 where tb_usuarios .ID = :id'; //status 3 = inativo (excluido);
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $this->usuario->__get('id'));
        $stmt->execute();
    }

    public function rejeitar() { //rejeitar cadastro (inativar/rejeitar)
        $query = 'update tb_usuarios set id_status = 4 where tb_usuarios .ID = :id'; //status 4 = cadastro rejeitado (excluido) // status 4 para manter historico de pedido de cadastro;
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $this->usuario->__get('id'));
        $stmt->execute();
    }

    public function aceitar() { //aceitar cadastro (status 2 para status 1);
        $query = 'update tb_usuarios set id_status = 1 where tb_usuarios .ID = :id';
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':id', $this->usuario->__get('id'));
        $stmt->execute();
    }

    public function inserir_data() { //inserir data no banco de dados
        $query = 'insert into tb_salao (data_reserva, status_reserva) VALUES (:data, :status)'; //query para inserir registros através do painel de cadastro;
        $stmt = $this->conexao->prepare($query);
        $stmt->bindValue(':data', $this->usuario->__get('data'));
        $stmt->bindValue(':status', $this->usuario->__get('status'));
        $stmt->execute();
        
        // terminar retorno da data para marcar os dias já reservados ... 
    }

    public function recuperar_reservas() { //read
        $query = 'select data_reserva from tb_salao';
        $stmt  = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }


}    
        
        

        
        
        
        
    

    


?>