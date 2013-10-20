<?php
/**
 * MainController
 * Feel free to delete the methods and replace them with your own code.
 *
 * @author bung
 */
class AdminController extends DooController{
	function __construct(){
		
		global $data,$users;
		$data['terms']=$this->db()->fetchAll('SELECT p.* FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy="category"');
		Doo::loadModel('Users');
		$users=new users;
		$users=$this->db()->find($users);
		Doo::loadModel('Posts');
		Doo::loadModel('Options');
		$options =new options;
		$posts=new posts;
		$options->option_name="blogdescription";
		$data['blogdescription']=$options->getOne()->option_value;
		$options->option_name="blogname";
		$data['blogname']=$options->getOne()->option_value;
		$data['rootUrl'] = Doo::conf()->APP_URL;
		$data['postsnum'] =$posts->count(array('where'=>'post_type="post"'));
		// $data['msg']= null;
		$data['powerby']=Doo::powerby();
		$data['version']=Doo::version();
		session_start();
		if(isset($_SESSION['user'])){
			$data['user'] = $_SESSION['user'];
		}
		//$renderpath=Doo::conf()->AUTO_VIEW_RENDER_PATH;		
		//$this->render('admin/header',true);
	}
	function phpinfo(){
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		phpinfo();
	}
	function dimplode($array) {
	if(!empty($array)) {
		return '"'.implode('","', is_array($array) ? $array : array($array)).'"';
	} else {
		return 0;
	}
	}
    public function index(){
		global $data;
		//$flash->addMessage("This is just test message");
		//$data['msg'] = $flash->getMessages();
		//var_dump($_SESSION['user']);
		if(isset($_SESSION['user'])){
			$data['user'] = $_SESSION['user'];
			$data['serverapp'] = $_SERVER['SERVER_SOFTWARE'];
			$data['phpversion']=PHP_VERSION;
			$data['mysqlversion']='';
			//$data['mysqlversion']=@mysql_get_server_info();
			$data['uploadfile_maxsize'] = ini_get('upload_max_filesize');
			$data['safe_mode'] = ini_get('safe_mode');
			if (function_exists("imagecreate"))
				{
				if(function_exists('gd_info'))
					{
					$ver_info = gd_info();
					$data['gd_ver'] = $ver_info['GD Version'];
					}else{
					$data['gd_ver'] = 'unknown';
						}
			}else{
					$data['gd_ver'] = 'unknown';
					}
			$this->render('admin/index', $data);
		}else{
			$data['user'] = null;
			$this->render('admin/login', $data);
			
		}
    }
	public function loging(){
		global $data;
		if(isset($_POST['user']) && isset($_POST['pw'])){
			$u = trim($_POST['user']);
			$p = trim($_POST['pw']);
			if(!empty($u) && !empty($p)){
				$user = Doo::loadModel('Users', true);
				$user->user_login = $u;
				$user = $this->db()->find($user, array('limit'=>1));
				if($user){
					Doo::loadClass('class-phpass');
					$wp_hasher = new PasswordHash(8, TRUE);
					//$sigPass=$wp_hasher->HashPassword($p);
					$pass=$user->user_pass;
					$isvail=$wp_hasher->CheckPassword($p,$pass);
					if($isvail){
					unset($_SESSION['user']);
					$_SESSION['user'] = array(
											'id'=>$user->ID, 
											'username'=>$user->display_name
										);
					return Doo::conf()->APP_URL.'admin';
					}else{echo 'password wrong';}
				}else{echo 'user unexisted';}
			}else{echo 'empty';}
		}else{
			echo 'required';
		}
	}
	
	public function logout(){
		unset($_SESSION['user']);
		session_destroy();
		return Doo::conf()->APP_URL;
	}
	public function write(){
		global $data;
		if(!empty($this->params[0])){
			$data['type']=$this->params[0];
		}else{
			$data['type']='post';
		}
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}	
		$tags=$this->db()->fetchAll('SELECT p.* FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy="post_tag"');
		$data['tags']=$tags;
		
