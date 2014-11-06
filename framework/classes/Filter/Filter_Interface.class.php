<?php
namespace framework\classes\Filter;
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 22:02
 */

interface Filter_Interface {
    public function execute(\framework\classes\Http\Request $request,\framework\classes\Http\Response $response);
} 