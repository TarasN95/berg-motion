<?php

class GifsController extends Controller {

    public function __construct($data = array()){
        parent::__construct($data);
        $this->model = new Gif();
    }

    public function index(){
        $this->data['gifs'] = $this->model->getList();
    }

    public function admin_index(){
        $this->data['gifs'] = $this->model->getList();
    }

    public function admin_add() {
        if ( $_POST) {
            $uploaddir = ROOT.DS.'webroot'.DS.'img'.DS.'gifs'.DS;

            $gifdir = '/webroot/img/gifs/'.basename($_FILES['gif']['name']);
            $giffile = $uploaddir.basename($_FILES['gif']['name']);
            move_uploaded_file($_FILES['gif']['tmp_name'], $giffile);

            $_POST['gif'] = $gifdir;
            $result = $this->model->save($_POST);
            if ($result) {
                Session::setFlash('Page was saved');
            } else {
                Session::setFlash('Page was saved');
            }
            Router::redirect('/admin/gifs/');
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
            Router::redirect('/admin/gifs/');
        }

        if (isset($this->params[0])) {
            $this->data['gif'] = $this->model->getById($this->params[0]);
        } else {
            Session::setFlash('Wrong page id.');
            Router::redirect('/admin/gifs/');
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
        Router::redirect('/admin/gifs');
    }
}