<?php

use think\Route;

Route::get('category/:cid/list', 'article/list');
Route::get('category/:cid/list/:order', 'article/list');

Route::get('article/:id/info', 'article/detail');

Route::get('article/:id/comment', 'comment/list');
Route::post('article/:id/comment', 'comment/add');

