<?php header('Content-Type: application/javascript');?>
<?php //$_GET['page'];$_GET['start'];$_GET['limit']?>

<?php $authors=array();?>
<?php   function url3($id,$dt){
        Doo::loadHelper('DooUrlBuilder');
        if($timestamp=strtotime($dt)){
            return DooUrlBuilder::url($id, array('dt'=>$timestamp));
        }else{
            return DooUrlBuilder::url($id, array('dt'=>$dt));
        }
         
}
    function authorname($id){
        if(empty($authors)){
        Doo::loadModel('Users');
        $users=new users;
        $users=Doo::db()->find('Users');
       
        foreach ($users as $key => $value) {

            $authors[$value->ID]=$value->display_name;
            } 
       // $authors=$authors;
    }
        return $authors[$id];
}
    function cutstr($str,$length){
        Doo::loadHelper('DooTextHelper');
        $s=DooTextHelper::limitChar($str,$length,'...','utf-8');
        return $s;
}
?>
<?php 
$responseData=array();
$responseData['title']=$data['post']->post_title;
$responseData['link']=substr($data['rootUrl'],0,-1).url3('s', $data['post']->post_date);
$responseData['content']=$data['post']->post_content;
$responseData['pubdate']=$data['post']->post_date_gmt;
$responseData['author']=authorname($data['post']->post_author);
$responseData['comments']=$data['comments'];
$res=json_encode($responseData);
print $_GET['callback'].'('.$res.')';
?>