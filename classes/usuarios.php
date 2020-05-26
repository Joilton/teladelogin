<?php
  class Usuario
  {
    private $pdo;
    public $msgErro = "";

    //METODO PARA CONECTAR COM O BANCO DE DADOS
      public function conectar($nome, $host, $usuario, $senha)
      {
        global $pdo;
        try
        {/*para tratar os erros */
        $pdo = new PDO("mysql:dbname".$nome.";host=".$host,$usuario,$senha);
        }catch(PDOException $e){
          $msgErro = $e->getMessage(); /*capiturar os nessa variavel */
        }
      }
    //FIM

    //METODO PARA CADASTRAR USUARIO
      public function cadastrar($nome, $telefone, $email, $senha)
      {
        global $pdo;
        //Verificar se ja tem email cadastrado no banco de dados
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e");
        //bindValue faz a substituição e por email
        $sql -> bindValue(":e",$email);
        //executar o comando
        $sql->execute();
        if($sql->rowCount()>0)//rowCount conta as linhas do bd
        {
          return false; //ja esta cadastradada
        }
        else
        {
          //Caso nao  cadastrar
          $sql = $pdo->prepare("INSERT INT0 usuarios(nome, telefone, email, senha)
          VALUE(:n, :t, :e, :s)");
          $sql -> bindValue(":n",$nome);
          $sql -> bindValue(":t",$telefone);
          $sql -> bindValue(":e",$email);
          $sql -> bindValue(":s",md5($senha));
          $sql->execute();
          return true;
        }
      }
    //FIM

    //METODO LOGAR  
      public function logar($email, $senha)
      {
        global $pdo;
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios 
        WHERE email = :e AND senha = :s");
        $sql -> bindValue(":e",$email);
        $sql -> bindValue(":s",md5($senha));
        $sql->execute();
        if($sql->rowCount()>0)
        {
          //entrar no sistema (sessao) (pegar o id e quardar,transforma a informacao em uma array)
          $dado = $sql->fetch();//tranforma tudo em array
          session_start();
          $_SESSION['id_usuario'] = $dado['id_usuario'];
          return true; //logado com sucesso
        }
        else
        {
        return false; //nao foi possivel logar
        }
      }
    //FIM
  }
?>