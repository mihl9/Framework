<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 22:17
 */

class Filter_Big implements \framework\classes\Filter\Filter_Interface
{
    public function execute(\framework\classes\Http\Request $request, \framework\classes\Http\Response $response)
    {
        $txt = $response->getContent();
        $txt = strtoupper($txt);
        $response->replaceContent($txt);
    }
}