<?php 
class Config extends PDO {
    private $con;
    private $dsn = "mysql:host=localhost;dbname=udemy_php7";
    private $user = "root";
    private $senha = "";

    public function __construct(){
      $this->con = new PDO($this->dsn, $this->user ,$this->senha);
    }
    public function setParams($statment, $parameters = array()){
      foreach($parameters as $key => $value){
        $this->setParam($key, $value);
      }
    }
    public function setParam($statment, $key, $value){
        $statment->bindParam($key, $value);
    }
    public function query($rawQuery, $parameters = array()){
      $smt = $this->con->prepare($rawQuery);
      $this->setParams($smt , $parameters);
      $smt->execute();
      return $smt;
    }
    public function select($rawQuery , $parameters = array()):array{
      $smt = $this->query($rawQuery, $parameters );
      return $smt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>