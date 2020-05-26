<!--INSTANCIAR A CLASSE usuarios.php-->
  <?php
    require_once 'CLASSES/usuarios.php'; 
    $u = new Usuario;
  ?>
<!--FIM-->
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <title>Projeto Login </title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
  <body>
  <div id="corpo-form-cadastrar">
    <h1>Cadastrar</h1>
      <form method="POST">
      <input type="text" name="nome" placeholder="Nome Completo"maxlength="30">
      <input type="text" name="telefone" placeholder="Telefone" maxlength="30">
        <input type="email" name="email" placeholder="usuário" maxlength="40">
        <input type="password" name="senha" placehoder="Digite a Senha" maxlength="15">
        <input type="password" name="confirmarSenha" placehoder="Confirmar Senha">
        <input type="submit"value="Cadastrar">
      </form>
    </div>
    <?php
    if(isset($_POST['nome'])) // verifica se vem atribrutos
    {
          $nome = addslashes($_POST['nome']); //[addslashes]<< previni que hacks envienm comando
          $telefone = addslashes($_POST['telefone']);
          $email = addslashes($_POST['email']);
          $senha = addslashes($_POST['senha']);
          $confirmarSenha = addslashes($_POST['confirmarSenha']);
          //ferifica se nao esta vazio
          if(!empty($nome) && !empty($telefone) && !empty($email) && !empty($senha) && !empty($confirmarSenha))
        {
          $u->conectar("projeto_login","localhost","root","");
            if($u->msgErro == "")//verifica se nao tem erro
            {
              if($senha == $confirmarSenha)
              {
                if($u->cadastrar($nome, $telefone, $email, $senha))
                {
                  echo "cadastrado com sucesso";
                }
                else
                {
                  echo "email já cadastrado!";
                }
              }
              else
              {
              echo "Senhas nao correspondem!";
                }
            }
            else
            {
              echo "Erro" .$u->msgErro;//enviar o erro
            } 
          }
          else
        {
            echo "Preencha todos os campos!";
      }
    }
   ?>
  </body>
</html>
