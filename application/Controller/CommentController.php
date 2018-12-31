<?php

namespace App\Controller;

use App\Bll\CommentBll;

class CommentController extends BaseController
{
    // 评论列表
    public function listAction()
    {
        // 参数校验
        ValidateGet2b($this->request->param(), ['id' => 'require|integer']);

        // 获取分类下所有应用
        $list = CommentBll::getInstance()->getCommentList($this->request->param());

        return $this->response->api($list);
    }

    // 添加评论
    public function addAction()
    {
        // 参数校验
        ValidateGet2b($this->request->param(), [
                'id' => 'require|integer',
                'composite_score' => 'require|between:1,6',
                'use_degree' => 'require|between:1,6',
                'customer_service' => 'require|between:1,6',
                'support' => 'require|between:1,6',
                'cost_performance' => 'require|between:1,6',
                'recommend_degree' => 'require|between:1,11',
                'simple_comment' => 'require',
                'name' => 'require',
                'title' => 'require',
                'email' => 'require|email',
                'company' => 'require',
                'industry' => 'require',
                'scale' => 'require|integer',
                'duration' => 'require|integer',
                'frequency' => 'require|integer',
        ]);

        // 添加应用评论
        CommentBll::getInstance()->addComment($this->request->param());

        return $this->response->api([]);
    }
    
}
