<?php 

require_once("include.php");
/*

//mostrar usuario em determinado id
$root = new Usuario();
$root->getBYid(2);
echo $root;

//Lista usuario
$lista = Usuario::getList();
echo json_encode($lista);

//Filtrar
$search = Usuario::search('da');
echo json_encode($search);

//Logar usando dados corretos
$usuario_login = new Usuario();
$usuario_login->login("davi nicollas", "15978");
echo $usuario_login;

// update usuario
$aluno = new Usuario();
$aluno->getBYid(8);
$aluno->update('professor', 'wueiqieyqiueyqi');
echo $aluno;



//delete 
$aluno = new Usuario();
$aluno->getBYid(7);
$aluno->delete();
echo $aluno;

//insert
$aluno = new Usuario();
$aluno->setCad_name('davi nicollas pp');
$aluno->setCad_senha('12345432');
$aluno->insert();
*/
 
/*Excluir dados de dentro da pasta*/
?>
<!---<form method="POST" enctype="multipart/form-data">
  <input type="file" name="fileUpload">
  <button type="submit">Test</button>
</form> -->
<?php 
 $aluno = new Usuario();
 $aluno->getCookie();
?>