<?php

namespace App\Library;

use think\Response as ThinkResponse;
use think\Request as ThinkRequest;

class Response extends ThinkResponse{

    /**
     * 返回JSON
     *
     * @param mixed  $data
     * @param array  $header
     * @param int    $code
     *
     * @return \think\Response
     */
    final public function json($data, $header = [], $code = 200)
    {
        $header = $header + $this->cors();

		return $this->create($data, 'json', $code, $header);
	}

    /**
     * 返回跨域头
     *
     * @return array
     */
    public function cors()
    {
        $http_origin = ThinkRequest::instance()->server()['HTTP_ORIGIN'] ?? null;
        if(in_array(env('APP_ENV'),['dev','test'])){
            return [
                'Access-Control-Allow-Credentials' => 'true',
                'Access-Control-Allow-Headers' => 'Content-Type,Authorization,Cookie,device-type',
                'Access-Control-Allow-Methods' => 'GET, POST',
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Allow-Origin' => $http_origin,
                'P3P' => 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"',
            ];
        }
        return (preg_match('/(\.get2b\.cn)$/', explode(':', $http_origin)[1] ?? '') ? [
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Allow-Headers' => 'Content-Type,Authorization,Cookie,device-type',
            'Access-Control-Allow-Methods' => 'GET, POST',
            'Access-Control-Max-Age' => 86400,
            'Access-Control-Allow-Origin' => $http_origin,
            'P3P' => 'CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"',
        ] : []);
    }

    /**
     * 返回API JSON {"code":1000,"msg":"OK","data":{..}}
     *
     * @param array  $data
     * @param int    $code
     * @param string $msg
     * @param mixed  $trace
     *
     * @return \think\Response
     */
    final public function api($data = [], $code = 1000, $msg = 'OK', $trace = null)
    {
        if(is_object($data) && method_exists($data, 'serialize')) {
            $data = $data->serialize();
        }
        if(is_array($data) && empty($data)) {
            $data = (object)$data;
        }

        $data = [ 'code' => $code, 'msg'  => $msg, 'data' => $data];

        $returnValue =  $this->json(
            $data +
            (env('APP_ENV') != 'prod' && $trace? ['trace' => $trace] : []));

        return $returnValue;
    }

    /**
     * HTTP跳转 301/302
     *
     * @param string $url
     * @param bool   $temporary 是否永久跳转
     *
     * @return \think\Response
     */
    final public function redirect($url, $temporary = true)
    {
        $this->code($temporary?302:301);
        return $this->header('location', $url);
    }
}
