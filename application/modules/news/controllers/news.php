<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class News extends ModuleController {

    public static $config = array(
        'name' => 'news',
        'title' => 'Новости',
        'uri' => 'news',
        'upload_folder' => 'news',
        'tb' => 'news',
        'perPage' => 10,
        'mainPage' => 'news',
        'media_fields' => array('image', 'thumb'),
    );
    public static $md = 'mdl_news';

    public function __construct()
    {
        parent::__construct(self::$config, self::$md);
    }

    /*

      function index($start = 0){
      $this->load->helper('text');
      $this->load->library('pagination');
      $limit = 2;

      $content = $this->load->module('template')->loadDefaultData();
      $content['articles'] =  $this->cmodel->getAllArticles($start, $limit);
      $config['total_rows'] = $this->cmodel->getCount();
      foreach ($content['articles'] as &$article) {
      $article['short'] = word_limiter($article['content'], 100);
      }
      $content['all'] = $this->cmodel->getAllArticles(0, $config['total_rows']);
      unset($content['all'][0]);
      unset($content['all'][1]);

      $content['settings']=$this->load->module('settings')->getListSettings();
      $content['info'] = $this->load->module('pages')->getPageCHPU('news');
      $content['title'] = $content['info']['name'];
      $content['description'] = $content['info']['mdesc'];
      $content['keywords'] = $content['info']['mkeys'];
      $content['breadcrumbs'][]=array('url'=>'/news','name'=>'Новости');
      $content['page'] = 'news';

      $config['base_url'] = '/news/';
      $config['total_rows'] = $this->cmodel->getCount();
      $config['per_page'] = $limit;
      $config['uri_segment'] = 2;
      $config['prev_tag_open'] = '<div style="display:none;">';
      $config['prev_tag_close'] = '</div>';
      $config['first_link'] = $config['last_link'] = $config['next_link'] = $config['prev_link'] = '';
      $this->pagination->initialize($config);
      $content['paginator'] = $this->pagination->create_links();

      $this->load->view('templates/header', $content);
      $this->load->view('templates/breadcrumbs', $content);
      $this->load->view('frontlist', $content);
      $this->load->view('templates/footer', $content);
      }

      function getVerticalLastArticles($customClass = 'sidebar-articles')
      {
      $content['last_articles'] = $this->getLastArticles();
      foreach ($content['last_articles'] as &$article) {
      $article['short'] = word_limiter($article['content'], 8);
      }
      $content['class'] = $customClass;
      return $this->load->view('verticalLast', $content, true);
      }

      function getLastArticles()
      {
      $this->load->helper('text');
      $articles = $this->cmodel->getLastNews(4);
      $months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня',
      'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
      foreach ($articles as &$article) {
      $article['short'] = word_limiter ($article['content'], 8);
      $date = new DateTime($article['date']);
      $article['date'] = $date->format("d") . ' ' . $months[$date->format("n") - 1] . ', ' . $date->format("H:i");
      }

      return $articles;
      }

      function view($chpu)
      {
      $months = array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня',
      'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря');
      $content = $this->load->module('template')->loadDefaultData();
      $content['page'] = 'news';
      $content['view'] = $this->load->module('news')->getArticle($chpu);
      $date = new DateTime($content['view']['date']);
      $content['view']['date'] = $date->format("d") . ' ' . $months[$date->format("n") - 1] . ', ' . $date->format("H:i");
      $content['breadcrumbs']=array();
      $content['breadcrumbs'][]=array('url'=>'/news','name'=>'Новости');
      $content['breadcrumbs'][]=array('url'=> '/news/view/' . $chpu,'name'=>$content['view']['name']);
      $content['settings']=$this->load->module('settings')->getListSettings();
      $content['page'] = 'news';
      $content['title'] = $content['view']['title'];
      $content['description'] = $content['view']['mdesc'];
      $content['keywords'] = $content['view']['mkeys'];
      $content['last_articles'] = $this->getLastArticles();
      $isFind = false;
      foreach ($content['last_articles'] as $key => &$value) {
      if ($value['ID'] == $content['view']['ID']) {
      unset($content['last_articles'][$key]);
      $isFind = true;
      break;
      }
      }
      if (!$isFind)
      unset($content['last_articles'][count($content['last_articles'])-1]);
      $this->load->view('templates/header',$content);
      $this->load->view('templates/breadcrumbs',$content);
      $this->load->view('view',$content);
      $this->load->view('templates/footer',$content);
      }


      function actions()
      {
      $content = $this->load->module('template')->loadDefaultData();
      $this->load->model('articles/mdl_articles');
      $content['last_news'] = $this->mdl_articles->getLastArticles(3);
      $content['breadcrumbs']=array();
      $content['breadcrumbs'][]=array('url'=>'/news/actions','name'=>'Акции');
      $content['actions']=  $this->load->module('actions')->getAllArticles();
      $content['settings']=$this->load->module('settings')->getListSettings();
      $content['title'] = 'Акции';


      $this->load->view('templates/header',$content);
      $this->load->view('templates/action',$content);
      $this->load->view('templates/footer',$content);
      }





      /*-----------------------admin function--------------------- */
    /* function admin_index($page = 0){
      $is_logged_in = $this->session->userdata('is_logged_in');
      if(!$is_logged_in){
      redirect('admin');
      }
      else{
      $content = array();
      $content['title'] = 'Новости';
      $content['key'] = 0;
      $content['pages'] = $this->cmodel->getAllPagesAdmin();

      $this->load->view('includes/admin_header',$content);
      $this->load->view('list',$content);
      $this->load->view('includes/admin_footer',$content);
      }
      }

      function addPage(){
      $content = array();
      $content['title'] = 'Контент';
      //$content['categories'] = $this->mdl_recipe->getCatList();

      $this->load->view('includes/admin_header',$content);
      $this->load->view('add',$content);
      $this->load->view('includes/admin_footer',$content);
      }
      function editPage($id_page){
      $content['title'] = 'Редактирование контента';
      $content['page_info'] = $this->cmodel->getPageInfo($id_page);

      $this->load->view('includes/admin_header',$content);
      $this->load->view('edit',$content);
      $this->load->view('includes/admin_footer',$content);
      }
      function add(){
      $this->cmodel->add();
      redirect('dashboard/news');
      }
      function edit($id_page){
      if($this->cmodel->edit($id_page))
      redirect('dashboard/news');
      else
      redirect('dashboard/news/editPage/'.$id_page);

      }
      function sort(){
      $this->cmodel->sort();
      }
      function status($id_page, $status){
      if($this->cmodel->status($id_page, $status)){

      }
      else {
      echo "no";
      }
      }
      function delPage($id)
      {
      $this->cmodel->del($id);
      redirect('dashboard/news');
      }
      /*----------------end admin functions---------------------- */

    /*
      function getAllArticles()
      {
      return $this->cmodel->getAllArticles();
      }

      function getArticle($chpu)
      {
      return $this->cmodel->getPageCHPU($chpu);
      }

      function getLinkRecipe($recipe_chpu)
      {
      $recipe=  $this->getRecipe($recipe_chpu);
      $ingridients= explode("\n",$recipe['ingridients']);
      foreach ($ingridients as &$val)
      {
      $val=trim($val);
      $links=$this->load->module('item')->findItem('name',$val);
      if($links)
      {
      $link=$links[0];
      $val='<a href="/'.$link['shop_chpu'].'/'.$link['cat_chpu'].'">'.$val.'</a>';
      }
      }
      $recipe['ingridients']=$ingridients;
      return $recipe;
      }

      function viewsUp($id)
      {
      $this->cmodel->viewsUp($id);
      }

      function findItem($field,$value)
      {
      return $this->cmodel->findItem($field,$value);
      } */
}
