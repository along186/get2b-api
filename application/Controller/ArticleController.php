<?php

namespace App\Controller;

use App\Bll\ArticleBll;
use App\Exception\BaseException;
use App\Exception\ResponsableException;

class ArticleController extends BaseController
{
    // 应用列表
    public function listAction()
    {
        // 参数校验
        ValidateGet2b($this->request->param(), ['cid' => 'require|integer']);

        // 获取分类下所有应用
        $data = ArticleBll::getInstance()->getArticleList($this->request->param());

        return $this->response->api($data);
    }

    // 应用详情
    public function detailAction()
    {
        // 入参校验
        ValidateGet2b($this->request->param(), ['id' => 'require|integer']);

        try {
            $data = ArticleBll::getInstance()->getArticleDetail($this->request->param());
        } catch ( BaseException $e) {
            throw new ResponsableException($e->getMessage(), ResponsableException::HTTP_NOT_FOUND);
        }

        return $this->response->api($data);
    }
    
}
