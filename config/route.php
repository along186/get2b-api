<?php

use think\Route;

Route::get('category/:cid/list', 'article/list');
Route::get('category/:cid/list/:order', 'article/list');

Route::get('article/:id', 'article/detail');

