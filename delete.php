<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: Delete");
 
include_once 'db.php';
include_once 'news.php';
$request_method = $_SERVER["REQUEST_METHOD"];
if ($request_method=="DELETE"){
    $db = new Database();
    $db = $db->getConnection();
    

    $news = new News($db);

    $data = json_decode(file_get_contents("php://input"));
    
    $news->id = $data->id;
    
    if($news->delete()){
        echo json_encode("news was deleted");
    }else{
        echo json_encode("Unable to delete news");
    }
}else{
    echo json_encode("Wrong method");
}
?>