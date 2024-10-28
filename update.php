<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once 'db.php';
include_once 'news.php';

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

if($news->update()){
    echo json_encode("News was updated");
}else{
    echo json_encode("Unable to update news");
}
?>