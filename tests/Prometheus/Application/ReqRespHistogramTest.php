<?php
/**
 * Created by PhpStorm.
 * User: sangechen
 * Date: Jun-01
 * Time: 18:10
 */

namespace Cmexpro\Common\Lib\Prometheus\Application;

use PHPUnit_Framework_TestCase;

class ReqRespHistogramTest extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testCategory()
    {
        ReqRespHistogram::category('test1')->labels(['uri' => 'abc/xyz'])->stat(123);

        ReqRespHistogram::init('test2', ['os' => 'ios']);
        ReqRespHistogram::get()->labels(['uri' => 'abc/xyz'])->stat(321);
    }
}
