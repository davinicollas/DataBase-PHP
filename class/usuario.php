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
      $row  =  $results[0];
      $this->setId($row['id']);
      $this->setCad_registro(new DateTime($row['cad_registro']));
      $this->setCad_senha($row['cad_senha']);
      $this->setCad_name($row['cad_name']);
    }
  }
  public function __toString(){
    return json_encode(array(
      "id"=>$this->getId(),
      "cad_name"=>$this->getCad_name(),
      "cad_senha"=>$this->getCad_senha(),
      "cad_registro"=>$this->getCad_registro()->format("d/m/Y H:i:s"),
    ));
  }
 }
?>