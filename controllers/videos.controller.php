<?php

class VideosController extends Controller {

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Page();
    }

    public function index(){
        $this->data['videos'] = $this->model->getList();
    }

    public function view(){
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $alias = strtolower($params[0]);
            $this->data['page'] = $this->model->getByAlias($alias);
        }
    }

    public function admin_index(){
        $this->data['videos'] = $this->model->getList();
    }

    public function admin_add() {
        if ( $_POST) {
            $uploaddir0 = ROOT.DS.'webroot'.DS.'img'.DS.'for_videos'.DS.'images'.DS;
            $uploaddir1 = ROOT.DS.'webroot'.DS.'img'.DS.'for_videos'.DS.'gifs'.DS;

            $prevdir = '/webroot/img/for_videos/images/'.basename($_FILES['prev']['name']);
            $prevfile = $uploaddir0.basename($_FILES['prev']['name']);
            move_uploaded_file($_FILES['prev']['tmp_name'], $prevfile);

            $dir0 = '/webroot/img/for_videos/gifs/'.basename($_FILES['img0']['name']);
            $uploadfile0 = $uploaddir1.basename($_FILES['img0']['name']);
            move_uploaded_file($_FILES['img0']['tmp_name'], $uploadfile0);

            $dir1 = '/webroot/img/for_videos/gifs/'.basename($_FILES['img1']['name']);
            $uploadfile1 = $uploaddir1.basename($_FILES['img1']['name']);
            move_uploaded_file($_FILES['img1']['tmp_name'], $uploadfile1);

            $_POST['prev'] = $prevdir;
            $_POST['img0'] = $dir0;
            $_POST['img1'] = $dir1;
            $result = $this->model->save($_POST);
            if ($result) {
                Session::setFlash('Page was saved');
            } else {
                Session::setFlash('Page was saved');
            }
            Router::redirect('/admin/videos/');
        }
    }

    public function admin_edit() {

        if ( $_POST) {
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST, $id);
            if ($result) {
                Session::setFlash('Page was saved');
            } else {
                Session::setFlash('Error.');
            }
            Router::redirect('/admin/videos/');
        }

        if (isset($this->params[0])) {
            $this->data['page'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/videos/');
        }
    }

    public function admin_delete(){
        if (isset($this->params[0])) {
            $result = $this->model->delete($this->params[0]);
            if ($result) {
                Session::setFlash('Page was deleted.');
            } else {
                Session::setFlash('Error.');
            }
        }
        Router::redirect('/admin/videos');
    }
}