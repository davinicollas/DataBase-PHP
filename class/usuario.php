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
    $results = $sql->select("SELECT * FROM cad_usuario where cad_name = :LOGIN AND cad_senha = :PASSWORD ", array(':LOGIN'=>$login,':PASSWORD'=> $password));
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
    $sql->query("UPDATE cad_usuario SET cad_name = :LOGIN, cad_senha = :PASSWORD WHERE id = :ID" , array(  ':LOGIN'=>$this->getCad_name(),
     ':PASSWORD' =>$this->getCad_senha(),
     ':ID'=>$this->getId()
    ));
  }
  public function delete(){
    $sql = new Config();
    $sql->query("DELETE FROM cad_usuario WHERE id = :ID",array(
    ':ID'=>$this->getId()
    ));
    $this->setCad_name("");
    $this->setId(0);
    $this->setCad_registro(new DateTime());
    $this->setCad_senha("");
  }
  public function __toString(){
    return json_encode(array(
    "id"=>$this->getId(),
    "cad_name"=>$this->getCad_name(),
    "cad_senha"=>$this->getCad_senha(),
    "cad_registro"=>$this->getCad_registro()->format('Y-m-d H:i:s'),
    ));
  }
  /*Manipulando arquivos csv*/
  public function convCSV(){
    $sql = new Config();
    $results = $sql->select("SELECT * FROM cad_usuario ORDER BY cad_name ");
    $header =  array();
    foreach($results[0] as $key => $values){
      array_push($header, ucfirst($key));
    }
    $file = fopen("usuario.csv", "w+");
    fwrite($file, implode(",",$header ). "\r\n");
    foreach($results as $row){
        $data = array();
        foreach($row as $key => $value){
          array_push($data, $value);
        } /// foreach coluna
        fwrite($file, implode(",",$data ) . "\r\n");
    }// foreach dados
    fclose($file);
    
  }
  /*Excluir arquivos*/
  public function excluirArquivos(){
    $file = fopen("text.txt" , "w+");
    fclose($file);
    unlink("text.txt");
    echo"Arquivo Excluido com sucesso";
  }
  /* Remover Dados*/
  public function removerDados(){   
    if(!is_dir("images")){
      mkdir("images");
    }
    foreach(scandir("images") as $item){
      if(!in_array($item , array(".", ".."))){
        unlink("images/".$item);
      }
    }
    echo "ok";
  }
    /* Ler arquivos */
  public function lerArquivo(){
    $filename = "usuario.csv";
    if(file_exists($filename)){
      $file = fopen($filename, "r");
      $header = explode("," , fgets($file));
      $data = array();
      while($row = fgets($file)){
        $rowData = explode(",",$row);
        $linha = array();
        for($i = 0; $i < count($header); $i++){
          $linha[$header[$i]] = $rowData[$i]; 
        }
        array_push($data, $linha);
      }
      fclose($file);

      echo json_encode($data);
    }
  }
  /*Ler imagem*/
  public function lerImagem(){
    $filename = "logo.png";
    $base64 = base64_encode(file_get_contents($filename));
    $fileinfo = new finfo(FILEINFO_MIME_TYPE);
    $mimetype = $fileinfo->file($filename);
    $base64encode = "data:" . $mimetype. ";base64," .$base64; 
      ?>
<img src="<?php echo $base64encode; ?>">;
<a href="<?php echo $base64encode;?>" target="_blank">LinkPark </a>
<?php
    }
      /*Ler Upload*/

  public function upload(){
    if($_SERVER["REQUEST_METHOD"] === "POST"){
      $file = $_FILES["fileUpload"];
      if($file["error"]){
          throw new Exception("error".$file["error"]);
      }
      $dirUploads = "uplodas";
      if(!is_dir($dirUploads)){
        mkdir($dirUploads);
      }
      if(move_uploaded_file($file["tmp_name"], $dirUploads. DIRECTORY_SEPARATOR . $file["name"])){
        echo "Realizado com sucesso";
      }else{
        throw new Exception("Não foi possivel realizar o upload");
      }
    }
  }
  /*Dowloads*/
  public function dowload(){
    $link = "https://conteudo.imguol.com.br/c/entretenimento/18/2019/07/17/free-fire-1563382037564_v2_1024x1.png";
    $content = file_get_contents($link);
    $parse = parse_url($link);
    $basename = basename($parse["path"]);
    $file = fopen($basename , "w+");
    fwrite($file, $content);
    fclose($file);
    ?>
<img src="<?php echo $basename ?>">
<?php 
}
// mover arquivo
  public function moverArquivo(){
    $dir1 = "folder_01";
    $dir2 = "folder_02";

    if(!is_dir($dir1)){
      mkdir($dir1);
    }
    if(!is_dir($dir2)){
      mkdir($dir2);
    }
    $filename = "README.txt";
    if(!file_exists($dir1 . DIRECTORY_SEPARATOR. $filename)){
        $file = fopen($dir1 .DIRECTORY_SEPARATOR. $filename ,"w+" );
        fwrite($file, date("d-m-Y H:i:s"));
        fclose($file);
    }
    rename(
      $dir1 . DIRECTORY_SEPARATOR. $filename,
      $dir2 . DIRECTORY_SEPARATOR. $filename
    );
    echo "movido com sucesso";
  }
  // retornar json via php
  public function retornoJson(){
    $cep = "33200038";
    $link ="https://viacep.com.br/ws/$cep/json/";
    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response , true);
    print_r($data);
  }
  //criando um cookie
  public function cookie(){
    $data = array("empresa"=>"Treinamento de base");
    setcookie("NOME_DO_COOKIE", json_encode($data) , time()+3600);
    echo "ok";
  }
  //apresentando informação dos cookie
  public function getCookie(){
    $data = $_COOKIE["NOME_DO_COOKIE"];
    if(isset($data)){
     $obj = json_decode($data);
     echo $obj->empresa;
    }
  }
}
    ?>