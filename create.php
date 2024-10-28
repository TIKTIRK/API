<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'db.php';
include_once 'news.php';
  
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


    if($news->create()){
        echo json_encode("News was created");
    }else{
        echo json_encode("Unable to create news");
    }
}

else{
  
    echo json_encode("Unable to create news. Data is incomplete");
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

