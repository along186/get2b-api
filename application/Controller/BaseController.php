<?php
namespace App\Controller;

use think\Controller;
use think\Request;
use App\Library\Response;
use App\Exception\ResponsableException;

class BaseController extends Controller
{

    const SUCCESS_CODE = 1000; // 系统成功代码
    const ERROR_CODE = 1001; // 失败代码

    /**
     * @var \think\Request 请求体
     */
    protected $request;

    /**
     * @var \app\library\Response 响应体
     */
    protected $response;

    final public function __construct(Request $request)
    {
        // 1.实例化request体
        $this->request  = $request;

        // 2.实例化response体
        $this->response = new Response();

        // 3.跨域请求OPTIONS
        if ($this->request->isOptions()) {
            throw new ResponsableException(null, ResponsableException::HTTP_METHOD_OPTION);
        }
    }
}
