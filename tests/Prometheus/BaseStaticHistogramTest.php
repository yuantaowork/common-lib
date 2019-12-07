<?php
/**
 * Created by PhpStorm.
 * User: sangechen
 * Date: Jun-01
 * Time: 18:00
 */

namespace Cmexpro\Common\Lib\Prometheus;

use PHPUnit_Framework_TestCase;

class BaseStaticHistogramTest extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testCategory()
    {
        BaseStaticHistogram::category('test1'); //ok

        BaseStaticHistogram::category('test-1'); //errorLog, return `_test1`

        BaseStaticHistogram::init('test2');
        BaseStaticHistogram::get(); // return `test2`
    }
}
