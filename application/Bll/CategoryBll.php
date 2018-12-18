<?php

namespace App\Bll;

use App\Model\PortalCategoryModel;
use think\Db;

class CategoryBll extends BaseBll {

    public function getHotCategory() {

        $hot = Db::table('gb_portal_category_post')
                            ->where('status', PortalCategoryModel::PUBLISH_STATUS)
                            ->group('category_id')
                            ->order("c desc ")
                            ->field('category_id,count(id) as c')
                            ->limit(6)
                            ->select();

        $ids = array_column($hot,'category_id');
        $data = Db::table('gb_portal_category')
                            ->whereIn('id', $ids)
                            ->where(['delete_time' => 0])
                            ->where('status', PortalCategoryModel::PUBLISH_STATUS)
                            ->select();

        return $data;
    }

    public function getCategoryList() {

        // 取出所有分类
        $categoryList = Db::table('gb_portal_category')->where(['delete_time' => 0])->where('status', PortalCategoryModel::PUBLISH_STATUS)->order("parent_id ASC")->select();

        // 整理分类数组
        $list = [];
        foreach ($categoryList as $key => $category) {
            if($category['parent_id'] == 0) {
                $list[$category['id']] = ['id' => $category['id'], 'name' => $category['name']];
            } else {
                $list[$category['parent_id']]['sub_ids'][] = ['id' => $category['id'], 'name' => $category['name']];
            }
        }

        // 处理返回数据
        $data = [];
        foreach ($list as $value) {
            $data[] = $value;
        }
        // 返回数据
        return $data;
    }
}