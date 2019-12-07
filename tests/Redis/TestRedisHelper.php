<?php

/**
 * Created by PhpStorm.
 * User: 陈思池 <925.andrewchan@gmail.com>
 * Time: 27/10/2017 5:11 PM
 */

namespace Cmexpro\Common\Lib\Redis;

use Cmexpro\Common\Lib\Config\CFG;
use PHPUnit_Framework_Error_Warning;
use PHPUnit_Framework_TestCase;

class TestRedisHelper extends PHPUnit_Framework_TestCase
{
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        CFG::mergeCFG(array(
            'redis' => array(
                'jjb' => array(
                    'host'  => '127.0.0.1',
                    'port'  => 6379,
                    'index' => 0,
                    'auth'  => null
                )
            ),
            'log' => array(
                'category'       => 'composer.common-lib.redis',
                'file_base_name' => '/tmp/logs/common-lib/redis/',
            ),
        ));
    }

    public function testGetConn()
    {
        // 正确配置连接
        $redis = RedisHelper::getConn('jjb');

        $this->assertEquals('+PONG', $redis->ping());
    }

    /**
     * @expectedException PHPUnit_Framework_Error_Warning
     * @expectedExceptionCode 2
     */
    public function testGetConnErrorCfg()
    {
        // 错误配置连接
        CFG::mergeCFG(array(
            'redis' => array(
                'dgq' => array(
                    'port' => 16379,
                    'auth' => null
                )
            )
        ));
        RedisHelper::getConn('dgq');
    }

    public function testGetConnNoThrow()
    {
        // 正确配置连接
        $redis = RedisHelper::getConn_nothrow('jjb');

        $this->assertEquals('+PONG', $redis->ping());
    }

    public function testGetConnNoThrowErrorCfg()
    {
        // 错误连接配置
        CFG::mergeCFG(array(
            'redis' => array(
                'dgq' => array(
                    'port' => 16379,
                    'auth' => null
                )
            )
        ));
        $redis = RedisHelper::getConn_nothrow('dgq');

        $this->assertEquals('Cmexpro\Common\Lib\Redis\RedisHelper', get_class($redis));
    }

    public function tearDown()
    {
        @rmdir('/tmp/logs/common-lib/redis/');
        @rmdir('/tmp/logs/common-lib/');
        @rmdir('/tmp/logs/');
        parent::tearDown(); // TODO: Change the autogenerated stub
    }
}