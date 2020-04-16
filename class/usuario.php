<?php 
 class Usuario {
  private $id;
  private $cad_name;
  private $cad_senha;
  private $cad_registro;  
  public function getCad_registro()
  {
    return $this->cad_registro;
  }
  public function setCad_registro($cad_registro)
  {
    $this->cad_registro = $cad_registro;
  }
  public function getCad_senha()
  {
    return $this->cad_senha;
  }
  public function setCad_senha($cad_senha)
  {
    $this->cad_senha = $cad_senha;
  }
  public function getCad_name()
  {
    return $this->cad_name;
  }
  public function setCad_name($cad_name)
  {
    $this->cad_name = $cad_name;
  }
  public function getId()
  {
    return $this->id;
  }
  public function setId($id)
  {
    $this->id = $id;
  }
  public function getBYid($id){
    $sql =  new Config();
    $results =  $sql->select("SELECT * FROM cad_usuario where id = :ID", array(":ID"=>$id));
    if(count($results) > 0 ){
      $this->Setdata($results[0]);
    }
  }
  public static function getList(){
    $sql = new Config();
    return $sql->select("SELECT * FROM cad_usuario ORDER BY cad_name");
  }
  public static function search($login){
    $sql = new Config();
    return $sql->select("SELECT * FROM cad_usuario where cad_name LIKE :SEARCH  ORDER BY cad_name", array(
      ':SEARCH'=>"%".$login."%"
    ));
  }
  public function login($login, $password){
    $sql = new Config();
    $results = $sql->select("SELECT * FROM cad_usuario where cad_name = :LOGIN AND cad_senha = :PASSWORD ", array(
      ':LOGIN'=>$login,
      ':PASSWORD'=> $password));
    if(count($results) > 0 ){
      $this->Setdata($results[0]);
  }else{
    throw new Exception("Login ou senha invalida"); 
  }
}
public function Setdata($data){
  $this->setId($data['id']);
  $this->setCad_registro(new DateTime($data['cad_registro']));
  $this->setCad_senha($data['cad_senha']);
  $this->setCad_name($data['cad_name']);
}
public function insert(){
  $sql = new Config();
  $results = $sql->select("INSERT INTO cad_usuario (cad_name, cad_senha)
  VALUES (:LOGIN ,:PASSWORD )", array(':LOGIN'=>$this->getCad_name(),
   ':PASSWORD' =>$this->getCad_senha()
  ));
  if(count($results)>0){
    $this->Setdata($results[0]);
  }
}
public function update($login , $password){
  $this->setCad_name($login);
  $this->getCad_senha($password);
  $sql = new Config();
  $sql->query("UPDATE cad_usuario SET cad_name = :LOGIN, cad_senha = :PASSWORD WHERE id = :ID" , array(     ':LOGIN'=>$this->getCad_name(),
    ':PASSWORD' =>$this->getCad_senha(),
    ':ID'=>$this->getId()
  ));
}
  public function __toString(){
    return json_encode(array(
      "id"=>$this->getId(),
      "cad_name"=>$this->getCad_name(),
      "cad_senha"=>$this->getCad_senha(),
      "cad_registro"=>$this->getCad_registro()->format('Y-m-d H:i:s'),
    ));
  }
 }
?>