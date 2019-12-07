<?php
/**
 * Created by PhpStorm.
 * User: sangechen
 * Date: Jun-01
 * Time: 18:10
 */

namespace Cmexpro\Common\Lib\Prometheus\Application;

use PHPUnit_Framework_TestCase;

class TaskHistogramTest extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    public function testCategory()
    {
        TaskHistogram::category('test1')->labels(['task' => 'ijk'])->stat(123);

        TaskHistogram::init('test2', ['task' => 'ijk2']);
        TaskHistogram::get()->stat(321);
    }
}
