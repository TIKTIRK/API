<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUSH");

include_once 'db.php';
include_once 'news.php';
$request_method = $_SERVER["REQUEST_METHOD"];
if ($request_method=="PUSH"){
    $db = new Database();
    $db = $db->getConnection();

    $news = new News($db);

    $data = json_decode(file_get_contents("php://input"));

    $news->id = $data->id;

    $news->title = $data->title;
    $news->description = $data->description;
    $news->text = $data->text;
    $news->tags = $data->tags;
    $news->date = $data->date;
    $news->author = $data->author;

    if($news->update()==false){
        echo json_encode("Unable to update news");
    }else{
        echo json_encode("News was updated");
        $res=$news->update();
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
        echo json_encode($json_news);
    }
}else{
    echo json_encode("Wrong method");
}
?>