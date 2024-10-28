<?php
header("Content-Type: application/json; charset=UTF-8");

include_once 'db.php';
include_once 'news.php';
 
$database = new Database();
$db = $database->getConnection();

$news = new News($db);
$res = $news->read($_GET["id"]);
$num = $res->rowCount();
if($num>0){

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

}else{
    echo json_encode("No news found");
} 

?>