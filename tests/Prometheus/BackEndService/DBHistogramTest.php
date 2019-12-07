<?php
/**
 * Created by PhpStorm.
 * User: sangechen
 * Date: Jun-01
 * Time: 18:22
 */

namespace Cmexpro\Common\Lib\Prometheus\BackEndService;

use PHPUnit_Framework_TestCase;

class DBHistogramTest extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testCategory()
    {
        DBHistogram::category('test1')->labels(['table' => 'table1'])->stat(123);

        DBHistogram::init('test2', ['from' => 'xxx']);
        DBHistogram::get()->stat(321);
    }
}
