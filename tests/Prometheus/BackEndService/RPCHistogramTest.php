<?php
/**
 * Created by PhpStorm.
 * User: sangechen
 * Date: Jun-01
 * Time: 18:22
 */

namespace Cmexpro\Common\Lib\Prometheus\BackEndService;

use PHPUnit_Framework_TestCase;

class RPCHistogramTest extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testCategory()
    {
        RPCHistogram::category('test1')->labels(['service' => 'java-proxy'])->stat(123);

        RPCHistogram::init('test2', ['from' => 'xxx']);
        RPCHistogram::get()->stat(321);
    }
}
