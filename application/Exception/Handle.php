<?php

namespace App\Exception;

use \Exception;
use App\Library\Response;
use think\exception\Handle as ThinkHandle;
use Log;

class Handle extends ThinkHandle
{
    public function render(Exception $e)
    {
        if ($e->getCode() == ResponsableException::HTTP_METHOD_OPTION) {
            return (new Response)->header((new Response)->cors())->code(204);
        }

        if(preg_match('/^(module|controller|method) not exists/', $e->getMessage())) {
            return (new Response)->api([], ResponsableException::HTTP_NOT_FOUND, 'HTTP NOT FOUND');
        }

        if ($e instanceof ResponsableException || env('APP_ENV') != 'prod') {
            $trace = $e->getTrace();
            $trace_return = [];
            foreach($trace as $trace_item)
            {
                if(isset($trace_item['file']) && preg_match('/think\/App\.php$/', $trace_item['file'])) break;
                $trace_return[] = $trace_item;
            }
            return (new Response)->api([], $e->getCode(), $e->getMessage(), $trace_return);
        } else {
            return (new Response)->api([], ResponsableException::HTTP_INTERNAL_ERROR, '系统异常');
        }
    }

}
