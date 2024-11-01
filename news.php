<?php
class News{
    public $title;
    public $description;
    public $text;
    public $date;
    public $tags;
    public $author;
    private $con;

    public function __construct($db){
        $this->con = $db;
    }

    function read($id){
        if ($id != NULL){
            $query = "SELECT * FROM `news_list` WHERE id=$id"; 
        }else{
            $query = "SELECT * FROM `news_list`";
        }
        $res = $this->con->prepare($query);        
        $res->execute();
        return $res; 
    }

    function create(){
  
        $query = "INSERT INTO `news_list` SET 
                    title=:title, 
                    description=:description, 
                    text=:text, 
                    date=:date, 
                    tags=:tags, 
                    author=:author";
        $res = $this->con->prepare($query);

        $res->bindParam(":title", $this->title);
        $res->bindParam(":description", $this->description);
        $res->bindParam(":text", $this->text);
        $res->bindParam(":date", $this->date);
        $res->bindParam(":tags", $this->tags);
        $res->bindParam(":author", $this->author);
        $res->execute();
        
        $query_output = "SELECT * FROM `news_list` ORDER BY id DESC LIMIT 1;";
        $res_output = $this->con->prepare($query_output);
        $res_output->execute();
        return $res_output;
    }

    function delete(){
        $query = "DELETE FROM `news_list` WHERE id =:id";
        $res = $this->con->prepare($query);
        $res->bindParam(":id", $this->id);
        if($res->execute()){
            return true;
        }
        return false;
    }

    function update(){
        $update="";
        $title=$this->title;
        $description=$this->description;
        $text=$this->text;
        $date=$this->date;
        $tags=$this->tags;
        $author=$this->author;
        if($this->title!=NULL){$update.="title='$title'";}
        if($this->description!=NULL && $update!=""){$update.=", description='$description'";}elseif($this->description!=NULL){$update.="description='$description'";}
        if($this->text!=NULL && $update!=""){$update.=", text='$text'";}elseif($this->text!=NULL){$update.="text='$text'";}
        if($this->date!=NULL && $update!=""){$update.=", date='$date'";}elseif($this->date!=NULL){$update.="date='$date'";}
        if($this->tags!=NULL && $update!=""){$update.=", tags='$tags'";}elseif($this->tags!=NULL){$update.="tags='$tags'";}
        if($this->author!=NULL && $update!=""){$update.=", author='$author'";}elseif($this->author!=NULL){$update.="author='$author'";}
        $query = "UPDATE `news_list` SET $update WHERE id = :id";
        
        $res = $this->con->prepare($query);
        $res->bindParam(":id", $this->id);

        $query_output = "SELECT * FROM `news_list` WHERE id = :id";
        $res_output = $this->con->prepare($query_output);
        $res_output->bindParam(":id", $this->id);
        $res_output->execute();
        if($res->execute()){
            return $res_output;
        }
      
        return false;
    }
}
?>