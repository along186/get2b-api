<?php

namespace App\Bll;

use think\Db;

class ArticleBll extends BaseBll {

    protected static $orderType = [1 => 'p.create_time asc', 2 => 'p.comment_score desc', 3 => 'p.comment_count desc'];
    public function getArticleList($data) {

        if (!isset($data['order']) || !$data['order']) {
            $order = 1;
        } else {
            $order = $data['order'];
        }
        $data = Db::table('gb_portal_category_post')
            ->alias('c')
            ->join('gb_portal_post p', 'c.post_id = p.id')
            ->where(['c.status' => 1,'p.post_status' => 1, 'p.delete_time' => 0, 'c.category_id' => $data['cid']])
            ->order(self::$orderType[$order] ?? self::$orderType[1])
            ->field('p.post_title as title, p.post_excerpt as excerpt, p.comment_score as score, p.comment_count as count, p.post_developer as developer, p.post_developer_introduction as developer_introduction, p.thumbnail as icon')
            ->select();

        return $data;
    }

    public function getArticleDetail($id) {
        return [];
    }
}