		$this->render('admin/write',$data);
	}
	public function edit(){
		global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		if(is_numeric($this->params[0])){
		$dt=$this->params[0];
		Doo::loadModel('Posts');
		$posts=new posts;
		$posts->post_date=date('Y-m-d H:i:s',$dt);
		$post=$posts->getOne();
		$data['post']=$post;
		$id=$post->ID;
		$fetchterm=$this->db()->fetchAll("SELECT tt.term_id FROM wp_term_relationships tr ,wp_term_taxonomy tt WHERE tr.term_taxonomy_id=tt.term_taxonomy_id AND tt.taxonomy='category' AND object_id='$id'");
		$data['curterm']=0;
		if($fetchterm){
		$termid=$fetchterm[0];
		$termid=intval($termid['term_id']);
		$data['curterm']=$termid;
		}
		$tags=$this->db()->fetchAll('SELECT p.* FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy="post_tag"');
		$data['tags']=$tags;
		$reltags=$this->db()->fetchAll("SELECT t.name FROM wp_terms t,wp_term_taxonomy tt,wp_term_relationships tr WHERE t.term_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND tr.object_id=$id AND tt.taxonomy='post_tag'");
				$tags_name=array();
				foreach ($reltags as $key => $value) {
					$tags_name[]=$value['name'];
				}
				$data['reltags']=implode(',', $tags_name);
		}else{
			Doo::loadModel('Posts');
			$post=new posts;
			$post->post_name=$this->params[0];
			$post=$post->getOne();
			$data['post']=$post;

			$data['curterm']=0;
			$tags=$this->db()->fetchAll('SELECT p.* FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy="post_tag"');
			$data['tags']=$tags;

		}
		$data['post']->post_content=json_encode(stripslashes($data['post']->post_content));
		$this->render('admin/edit',$data);
	}
	public function attachment(){
				if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
			$fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
			if ($fn) {
				$path='uploads'.DIRECTORY_SEPARATOR;
				if(!is_dir($path.date('Y'))){
					mkdir($path.date('Y'),0777);
				}
				$path.=date('Y').DIRECTORY_SEPARATOR;
				if(!is_dir($path.date('m'))){
					mkdir($path.date('m'),0777);
				}
				$path.=date('m').DIRECTORY_SEPARATOR;
				$fullpath=$path.urlencode($fn);
				file_put_contents($fullpath,file_get_contents('php://input'));
				//list($width, $height, $type, $attr) = getimagesize("img/flag.jpg");
				$percent = 0.5;
				// Content type
				//header('Content-type: image/jpeg');
				// Get new sizes
				list($width, $height) = getimagesize($fullpath);
				$basename=basename($fullpath);
				list($name,$ext)=explode('.',$basename);
				$newwidth = $width * $percent;
				$newheight = $height * $percent;
				// Load
				$thumb = imagecreatetruecolor($newwidth, $newheight);
				switch ($ext) {
					case 'jpg':
						$creatfunction = "imagecreatefromjpeg";
						$savefunction="imagejpeg";
						break;
					case 'jpeg':
						$creatfunction = "imagecreatefromjpeg";
						$savefunction="imagejpeg";
						break;
					case 'png':
						$creatfunction = "imagecreatefrompng";
						$savefunction = "imagepng";
						break;
					case 'gif':
						$creatfunction = "imagecreatefromgif";
						$savefunction = "imagegif";
						break;
					default:
						# code...
						break;
				}
				$source = $creatfunction($fullpath);
				// Resize
				imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
				// Output
				//imagejpeg($thumb);
				$newpath=$path.urlencode($name).'-'.$newwidth.'x'.$newheight.'.'.$ext;
				$savefunction($thumb,$newpath);
    					Doo::loadModel('Postmeta');
    					$attached_file=new postmeta;
    					//$attached_file->post_id=;
    					$attached_file->meta_key='_wp_attached_file';
    					$attached_file->meta_value=$fullpath;
    					$attached_id=$this->db()->insert($attached_file);
    					$attachment_meta=new postmeta;
    					//$attachment_meta->post_id=;
    					$attachment_meta->meta_key='_wp_attachment_metadata';
    					//$arr=array();
    					//$attachment_meta->meta_value=$arr;
    					$attachment_id=$this->db()->insert($attachment_meta);
    					$o=array('attached_id'=>$attached_id,'attachment_id'=>$attachment_id,'url'=>$newpath);
    					echo json_encode($o);
   					 	
						}
	}
	public function post(){
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		Doo::loadModel('Posts');
		Doo::loadModel('Terms');
		$post=new posts;
		$post->post_title=$_POST['title'];
		$post->post_name=$_POST['post_name'];
		$post->post_content=$_POST['content'];
		$post->post_excerpt=$_POST['excerpt'];
	
		$post->post_author=$_SESSION['user']['id'];
		$post->post_status=$_POST['post_status'];
		$post->comment_status=$_POST['allow_remark'];
		$post->post_password=$_POST['password'];
		$post->post_type=$_POST['post_type'];
		$isedit= empty($_POST['ID']) ? false : true;
		$id=0;
		if ($_POST['postdate'] && $_POST['posttime']) {
			$datetime=$_POST['postdate'].' '.$_POST['posttime'];
			$post->post_date=date('Y-m-d H:i:s',strtotime($datetime));
			$post->post_date_gmt=date('Y-m-d H:i:s',strtotime($datetime));
		}else{
			$post->post_date=date('Y-m-d H:i:s',time());
			$post->post_date_gmt=date('Y-m-d H:i:s',time());
		}
		$tags_name=array();
		if ($isedit){
			$id=intval($_POST['ID']);
			$post->post_modified=date('Y-m-d H:i:s',time());
			$post->post_modified_gmt=date('Y-m-d H:i:s',time());
			$reltags=$this->db()->fetchAll("SELECT t.name FROM wp_terms t,wp_term_taxonomy tt,wp_term_relationships tr WHERE t.term_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND tr.object_id=$id AND tt.taxonomy='post_tag'");
				
				foreach ($reltags as $key => $value) {
					$tags_name[]=$value['name'];
				}
			
			$affected=$this->db()->update($post,array('where'=>"ID=$id"));
		}else{
			$id=$this->db()->insert($post);

		}
		if($_POST['post_type'] =='post'){
			if(!empty($_POST['sort'])){
				$termid=$_POST['sort'];
			}else{
				$termid=1;
		}
		}else{
			$termid=0;
		}
			
		if($_POST['post_type'] !='diary'){
			if (($isedit && intval($_POST['def_term']!= $termid) || !$isedit) ){
				Doo::loadModel('TermRelationships');
				$termrelationships = new termrelationships;
				$termrelationships->object_id=$id;
				$termrelationships->term_taxonomy_id=$termid;
				$trid=$this->db()->insert($termrelationships);
				$this->db()->query("UPDATE wp_term_taxonomy SET count=count+1 WHERE term_id=$termid");
				// Doo::loadModel('TermTaxonomy');
				// $termtaxonomy= new termtaxonomy;
				// $termtaxonomy->count='count+1';
				// $this->db()->update($termtaxonomy,array('where'=>"term_id=$termid"));
			}
			
		}
			$tags=array();
			$tag=$_POST['tag'];
			if(!empty($tag)){
			if (strpos($tag, ',')) {
				$tags=explode(',',$tag);
			}else{$tags[]=$tag;}
				$tid=0;
				Doo::loadModel('TermTaxonomy');
				foreach ($tags as $v) {
					if($isedit && in_array($v,$tags_name)) continue ;
				$terms=new terms;
				$terms->name=$v;
				if($o=$terms->getOne()){
		 		$this->db()->query("UPDATE wp_term_taxonomy SET count=count+1 WHERE term_taxonomy_id=$o->term_id");
		/*		$termtaxonomy= new termtaxonomy;
				$termtaxonomy->count+=1;
				$this->db()->update($termtaxonomy,array('where'=>"term_taxonomy_id='$o->term_id'"));*/
				$tid=$o->term_id;
				}else{
			
				$terms->slug=urlencode($v);
				$tid=$this->db()->insert($terms);
				Doo::loadModel('TermTaxonomy');
				$termtaxonomy= new termtaxonomy;
				$termtaxonomy->taxonomy=$_POST['post_type'].'_tag';
				$termtaxonomy->term_id=$tid;
				$termtaxonomy->count=1;
				$this->db()->insert($termtaxonomy);
				
					}
				Doo::loadModel('TermRelationships');
				$termrelationships = new termrelationships;
				$termrelationships->object_id=$id;
				$termrelationships->term_taxonomy_id=$tid;
				$this->db()->insert($termrelationships);
			
			}
		}
			
			if(!empty($_POST['attached_id']) && !empty($_POST['attachment_id'])){
				$attached_id=$_POST['attached_id'];
				$attachment_id=$_POST['attachment_id'];
				$ids=array();
				$attaches=array_merge($attached_id,$attachment_id);

				foreach ($attaches as $key => $value) {
					$ids[]=$value;
				}

				$ids=$this->dimplode($ids);		
				Doo::loadModel('Postmeta');
				$postmeta=new postmeta;
				$postmeta->post_id=$id;
				$this->db()->update($postmeta,array('where'=>"meta_id IN ($ids)"));
		}
	
	return $_SERVER['HTTP_REFERER'];
	
	}
	public function getterm($id){
		global $data;
		foreach ($data['terms'] as $value) {
			if ($value['term_id']==$id)	return $value['name'];
		}
	}
	public function getuser($id){
		global $users;
		
		foreach ($users as $value) {
			if ($value->ID==$id) return $value->display_name;
		}
		
	}
	public function drafts(){
		global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		$data['user'] = $_SESSION['user'];
		Doo::loadModel('Posts');
		Doo::loadHelper('DooPager');
		$posts=new posts;
		$opts=array('where'=>"post_status='draft'");
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/drafts',$posts->count($opts),5,100);
		if(isset($this->params[0])){
		$pager->paginate(intval($this->params[0]));
		}else{
		$pager->paginate(1);
		}

		if($posts->count()){
		$data['posts']=$this->db()->fetchAll("SELECT * FROM wp_posts p LEFT JOIN wp_term_relationships t ON t.object_id=p.id WHERE p.post_status='auto-draft' ORDER BY id DESC LIMIT $pager->limit",null,PDO::FETCH_OBJ);
		foreach ($data['posts'] as $key=>$value) {
			$data['posts'][$key]->author=$this->getuser($value->post_author);
			$data['posts'][$key]->term=$this->getterm($value->term_taxonomy_id);
			}
			$data['pager']=$pager->output;
			$this->render('admin/posts',$data);
		}else{echo 'no posts';}
	}
	public function trashes(){
		global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		$data['user'] = $_SESSION['user'];
		Doo::loadModel('Posts');
		Doo::loadHelper('DooPager');
		$posts=new posts;
		$opts=array('where'=>"post_status='trash'");
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/trashes',$posts->count($opts),5,100);
		if(isset($this->params[0])){
		$pager->paginate(intval($this->params[0]));
		}else{
		$pager->paginate(1);
		}
	
		if($posts->count()){
		$data['posts']=$this->db()->fetchAll("SELECT * FROM wp_posts p LEFT JOIN wp_term_relationships t ON t.object_id=p.id WHERE p.post_status='trash' ORDER BY id DESC LIMIT $pager->limit",null,PDO::FETCH_OBJ);
		foreach ($data['posts'] as $key=>$value) {
			$data['posts'][$key]->author=$this->getuser($value->post_author);
			$data['posts'][$key]->term=$this->getterm($value->term_taxonomy_id);
			}
			$data['pager']=$pager->output;
			$this->render('admin/posts',$data);
		}else{echo 'no posts';}
	}
	public function pages(){
		global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		$data['user'] = $_SESSION['user'];
		Doo::loadModel('Posts');
		Doo::loadHelper('DooPager');
		$posts=new posts;
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/pages',$posts->count(),5,100);
		if(isset($this->params[0])){
		$pager->paginate(intval($this->params[0]));
		}else{
		$pager->paginate(1);
		}
		if($posts->count()){
		$data['posts']=$this->db()->fetchAll("SELECT * FROM wp_posts p LEFT JOIN wp_term_relationships t ON t.object_id=p.id WHERE p.post_type='page' ORDER BY id DESC LIMIT $pager->limit",null,PDO::FETCH_OBJ);
		foreach ($data['posts'] as $key=>$value) {
			$data['posts'][$key]->author=$this->getuser($value->post_author);
			$data['posts'][$key]->term=$this->getterm($value->term_taxonomy_id);
			}
			$data['pager']=$pager->output;
			$this->render('admin/pages',$data);
		}else{echo 'no posts';}
	}
	public function manage_post(){
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		$action=$_POST['action'];

		$ids=$_POST['posts'];
	
		$this->$action($ids);
	
	}
	public function del($ids){
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		
			Doo::loadModel('Posts');
			$posts=new posts;
			Doo::loadModel('TermRelationships');
			$termrelationships=new TermRelationships;
		
			Doo::loadModel('TermTaxonomy');
			$termtaxonomy=new termtaxonomy;
			$termtaxonomy->taxonomy='category';
			$category=$termtaxonomy->find();
			$tids=array();
			foreach ($category as $value) {
			$tids[]=$value->term_taxonomy_id;
			}
			$ids=$this->dimplode($ids);
			$tids=$this->dimplode($tids);

			$tag_rel=$this->db()->fetchAll("SELECT * FROM wp_term_relationships r INNER JOIN wp_term_taxonomy t ON r.term_taxonomy_id=t.term_taxonomy_id WHERE r.object_id IN ($ids)");
			$tags=array();
			foreach ($tag_rel as $v) {
				if($v['taxonomy']=='post_tag'){
					$tags[]=$v;

				}
			}
			if ($tags) {
				foreach ($tags as $v) {
				$object_ids[]=$v['object_id'];
				$term_taxonomy_ids[]=$v['term_taxonomy_id'];
				$term_ids['term_id'];
				}
				$term_ids=$term_taxonomy_ids=$object_ids=array();
				$object_ids=$this->dimplode($object_ids);
				$term_taxonomy_ids=$this->dimplode($term_taxonomy_ids);
				$term_ids=$this->dimplode($term_ids);
				$this->db()->fetchAll("DELETE FROM wp_term_relationships WHERE object_id IN ($object_ids)");
				$this->db()->fetchAll("DELETE FROM wp_term_taxonomy WHERE term_taxonomy_id IN ($term_taxonomy_ids)");
				$this->db()->fetchAll("DELETE FROM wp_terms WHERE term_id IN ($term_ids)");
			}
			

		
			$posts->delete(array('where'=>"ID IN ($ids)"));
			$termrelationships->delete(array('where'=>"object_id IN ($ids) AND term_taxonomy_id IN ($tids)"));

		
	}
	public function trash($ids){
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		Doo::loadModel('Posts');
		$posts=new posts;
		if (count($ids)==1) {
			$posts->post_status='trash';
			$this->db()->update($posts,array('where'=>"ID = $ids[0]"));
		}else{
			
			$ids=$this->dimplode($ids);
			$posts->post_status='trash';
			$this->db()->update($posts,array('where'=>"ID IN ($ids)"));

		}
	}

	public function posts(){
		global $data;
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		$data['user'] = $_SESSION['user'];
		Doo::loadModel('Posts');
		Doo::loadHelper('DooPager');
		$posts=new posts;
		$opts=array('where'=>"post_type='post'");
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/posts',$posts->count($opts),5,100);
		if(isset($this->params[0])){
		$pager->paginate(intval($this->params[0]));
		}else{
		$pager->paginate(1);
		}
		Doo::loadModel('TermTaxonomy');
		$termtaxonomy=new termtaxonomy;
		$termtaxonomy->taxonomy='category';
		$category=$termtaxonomy->find();
		$ids=array();
		foreach ($category as $value) {
		$ids[]=$value->term_taxonomy_id;
		}
	
		$ids=$this->dimplode($ids);

		if(!empty($posts)){
		$data['posts']=$this->db()->fetchAll("SELECT * FROM wp_term_relationships t RIGHT JOIN wp_posts p ON t.object_id=p.id WHERE t.term_taxonomy_id IN ($ids)  ORDER BY id DESC LIMIT $pager->limit",null,PDO::FETCH_OBJ);
		foreach ($data['posts'] as $key=>$value) {
			$data['posts'][$key]->author=$this->getuser($value->post_author);
			$data['posts'][$key]->term=$this->getterm($value->term_taxonomy_id);
			}
			$data['pager']=$pager->output;
			$this->render('admin/posts',$data);
		}else{echo 'no posts';}
		
	}
	public function diaries(){
		global $data;
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		$data['user'] = $_SESSION['user'];
			$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}

		$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE post_type='diary' ORDER BY ID DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$count=count($posts);
		Doo::loadHelper('DooPager');

		$pager=new DooPager(Doo::conf()->APP_URL.'admin/diaries',$count,$per,100);
		$pager->paginate($start+1);
			$data['count']=$count;
			$data['posts']=$posts;
			$data['pager']=$pager->output;
			$this->render('admin/diaries',$data);	
	}
	public function tags(){
		global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		Doo::loadModel('TermTaxonomy');
			$tt=new termtaxonomy;
			$tt->taxonomy='post_tag';
			$tg=$tt->find();
			$count=count($tg);
		Doo::loadHelper('DooPager');
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/tags',$count,5,100);
		if(isset($this->params[0])){
		$pager->paginate(intval($this->params[0]));
		}else{
		$pager->paginate(1);
		}
		$tags=$this->db()->fetchAll("SELECT * FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy='post_tag' ORDER BY term_taxonomy_id DESC LIMIT $pager->limit",null,PDO::FETCH_OBJ);
		$data['tags']=$tags;
		
		$data['pager']=$pager->output;
			$this->render('admin/tags',$data);
		}
	public function categories(){
			global $data;
			if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
			$data['user'] = $_SESSION['user'];
			$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}

			$categories=$this->db()->fetchAll("SELECT p.* FROM wp_terms p,wp_term_taxonomy t WHERE t.term_id=p.term_id AND t.taxonomy='category' ORDER BY p.term_id DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
			$count=count($categories);
			Doo::loadHelper('DooPager');

			$pager=new DooPager(Doo::conf()->APP_URL.'admin/categories',$count,$per,100);
			$pager->paginate($start+1);
			$data['categories']=$categories;
		
			$data['pager']=$pager->output;
			$this->render('admin/categories',$data);
	}
	public function comments(){
	global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		Doo::loadModel('Comments');
		$comments=new comments;
		Doo::loadHelper('DooPager');
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/comments',$comments->count(),5,100);
			if(isset($this->params[0])){
			$pager->paginate(intval($this->params[0]));
			}else{
			$pager->paginate(1);
			}
		$filter = $this->params['filter'] ? trim($this->params['filter']) : 'all';
		$opts=array();
	switch ($filter){
		case 'all':
			break;
		case 'approved':
			$comments->comment_approved=1;
			$opts['where']="comment_approved=1";
			break;
		case 'unapproved':
			$comments->comment_approved=0;
			$opts['where']="comment_approved=0";
			break;
	
	}
	$data['pager']='';
	$count=0;
	if($comments->count()){
	$comments=$comments->limit($pager->limit,null,'comment_ID',$opts);
	
	$ids=array();
	$count=count($comments);
	for ($i=0; $i <$count ; $i++) { 
		$ids[]=$comments[$i]->comment_post_ID;
	}
	$dids=$this->dimplode($ids);
	$conv=array();
	$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE ID IN ($dids)");
	foreach ($posts as $key => $value) {
		$conv[$value['ID']]=$value;
	}
	foreach ($comments as $k=> $v) {

		$comments[$k]->post_title=$conv[$v->comment_post_ID]['post_title'];
			$postdate=date('Y/m/d/',strtotime($conv[$v->comment_post_ID]['post_date']));
			$post_url=$postdate.$conv[$v->comment_post_ID]['post_name'];
			$comments[$k]->post_url=$post_url;
			$comments[$k]->comment_count=$conv[$v->comment_post_ID]['comment_count'];
	}

	$data['pager']=$pager->output;
	$data['comments']=$comments;}
	$data['count']=$count;
	$this->render('admin/comments',$data);
	
	}
	public function links(){
		global $data;
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}
		Doo::loadModel('Links');
		$links=new links;
		Doo::loadHelper('DooPager');
		$count=$links->count();
		$pager=new DooPager(Doo::conf()->APP_URL.'admin/links',$count,10,100);
		if(isset($this->params[0])){
		$pager->paginate(intval($this->params[0]));
		}else{
		$pager->paginate(1);
		}
		$data['pager']=$pager->output;
		if($count){
		$data['links']=$links->find(array('limit'=>"$pager->limit"));	
		}
		$data['count']=$count;
		$this->render('admin/links',$data);


	}
	public function manage_link(){
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}

			Doo::loadModel('Links');
		 if($this->isAjax()){
		 	$ac=$_POST['ac'];
		 	unset($_POST['ac']);
		 	
		 	switch ($ac) {
		 		case 'update':
		 			$id=$_POST['id'];
		 			unset($_POST['id']);
		 			$links=new links;
				 	foreach ($_POST as $key => $val) {
				 		$links->$key=$val;
				 	}
				 	$dt=date('Y-m-d H:i:s',time());
				 	$links->link_updated=$dt;
				 	if($this->db()->update($links,array('where'=>"link_id='$id'"))){
				 		$return=array('success'=>'1','title'=>'success','info'=>'updated','datetime'=>$dt);
				 		echo json_encode($return);
				 	}else{
				 		$return=array('success'=>'0','title'=>'failure','info'=>'failure');
				 		echo json_encode($return);

				 	}
		 			break;
		 		case 'remove':
		 			$id=$_POST['id'];
		 			unset($_POST['id']);
		 			$olink=new links;
		 			$olink->link_id=$id;
		 			$olink->delete();
		 			$this->db()->query("UPDATE wp_term_taxonomy SET count=count+1 WHERE taxonomy='link_category'");

		 			/*	Doo::loadModel('TermTaxonomy');
		 				$tt=new termtaxonomy;
		 				$tt->count -=1;
		 				$this->db()->update($tt,array('where'=>'taxonomy="link_category"'));*/
		 			Doo::loadModel('TermRelationships');
		 			$tr=new termrelationships;
		 			$tr->object_id=$id;
		 			$tr->delete();
		 			$return=array('success'=>'1','title'=>'success','info'=>'removed');
		 			echo json_encode($return);

		 			

		 			break;
		 		case 'add':
		 			if(empty($_POST['link_name']) && empty($_POST['link_url'])){
		 			echo ' ';exit;}
		 			$alink=new links;
		 			$html='';
		 			$dt=date('Y-m-d H:i:s',time());
		 			foreach ($_POST as $key => $value) {
		 					$alink->$key=$value;
		 					if($key=='link_name'){
		 						$str="<a href=\"".$_POST['link_url']."\" target=\"_blank\">".$value."</a>";
		 						$html.= "<td class=\"input-append\" data-name=\"".$key."\" data-value=\"".$value."\">".$str."</td>";
		 					}else{
		 						$html.= "<td class=\"input-append\" data-name=\"".$key."\" data-value=\"".$value."\">".$value."</td>";
		 					}
		 			
		 			}
		 			$alink->link_updated=$dt;
		 			$id=$alink->insert();
		 			Doo::loadModel('TermRelationships');
		 			$tr=new termrelationships;
		 			$tr->object_id=$id;
		 			$tr->term_taxonomy_id=2;
		 			$tr->insert();
		 			$this->db()->query("UPDATE wp_term_taxonomy SET count=count+1 WHERE taxonomy='link_category'");
/*		 			Doo::loadModel('TermTaxonomy');
		 			$tt=new termtaxonomy;
		 			$tt->count +=1;
		 			$this->db()->update($tt,array('where'=>'taxonomy="link_category"'));*/
		 			$pre="<tr data-id=\"".$id."\">";
		 			
		 			$html.= "<td class=\"input-append\" data-name=\"link_updated\" data-value=\"".$dt."\">".$dt."</td>";
      				$html.='<td><a href="javascript:;" class="icon-remove" style="padding:3px;margin: 5px;"></a></td></tr>';
      				$r=$pre.$html;
      				echo $r;
		 		default:
		 			# code...
		 			break;
		 	}
		 	
		 
		 }

	}

	public function manage_category(){
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}

			Doo::loadModel('Terms');
		 if($this->isAjax()){
		 	$ac=$_POST['ac'];
		 	unset($_POST['ac']);
		 	
		 	switch ($ac) {
		 		case 'update':
		 			$id=$_POST['id'];
		 			unset($_POST['id']);
		 			$terms=new terms;
				 	foreach ($_POST as $key => $val) {
				 		$terms->$key=$val;
				 	}
				 	
				 	if($this->db()->update($terms,array('where'=>"term_id=$id"))){
				 		$return=array('success'=>'1','title'=>'success','info'=>'updated');
				 		echo json_encode($return);
				 	}else{
				 		$return=array('success'=>'0','title'=>'failure','info'=>'failure');
				 		echo json_encode($return);

				 	}
		 			break;
		 	/*	case 'remove':
		 			$id=$_POST['id'];
		 			unset($_POST['id']);
		 			$ocate=new links;
		 			$ocate->term_id=$id;
		 			$ocate->delete();
		 			Doo::loadModel('TermTaxonomy');
		 			$tt=new termtaxonomy;
		 			$tt->term_id=$id;
		 			$tt->taxonomy='category';
		 			$tt->delete();
		 			echo 'success';
		 			
		 			break;*/
		 		case 'add':
		 			if(empty($_POST['name']) && empty($_POST['slug'])){
		 			echo ' ';exit;}
		 			$aterm=new terms;
		 			$html='';
		 			foreach ($_POST as $key => $value) {
		 					$aterm->$key=$value;
		 					$html.= "<td class=\"input-append\" data-name=\"".$key."\" data-value=\"".$value."\">".$value."</td>";
		
		 			}
		 			
		 			$id=$aterm->insert();

		 			Doo::loadModel('TermTaxonomy');
		 			$tt=new termtaxonomy;
		 			$tt->term_taxonomy_id=$id;
		 			$tt->term_id=$id;
		 			$tt->taxonomy='category';
		 			$tt->insert();
		 		
		 			$pre="<tr data-id=\"".$id."\">";
		 			
		 			//$html.= "<td class=\"input-append\" data-name=\"link_updated\" data-value=\"".$dt."\">".$dt."</td>";
      				$html.='<td><a href="javascript:;" class="icon-remove" style="padding:3px;margin: 5px;"></a></td></tr>';
      				$r=$pre.$html;
      				echo $r;
		 		default:
		 			# code...
		 			break;
		 	}
		 	
		 
		 }

	}
	public function manage_comment(){
		if(empty($_SESSION['user'])){return Doo::conf()->APP_URL.'admin';}

			Doo::loadModel('Comments');
		 if($this->isAjax()){
		 	$ac=$_POST['ac'];
		 	unset($_POST['ac']);
		 	
		 	switch ($ac) {
		 		case 'update':
		 			$id=$_POST['id'];
		 			unset($_POST['id']);
		 			$Comments=new Comments;
				 	foreach ($_POST as $key => $val) {
				 		$Comments->$key=$val;
				 	}
				 	
				 	if($this->db()->update($Comments,array('where'=>"comment_ID=$id"))){
				 		$return=array('success'=>'1','title'=>'success','info'=>'updated');
				 		echo json_encode($return);
				 	}else{
				 		$return=array('success'=>'0','title'=>'failure','info'=>'failure');
				 		echo json_encode($return);

				 	}
		 			break;
		 		case 'remove':
		 			$id=$_POST['id'];
		 			unset($_POST['id']);
		 			$gComments=new Comments;
		 			$gComments->comment_ID=$id;
		 			$theComment=$gComments->getOne();
		 			$post_id=$theComment->comment_post_ID;
		 			$this->db()->query("UPDATE wp_posts SET comment_count=comment_count-1 WHERE ID=$post_id");

		 			$oComments=new Comments;
		 			$oComments->comment_ID=$id;
		 			$oComments->delete();
		 			$return=array('success'=>'1','title'=>'success','info'=>'removed');
		 			echo json_encode($return);
		 			
		 			
		 			break;
		 		
		 		default:
		 			# code...
		 			break;
		 	}
		 	
		 
		 }

	}
  
}
?>