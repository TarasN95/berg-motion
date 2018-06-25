<?php

class  Page extends Model {

    public  function  getList($only_published = false){
        $sql = "select * from videos where 1 order by id desc ";
        if ($only_published){
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public  function  getPublished($only_published = false){
        $sql = "select * from videos where is_published=1 order by id desc";
        if ($only_published){
            $sql .= " and is_published = 1";
        }
        return $this->db->query($sql);
    }

    public  function getByAlias($alias){
        $alias = $this->db->escape($alias);
        $sql = "select * from videos where alias = '{$alias}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function getById($id) {
        $id = (int)$id;
        $sql = "select * from videos where id = '{$id}' limit 1";
        $result = $this->db->query($sql);
        return isset($result[0]) ? $result[0] : null;
    }

    public function save($data, $id = null) {
        if (!isset($data['alias']) || !isset($data['title']) || !isset($data['illustrator']) || !isset($data['animator']) || !isset($data['prev']) || !isset($data['link']) || !isset($data['about']) || !isset($data['img0']) || !isset($data['img1'])){
            return false;
        }


        $for_videos = '?wmode=opaque&api=1';
        $id = (int)$id;
        $alias = $this->db->escape($data['alias']);
        $title = $this->db->escape($data['title']);
        $illustrator = $this->db->escape($data['illustrator']);
        $animator = $this->db->escape($data['animator']);
        $prev = $this->db->escape($data['prev']);
        $link0 = $this->db->escape($data['link']);
        $link1= $link0.$for_videos;
        $about = $this->db->escape($data['about']);
        $img0 = $this->db->escape($data['img0']);
        $img1 = $this->db->escape($data['img1']);
        $is_published = isset($data['is_published']) ? 1 : 0;

        if (!$id){ // Add new record
            $sql = "
                insert into videos
                    set alias = '{$alias}',
                        title = '{$title}',
                        illustrator = '{$illustrator}',
                        animator = '{$animator}',
                        prev = '{$prev}',
                        link = '{$link1}',
                        about = '{$about}',
                        img0 = '{$img0}',
                        img1 = '{$img1}',
                        is_published = {$is_published}
                ";
        } else { // Update existing record
            $sql = "
                 update videos
                    set alias = '{$alias}',
                        title = '{$title}',
                        illustrator = '{$illustrator}',
                        animator = '{$animator}',
                        prev = '{$prev}',
                        link = '{$link0}',
                        about = '{$about}',
                        img0 = '{$img0}',
                        img1 = '{$img1}',
                        is_published = {$is_published}
                where id = {$id}
                ";
        }

        return $this->db->query($sql);
    }


    public function delete($id){
        $id = (int)$id;
        $sql = "delete from videos where id = ($id)";
        return $this->db->query($sql);
    }
}