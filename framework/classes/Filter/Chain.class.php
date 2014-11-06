<?php
namespace framework\classes\Filter;
use framework\classes\Http\Request;
use framework\classes\Http\Response;

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 02.11.2014
 * Time: 22:05
 */

class Chain implements Filter_Interface{
    private $filters = array();
    private $response = null;
    private $request = null;

    public function addFilter(Filter_Interface $filter)
    {
        $this->filters[] = $filter;
    }

    public function execute(Request $req, Response $res)
    {
        foreach($this->filters as $filter)
        {
            $filter->execute($req, $res);
        }
    }
} 