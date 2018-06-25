<?php

class  Gif extends Model {

    public  function  getList($only_published = false){
        $sql = "select * from gifs where 1 order by id desc ";
        if ($only_published){
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public  function  getPublished($only_published = false){
        $sql = "select * from gifs where is_published=1 order by id desc";
        if ($only_published){
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "select * from gifs where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id = null) {
        if (!isset($data['title']) || !isset($data['illustrator']) || !isset($data['animator']) || !isset($data['gif'])){
            return false;
        }

        $id = (int)$id;
        $title = $this->db->escape($data['title']);
        $illustrator = $this->db->escape($data['illustrator']);
        $animator = $this->db->escape($data['animator']);
        $gif = $this->db->escape($data['gif']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if (!$id){ // Add new record
            $sql = "
                insert into gifs
                    set title = '{$title}',
                        illustrator = '{$illustrator}',
                        animator = '{$animator}',
                        gif = '{$gif}',
                        is_published = {$is_published}
                ";
        } else { // Update existing record
            $sql = "
                 update videos
                    set title = '{$title}',
                        illustrator = '{$illustrator}',
                        animator = '{$animator}',
                        gif = '{$gif}',
                        is_published = {$is_published}
                where id = {$id}
                ";
        }

        return $this->db->query($sql);
    }


    public function delete($id){
        $id = (int)$id;
        $sql = "delete from gifs where id = ($id)";
        return $this->db->query($sql);
    }
}