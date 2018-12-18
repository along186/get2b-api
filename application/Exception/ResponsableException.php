<?php
namespace App\Exception;

class ResponsableException extends \Exception
{
    const HTTP_NOT_FOUND                      = 404;
    const HTTP_METHOD_OPTION                  = 998;
    const HTTP_INTERNAL_ERROR                 = 500;

}
