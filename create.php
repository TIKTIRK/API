<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'db.php';
include_once 'news.php';
$request_method = $_SERVER["REQUEST_METHOD"];
if ($request_method=="POST"){
    $database = new Database();
    $db = $database->getConnection();
    
    $news = new news($db);
    
    $data = json_decode(file_get_contents("php://input"));

    if(
        !empty($data->title) &&
        !empty($data->description) &&
        !empty($data->text)&&
        !empty($data->date) &&
        !empty($data->tags)&&
        !empty($data->author)
    ){
    
        $news->title = $data->title;
        $news->description = $data->description;
        $news->text = $data->text;
        $news->date = $data->date;
        $news->tags = $data->tags;
        $news->author = $data->author;

        $res=$news->create();
        $json_news['result'] = array();
        $result = $res->fetchAll();

        foreach($result as $row){
            $json_news['result'][] = array(
            'id'=>$row['id'], 
            'title'=>preg_replace("/[\r\n]{2,}/i", "", $row['title']), 
            'description'=>$row['description'], 
            'text'=>$row['text'], 
            'date'=>$row['date'], 
            'tags'=>$row['tags'], 
            'author'=>$row['author']);
        }
        echo json_encode("News create");
        echo json_encode($json_news);
        
    }else{
    
        echo json_encode("Unable to create news. Data is incomplete");
    }
}else{
    echo json_encode("Wrong method");
}
/*{
    "title" : "",
    "description" : "",
    "text" : "",
    "date" : "0000-00-00",
    "tags" : "",
    "author" : ""
}*/
?>

