<?php

namespace App\Controller;

use App\Bll\CategoryBll;

class CategoryController extends BaseController
{
    // 分类首页
    public function indexAction()
    {
        $data = CategoryBll::getInstance()->getCategoryList();

        return $this->response->api($data);
    }

    // 热门分类
    public function hotAction()
    {

        $data = CategoryBll::getInstance()->getHotCategory();

        return $this->response->api($data);
    }
}
