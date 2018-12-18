<?php

namespace App\Controller;

use App\Bll\ArticleBll;

class ArticleController extends BaseController
{
    // 应用列表
    public function listAction()
    {
        // 参数校验
        ValidateGet2b($this->request->param(), ['cid' => 'integer']);

        // 获取分类下所有应用
        $data = ArticleBll::getInstance()->getArticleList($this->request->param());

        return $this->response->api($data);
    }

    // 应用详情
    public function detailAction()
    {
        // 入参校验
        //$this->validate($this->request[''])

        return $this->response->api([]);
    }
    
}
