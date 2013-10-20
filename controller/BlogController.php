<?php
/**
 * MainController
 * Feel free to delete the methods and replace them with your own code.
 *
 * @author darkredz
 */

class BlogController extends DooController{
	function __construct(){
		global $data;
		Doo::loadModel('Options');
		Doo::loadModel('Posts');
		
		Doo::loadModel('Links');
		Doo::loadHelper('DooPager');
		$posts= new Posts;
		$options=new Options;
		$links=new links;
		$opt=array(
				'where'=>'taxonomy="category"',
				'asArray'=>true,
				'filters'=>array(
					array('model'=>'TermTaxonomy',
						'where'=>'count!=0')
					)
				);
			$categories=$this->db()->relate('TermTaxonomy','Terms',$opt);
    	//$categories=$this->db()->fetchAll('SELECT p.* FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy="category" AND count!=0');
    	
    	$data['categories']=$categories;
 			$opt=array(
				'where'=>'taxonomy="post_tag"',
				'asArray'=>true,
				'filters'=>array(
					array('model'=>'TermTaxonomy',
						'where'=>'taxonomy="post_tag"')
					)
				);
			$tags=$this->db()->relate('TermTaxonomy','Terms',$opt);
		//$tags=$this->db()->fetchAll('SELECT p.* FROM wp_term_taxonomy t LEFT JOIN wp_terms p ON t.term_id=p.term_id WHERE taxonomy="post_tag"');
		$q = "SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM wp_posts p WHERE post_date < NOW() AND post_status='publish' AND post_type='post' AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
		$archives=$this->db()->fetchAll($q);

		$data['archives']=$archives;
		$data['tags']=$tags;
		$data['links']=$links->find();
		
		$posts->post_type='page';
		$posts->post_status='publish';
		$data['pages']=$this->db()->find($posts,array('asc'=>'menu_order'));
		$options->option_name='blogdescription';
		$data['blogdescription']=$this->db()->getOne($options)->option_value;
		$data['description']='';
		$options->option_name='blogname';
		$data['blogname']=$this->db()->getOne($options)->option_value;
		$data['rootUrl'] = Doo::conf()->APP_URL;
		$data['powerby']=Doo::powerby();
		$data['version']=Doo::version();
		$data['title']=$data['blogname'];
		$data['keywords']='';
		
		if(isset($_COOKIE["userinfo"])){
		$data['userinfo']=json_decode($_COOKIE["userinfo"]);

		}
		// $this->render('header',$data);
		//$this->render('footer',$data);
		}
	public function beforeRun($resource, $action){
		global $data;

		$data['action']=$action;
		if(isset($_COOKIE['lang'])){
			$lang=$_COOKIE['lang'];
		}else{
		 if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])){
        $accept_language = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $lang=strtolower($accept_language[0]);
   		 }else{
   		 	$lang='zh-cn';
   		 }
    	if(!in_array($lang, array('zh-cn','ja'))){
    		$lang='en';
    	}
    	}
    	Doo::loadPlugin('lang.'.$lang);

	}	
	private function dimplode($array) {
	if(!empty($array)) {
		return '"'.implode('","', is_array($array) ? $array : array($array)).'"';
		} else {
		return 0;
		}
	}

	public function profile(){
		global $data;
		$xml='';
		$url='http://api.douban.com/people/bung/collection?cat=music&status=listening';
		$timeout=5;
		$expire=60*60*24*15;
		//strtotime('2 weeks');
		if($this->cache()->get('music@douban')){
			$str=$this->cache()->get('music@douban');
			$xml=simplexml_load_string($str);
			
		}else{
			$client = $this->load()->helper('DooRestClient', true);
 			$client->connect_to($url)->get();
 
			 if($client->isSuccess()){
			      $xml= $client->xml_result();
			 }
			$albums = $xml->xpath('//db:subject');
			$dom = new DOMDocument("1.0",'utf-8');
			$root=$dom->createElement("albums");
			$dom->appendChild($root);
		foreach ($albums as $k=>$v) {
			$album=$dom->createElement("album");
			$root->appendChild($album);
			$title=$dom->createElement("title");
			$album->appendChild($title);
			$titleval=$dom->createTextNode((string)$v->title);
			$title->appendChild($titleval);
		
			$link=$dom->createElement("link");
			$album->appendChild($link);
			$linkval=$dom->createTextNode((string)$v->link[1]['href']);
			$link->appendChild($linkval);

			$img=$dom->createElement("img");
			$album->appendChild($img);
			$imgval=$dom->createTextNode((string)$v->link[2]['href']);
			$img->appendChild($imgval);
		}
		$content=$dom->saveXML();
			$xml=simplexml_load_string($content);
			$this->cache()->set('music@douban',$content,$expire);
		}
			$i=0;
			$albums = $xml->xpath('//album');
			foreach ($albums as $v) {
				$arr[$i]['title']=(string)$v->title;
				$arr[$i]['link']=(string)$v->link;
				$arr[$i]['img']=(string)$v->img;
				$i++;
			}
		$data['albums']=$arr;
		$data['title']='关于我'.'-'.$data['title'];
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		$this->render('profile',$data);
	}
    public function index(){
		global $data;	
			$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}

		$ids=$this->db()->fetchAll("SELECT tr.object_id,t.slug,t.name FROM wp_term_relationships tr,wp_term_taxonomy tt,wp_terms t WHERE tt.term_taxonomy_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=t.term_id AND tt.taxonomy='category' ORDER BY tr.object_id DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);

		$pids=array();
		$cateslug=array();
		$catename=array();
		foreach ($ids as $key => $value) {
			$pids[]=$value->object_id;
			$cateslug[$value->object_id]=$value->slug;
			$catename[$value->object_id]=$value->name;
		}

		$dids=$this->dimplode($pids);
		$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE ID IN($dids) AND post_status='publish' AND post_type='post' ORDER BY ID DESC",null,PDO::FETCH_OBJ);
		//$num=$this->db()->fetchAll("SELECT COUNT(*) FROM wp_posts WHERE post_status='publish' AND post_type='post'");
		Doo::loadModel('posts');
		$pp=new posts;
		$opts=array('where'=>"post_status='publish' AND post_type='post'");
		$num=$pp->count($opts);
		$count=count($posts);
			for ($i=0; $i < $count; $i++) { 
				$id=$posts[$i]->ID;
			$posts[$i]->catename=$catename[$id];
			$posts[$i]->cateslug=$cateslug[$id];
		}
		
		$pager=new DooPager(Doo::conf()->APP_URL.'page',$num,$per,100);
		
		$pager->paginate($start+1);
		$data['pager']=$pager->output;
		$data['posts']=$posts;
		$data['title']='首页'.'-'.$data['title'];
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		//$data['authors']=$authors;
 		$this->view()->render('index',$data);
		
    }
    public function diary(){
		global $data;	
			$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}


		$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE post_status='publish' AND post_type='diary' ORDER BY ID DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);

		$count=count($posts);
			
		$pager=new DooPager(Doo::conf()->APP_URL.'page',$count,$per,100);
		
		$pager->paginate($start+1);
		$data['pager']=$pager->output;
		$data['count']=$count;
		$data['posts']=$posts;
		$data['title']='日记'.'-'.$data['title'];
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		//$data['authors']=$authors;
		$this->render('diary',$data);
    }
	public function page(){
		global $data;
		
			if(isset($this->params['pindex']) && $this->params['pindex']>0){
				$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}
		//$posts=$this->db()->fetchAll("SELECT p.* FROM wp_posts p WHERE p.post_status='publish' AND p.post_type='post' LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$ids=$this->db()->fetchAll("SELECT tr.object_id,t.slug,t.name FROM wp_term_relationships tr,wp_term_taxonomy tt,wp_terms t WHERE tt.term_taxonomy_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=t.term_id AND tt.taxonomy='category' ORDER BY tr.object_id DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$pids=array();
		$cateslug=array();
		$catename=array();
		foreach ($ids as $key => $value) {
			$pids[]=$value->object_id;
			$cateslug[$value->object_id]=$value->slug;
			$catename[$value->object_id]=$value->name;
		}

		$dids=$this->dimplode($pids);
		$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE ID IN($dids) AND post_status='publish' AND post_type='post' ORDER BY ID DESC ",null,PDO::FETCH_OBJ);

		$count=count($posts);
			for ($i=0; $i < $count; $i++) { 
				$id=$posts[$i]->ID;
			$posts[$i]->catename=$catename[$id];
			$posts[$i]->cateslug=$cateslug[$id];
		}
		Doo::loadModel('posts');
		$pp=new posts;
		$opts=array('where'=>"post_status='publish' AND post_type='post'");
		$num=$pp->count($opts);
		$pager=new DooPager(Doo::conf()->APP_URL.'page',$num,$per,100);
		
		$pager->paginate($start+1);
			$data['pager']=$pager->output;
			$data['posts']=$posts;

			$data['queries']=$this->db()->getQueryCount();
			$data['benchmark']=Doo::benchmark();
			//$data['authors']=$authors;
			$this->render('index',$data);
			
			}else{
				return Doo::conf()->APP_URL;
			}

	}
	public function category(){
		global $data;
		$category=$this->params['category'];
		if(isset($category)){
		$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}
		$rels=$this->db()->fetchAll("SELECT tr.object_id,t.slug,t.name FROM wp_terms t LEFT JOIN wp_term_taxonomy tt ON tt.term_id=t.term_id LEFT JOIN wp_term_relationships tr ON tt.term_taxonomy_id=tr.term_taxonomy_id WHERE t.slug='$category' ORDER BY tr.object_id DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$curcate=$rels[0]->name;
		$pids=array();
		$cateslug=array();
		$catename=array();
		foreach ($rels as $key => $value) {
			$pids[]=$value->object_id;
		}
		
		$dids=$this->dimplode($pids);
		$ddids=implode(',', $pids);

		$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE ID IN($dids) AND post_status='publish' AND post_type='post' ORDER BY FIND_IN_SET(ID, '$ddids')",null,PDO::FETCH_OBJ);
		$count=count($posts);
		$pager=new DooPager(Doo::conf()->APP_URL.'category/'.$category,$count,$per,100);
		for ($i=0; $i < $count; $i++) { 
			$posts[$i]->catename=$rels[$i]->name;
			$posts[$i]->cateslug=$rels[$i]->slug;
		}
		
		$pager->paginate($start+1);
		$data['title']=$curcate.'-'.$data['title'];
		$data['posts']=$posts;
		$data['pager']=$pager->output;
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		$this->render('index',$data);
	}else{
	
		return Doo::conf()->APP_URL;
		}
	
	}

	public function archives(){
		global $data;
		$args=$this->params;
		$args_num=count($args);
		$postdate=$this->params[0].'-'.str_pad($this->params[1],2,'0',STR_PAD_LEFT);
			
			$per=5;
		if(isset($this->params[2])){
			$start=($this->params[2]-1)*$per;
			}else{
				$start=0;}
		
		$posts=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE post_date LIKE '%$postdate%' AND post_status='publish' AND post_type='post' ORDER BY ID DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$pids=array();
		$count=count($posts);
			for ($i=0; $i < $count; $i++) { 
				$pids[]=$posts[$i]->ID;
				$id=$posts[$i]->ID;
		}
		$dids=$this->dimplode($pids);
		$ids=$this->db()->fetchAll("SELECT tr.object_id,t.slug,t.name FROM wp_term_taxonomy tt ,wp_term_relationships tr ,wp_terms t WHERE tt.term_taxonomy_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=t.term_id AND tt.taxonomy='category' AND tr.object_id IN($dids)",null,PDO::FETCH_OBJ);
		
				for ($i=0; $i < $count; $i++) { 
				
			$posts[$i]->catename=$ids[$i]->name;
			$posts[$i]->cateslug=$ids[$i]->slug;
		}
		$pager=new DooPager(Doo::conf()->APP_URL.'page',count($posts),$per,100);
		
		$pager->paginate($start+1);
		$data['pager']=$pager->output;
		$data['posts']=$posts;
		$data['title']=$postdate.'-'.$data['title'];
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		//$data['authors']=$authors;
		$this->render('index',$data);

	}
	public function single(){
		global $data;
		$args=$this->params;
		$args_num=count($args);
		switch ($args_num) {
			case 4:
				# like /s/2012/08/23/hello-world
				$date=array($args[0],$args[1],$args[2]);
				$postdate=implode($date,'-');
				$postname=$args[3];
				$post=$this->db()->fetchAll("SELECT * FROM wp_posts WHERE post_date LIKE '%$postdate%' AND post_name='$postname' AND post_status='publish' AND post_type='post'",null,PDO::FETCH_OBJ);
				$data['post']=$post[0];	
				$id=$data['post']->ID;
				$term=$this->db()->fetchAll("SELECT t.name AS catename,t.slug AS cateslug FROM wp_term_relationships tr LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id=tt.term_taxonomy_id LEFT JOIN wp_terms t ON tt.term_id=t.term_id WHERE tr.object_id=$id",null,PDO::FETCH_OBJ);				
				$term=$term[0];
				$data['post']->catename=$term->catename;
				$data['post']->cateslug=$term->cateslug;
				$tags=$this->db()->fetchAll("SELECT t.* FROM wp_terms t,wp_term_taxonomy tt,wp_term_relationships tr WHERE t.term_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND tr.object_id=$id AND tt.taxonomy='post_tag'",null,PDO::FETCH_OBJ);
				$data['reltags']=$tags;
				Doo::loadModel('Comments');
				$comments=new comments;
				$comments->comment_post_ID=$id;
				$comments->comment_parent=0;
				$data['comments']=$comments->find();
	
				break;
			case 3:
				# like /s/20120823-hello-word
				break;
			case 2:
				$dt=$this->params[0];
				Doo::loadModel('Posts');
				$posts=new posts;
				$posts->post_date=date('Y-m-d H:i:s',$dt);
				$post=$posts->getOne();
				$data['post']=$post;
				$id=$data['post']->ID;
				$term=$this->db()->fetchAll("SELECT t.name,t.slug FROM wp_term_relationships tr ,wp_term_taxonomy tt,wp_terms t WHERE tr.term_taxonomy_id=tt.term_taxonomy_id AND tt.term_id=t.term_id AND tr.object_id=$id AND tt.taxonomy='category'",null,PDO::FETCH_OBJ);				
				if(!empty($term)){
				$data['relcategories']=$term;
				$tags=$this->db()->fetchAll("SELECT t.* FROM wp_terms t,wp_term_taxonomy tt,wp_term_relationships tr WHERE t.term_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND tr.object_id=$id AND tt.taxonomy='post_tag'",null,PDO::FETCH_OBJ);
				$data['reltags']=$tags;}
				Doo::loadModel('Comments');
				$comments=new comments;
				$comments->comment_post_ID=$id;
				$comments->comment_parent=0;
				$data['comments']=$comments->find();
				if($this->params[1]=='rss'){
					$this->renderc('rss_one',$data);
				}else{
					header('Content-Type: application/javascript');
					echo json_encode($data['post']);
				}
				
				exit;
				break;
			case 1:
				# like /s/$timestamp
				$dt=$this->params[0];
				Doo::loadModel('Posts');
				$posts=new posts;
				$posts->post_date=date('Y-m-d H:i:s',$dt);
				$post=$posts->getOne();
				$data['post']=$post;
				$id=$data['post']->ID;
				$term=$this->db()->fetchAll("SELECT t.name,t.slug FROM wp_term_relationships tr ,wp_term_taxonomy tt,wp_terms t WHERE tr.term_taxonomy_id=tt.term_taxonomy_id AND tt.term_id=t.term_id AND tr.object_id=$id AND tt.taxonomy='category'",null,PDO::FETCH_OBJ);				
				if(!empty($term)){
				$data['relcategories']=$term;
				$tags=$this->db()->fetchAll("SELECT t.* FROM wp_terms t,wp_term_taxonomy tt,wp_term_relationships tr WHERE t.term_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND tr.object_id=$id AND tt.taxonomy='post_tag'",null,PDO::FETCH_OBJ);
				$data['reltags']=$tags;}
				Doo::loadModel('Comments');
				$comments=new comments;
				$comments->comment_post_ID=$id;
				$comments->comment_parent=0;
				$data['comments']=$comments->find();
			break;
			default:
				# code...
				break;
		}
		$keywords=array();
		foreach ($data['relcategories'] as $key => $value) {
			$keywords[]=$value->name;
		}
		foreach ($data['reltags'] as $key => $value) {
			$keywords[]=$value->name;
		}
		$strip_content=strip_tags($data['post']->post_content);
		$clear_content=str_replace('"','',$strip_content);
		$des=$data['post']->post_title.' '.$clear_content;
		Doo::loadHelper('DooTextHelper');
        $data['description']=DooTextHelper::limitChar($des,140,'','utf-8');
        $data['description']=str_replace(PHP_EOL, '', $data['description']); 
		$matched_words=array();
		preg_match_all('/\b[\w\x{4e00}-\x{9fff}]+\b/u', $data['post']->post_title, $mat,PREG_PATTERN_ORDER);

		foreach ($mat[0] as $key => $value) {
			if(!in_array($value, $keywords)){
				array_push($keywords, $value);
			}
		}
		$data['keywords']=implode(' ', $keywords);
		$data['title']=$data['post']->post_title.'-'.$data['title'];
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		$this->render('single',$data);
	}
	public function diary_one(){
		global $data;
				$dt=$this->params[0];
				Doo::loadModel('Posts');
				$posts=new posts;
				$posts->post_date=date('Y-m-d H:i:s',$dt);
				$post=$posts->getOne();
				$data['post']=$post;
				$id=$data['post']->ID;
				$tags=$this->db()->fetchAll("SELECT t.* FROM wp_terms t,wp_term_taxonomy tt,wp_term_relationships tr WHERE t.term_id=tr.term_taxonomy_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND tr.object_id=$id AND tt.taxonomy='diary_tag'",null,PDO::FETCH_OBJ);
				$data['reltags']=$tags;
				Doo::loadModel('Comments');
				$comments=new comments;
				$comments->comment_post_ID=$id;
				$comments->comment_parent=0;
				$data['comments']=$comments->find();
		$data['title']=$data['post']->post_title.'-'.$data['title'];
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		//$data['authors']=$authors;
		$this->render('diary_one',$data);
	}
	public function p(){
				global $data;
				$postname=$this->params[0];
				$post=$this->db()->fetchAll("SELECT p.* FROM wp_posts p WHERE post_name='$postname'",null,PDO::FETCH_OBJ);

				$data['post']=$post[0];
				$id=$data['post']->ID;

				Doo::loadModel('Comments');
				$comments=new comments;
				$comments->comment_post_ID=$id;
				$comments->comment_parent=0;
				$data['comments']=$comments->find();
				//$data['authors']=$authors;
				$data['title']=$data['post']->post_title.'-'.$data['title'];
				$data['queries']=$this->db()->getQueryCount();
				$data['benchmark']=Doo::benchmark();
				$this->render('page',$data);
	}
	public function rss(){
		global $data;
			$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}
		if(!empty($this->params['category'])){
			$category=$this->params['category'];
	
		$posts=$this->db()->fetchAll("SELECT p.* FROM wp_terms t LEFT JOIN wp_term_relationships r ON r.term_taxonomy_id=t.term_id LEFT JOIN wp_posts p ON r.object_id=p.id WHERE t.slug='$category' ORDER BY r.object_id DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
	
		$pager=new DooPager(Doo::conf()->APP_URL.'category/'.$category,count($posts),$per,100);
		
		$pager->paginate($start+1);

		$data['pager']=$pager->output;
		$data['posts']=$posts;
		}else{
		$posts=$this->db()->fetchAll("SELECT p.* FROM wp_posts p WHERE p.post_status='publish' AND p.post_type='post' ORDER BY ID DESC LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$pager=new DooPager(Doo::conf()->APP_URL.'p',count($posts),$per,100);
		if(isset($this->params['pindex'])){
		$pager->paginate(intval($this->params['pindex']));
		
		}else{
		$pager->paginate(1);
		}
		$data['pager']=$pager->output;
		$data['posts']=$posts;
		}
		Doo::loadHelper('DooTextHelper');
		//$data['authors']=$authors;
		$this->renderc('rss',$data);
	}
	public function search(){
		global $data;
			$per=5;
		if(isset($this->params['pindex'])){
			$start=($this->params['pindex']-1)*$per;
			}else{
				$start=0;}
		$keyword=$_GET['keyword'];
		if(!empty($keyword)){
		$posts=$this->db()->fetchAll("SELECT p.* FROM wp_posts p WHERE p.post_title LIKE '%$keyword%' AND p.post_status='publish' AND p.post_type='post' LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$count=count($posts);
		$pager=new DooPager(Doo::conf()->APP_URL.'search?keyword='.$keyword,$count,$per,100);
		if(isset($this->params['pindex'])){
		$pager->paginate(intval($this->params['pindex']));
		
		}else{
		$pager->paginate(1);
		}
		$ids=array();
		foreach ($posts as $key => $value) {
			$ids[]=$value->ID;
		}
		$dids=$this->dimplode($ids);
		$term=$this->db()->fetchAll("SELECT t.name AS catename,t.slug AS cateslug FROM wp_term_relationships tr LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id=tt.term_taxonomy_id LEFT JOIN wp_terms t ON tt.term_id=t.term_id WHERE tr.object_id IN ($dids)",null,PDO::FETCH_OBJ);				
		for ($i=0; $i < $count; $i++) { 
			$posts[$i]->catename=$term[$i]->catename;
			$posts[$i]->cateslug=$term[$i]->cateslug;
		}
		$data['pager']=$pager->output;
		$data['posts']=$posts;
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		//$data['authors']=$authors;
		$this->render('index',$data);
		}else{echo 'no';}
		
	}
	public function tag(){
		global $data;
		if(isset($this->params[0])){
		$tag=$this->params[0];
		$per=5;
		if(isset($this->params[1])){
			$start=($this->params[1]-1)*$per;
			}else{
				$start=0;}
		$posts=$this->db()->fetchAll("SELECT p.* FROM wp_terms t LEFT JOIN wp_term_relationships r ON r.term_taxonomy_id=t.term_id LEFT JOIN wp_posts p ON r.object_id=p.id WHERE t.slug='$tag' LIMIT $start,$per",null,PDO::FETCH_OBJ);
		$count=count($posts);
		$ids=array();
		foreach ($posts as $key => $value) {
			$ids[]=$value->ID;
		}
		$dids=$this->dimplode($ids);
		$term=$this->db()->fetchAll("SELECT t.name AS catename,t.slug AS cateslug FROM wp_term_relationships tr LEFT JOIN wp_term_taxonomy tt ON tr.term_taxonomy_id=tt.term_taxonomy_id LEFT JOIN wp_terms t ON tt.term_id=t.term_id WHERE tr.object_id IN ($dids)",null,PDO::FETCH_OBJ);				
		for ($i=0; $i < $count; $i++) { 
			$posts[$i]->catename=$term[$i]->catename;
			$posts[$i]->cateslug=$term[$i]->cateslug;
		}
		$pager=new DooPager(Doo::conf()->APP_URL.'tag/$tag'.$tag,$count,$per,100);
		
		$pager->paginate($start+1);
		//$data['authors']=$authors;
		$data['title']=urldecode($tag).'-'.$data['title'];
		$data['posts']=$posts;
		$data['pager']=$pager->output;
		$data['queries']=$this->db()->getQueryCount();
		$data['benchmark']=Doo::benchmark();
		$this->render('index',$data);
		}else{return 404;}
	}
	public function comment(){

		$ishidden=(bool)$_POST['formhidden'];
		if ($ishidden)  {echo 'access denied!';exit;}

		Doo::loadModel('Comments');
		$comment=new comments;
		$postid=(int)$_POST['comment_post_ID'];
		$comment->comment_post_ID=$postid;
		$user=array(
			'name'=>'',
			'mail'=>'',
			'site'=>''
			);
		$date='';
		if(isset($_COOKIE['userinfo'])){
			$userinfo=json_decode($_COOKIE['userinfo'],true);
			$user['name']=$userinfo['screenName'];
			$user['mail']=$userinfo['email'];
			$user['site']=$userinfo['homepage'];
			$comment->comment_author_avatar=$userinfo['profileImageUrl'];
		}else{
			$user['name']=isset($_POST['author']) ? $_POST['author'] :'匿名';
			$user['mail']=isset($_POST['email']) ?$_POST['email'] :'';
			if(isset($_POST['url'])){
			$deUrl=urldecode($_POST['url']);
			$user['site']=strpos($deUrl,'http://') !==false ? $deUrl :'http://'.$deUrl;
			}
		}
		$comment->comment_author=$user['name'];
		$comment->comment_author_email=$user['mail'];
		$comment->comment_author_url=$user['site'];

		$comment->comment_author_IP=$this->clientIP();
		$comment->comment_date=$date=date('Y-m-d H:i:s',time());
		$comment->comment_content=$_POST['comment'];
		$comment->comment_agent=$_SERVER['HTTP_USER_AGENT'];
		$comment->comment_parent=(int)$_POST['comment_parent'];
	
		$id=$this->db()->insert($comment);
		if($id){
			
		$this->db()->query("UPDATE wp_posts SET comment_count=comment_count+1 WHERE ID=$postid");
			if($this->isAjax()){
			$html='<dl class="c mt5">'.
			'<dd class="l user">'.
				'<img class="avt" src="" width="48" height="48">'.	
			'</dd>'.
			'<dd><span><a href="'.$user['site'].'" target="_blank" rel="nofollow">'.$user['name'].'</a></span> '.$date.'</dd>'.
			'<dd>'.$_POST['comment'].'</dd>'.
			'</dl>';
			echo $html;
			}else{
			return $_SERVER['HTTP_REFERER'];
			}
		}
	}
}
?>
