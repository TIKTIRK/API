<?PHP  

class Database{
    public $con;
    
    public function getConnection(){
    
    $this->con = null;
    
    try{
    $this->con = new PDO('mysql:host=localhost;dbname=news', "root" , "root");
    }catch(PDOException $e){
        $json['error'] = 'ERROR: ' . $e->getMessage();
        print(json_encode($json));
        exit;
    }
   
    return $this->con;
    }
}
?>
