<?php

namespace App\Bll;

use App\Exception\BaseException;
use App\Constant\ExceptionCode;
use App\Constant\CommonCode;
use think\Db;

class CommentBll extends BaseBll {

    public function addComment($data) {

        // 检查应用ID是否存在
        $info = Db::table('gb_portal_post')->where(['post_status' => 1, 'delete_time' => 0, 'id' => $data['id']])->find();
        if (!$info) {
            throw new BaseException('',ExceptionCode::APPLICATION_NOT_EXIST);
        }

        // 添加数据
        $addData = [
            'post_id' => $data['id'],
            'composite_score' => $data['composite_score'],
            'use_degree' => $data['use_degree'],
            'cost_performance' => $data['cost_performance'],
            'customer_service' => $data['customer_service'],
            'support' => $data['support'],
            'recommend_degree' => $data['recommend_degree'],
            'simple_comment' => $data['simple_comment'],
            'advantage_comment' => $data['advantage_comment'],
            'shortcoming_comment' => $data['shortcoming_comment'],
            'name' => $data['name'],
            'title' => $data['title'],
            'email' => $data['email'],
            'company' => $data['company'],
            'industry' => $data['industry'],
            'scale' => $data['scale'],
            'duration' => $data['duration'],
            'frequency' => $data['frequency'],
            'created_at' => date('Y-m-d H:i:s'),
        ];
        Db::table('gb_portal_post_comment')->insert($addData);

        return [];
    }


    public function getCommentList($data) {

        // 检查应用ID是否存在
        $info = Db::table('gb_portal_post')->where(['post_status' => 1, 'delete_time' => 0, 'id' => $data['id']])->find();
        if (!$info) {
            throw new BaseException('',ExceptionCode::APPLICATION_NOT_EXIST);
        }

        // 获取应用下所有审核通过的评论列表
        $list = Db::table('gb_portal_post_comment')
            ->where(['status' => 1, 'post_id' => $data['id']])
            ->field('simple_comment, name, title, industry, composite_score as score, use_degree as used, cost_performance as cost, customer_service as service, recommend_degree as recommend, advantage_comment as advantage, shortcoming_comment as shortcoming')
            ->select();

        return $list;
    }
}