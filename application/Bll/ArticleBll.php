<?php

namespace App\Bll;

use App\Exception\BaseException;
use App\Constant\ExceptionCode;
use App\Constant\CommonCode;
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

    public function getArticleDetail($data) {

        // 应用详情
        $info = Db::table('gb_portal_post')->where(['post_status' => 1, 'delete_time' => 0, 'id' => $data['id']])->find();
        if (!$info) {
            throw new BaseException('',ExceptionCode::APPLICATION_NOT_EXIST);
        }

        $data = [
            'title' => $info['post_title'],
            'developer' => $info['post_developer'],
            'score' => $info['comment_score'],
            'comment_count' => $info['comment_count'],
            'icon' => IMG_DOMAIN.'/upload/'.$info['thumbnail'],
            'use_level' => $info['use_level'],
            'service_level' => $info['service_level'],
            'content' => $info['post_content'],
            'price' => $info['floor_price'].'/'.CommonCode::$fee_cycle[$info['fee_cycle']].'/'.CommonCode::$fee_standard[$info['fee_standard']],
            'trialDemo' => $info['free_trial'] && $info['free_trial'] > 0 ? '有' : '否',
            'support_platform' => array_map(function ($n){ return CommonCode::$support_platform[$n];}, explode(',', $info['support_platform'])),
            'training_mode' => array_map(function ($n){ return CommonCode::$training_mode[$n];}, explode(',', $info['training_mode'])),
            'developer_desc' => $info['post_developer_introduction'],
        ];

        // 图片列表
        $images = json_decode($info['more'], true);
        if($images && isset($images['photos']) && count($images['photos']) > 0) {
            $imgList = $images['photos'];
            foreach ($imgList as $key => $img) {
                $imgList[$key]['url'] = IMG_DOMAIN.'/upload/'.$imgList[$key]['url'];
            }

        } else {
            $imgList = [];
        }
        $data['img_list'] = $imgList;


        $categorys = Db::table('gb_portal_category_post')
            ->alias('cp')
            ->join('gb_portal_category c', 'cp.category_id = c.id')
            ->where(['cp.status' => 1, 'cp.post_id' => $info['id']])
            ->field('c.id, c.name')
            ->select();

        $categoryIds = array_column($categorys, 'id');

        // 当前应用拥有的功能点
        $currentFunctions = explode(',', $info['functions']);

        // 获取分类对应的功能列表
        $functions = Db::table('gb_portal_function')
            ->alias('f')
            ->join('gb_portal_category c', 'c.id = f.category_id')
            ->whereIn('f.category_id', $categoryIds)
            ->where(['f.status' => 1])
            ->field('f.id as fid, f.name as fname, c.id as cid, c.name as cname')
            ->select();

        $cList = [];
        foreach ($functions as $key => $row) {
            if (!array_key_exists($row['cid'], $cList)) {
                $cList[$row['cid']] = ['cid' => $row['cid'], 'cname' => $row['cname'], 'function' => []];
            }

            if (in_array($row['fid'], $currentFunctions)) {
                $cList[$row['cid']]['function'][] = ['fid' => $row['fid'], 'fname' => $row['fname'],'check' => 1];
            } else {
                $cList[$row['cid']]['function'][] = ['fid' => $row['fid'], 'fname' => $row['fname'],'check' => 0];
            }

        }

        $data['category_funciton'] = $cList;

        return $data;
    }
}