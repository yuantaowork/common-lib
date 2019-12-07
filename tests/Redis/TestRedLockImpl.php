<?php
namespace Cmexpro\Common\Lib\Redis;

use Cmexpro\Common\Lib\Config\CFG;
use Cmexpro\Common\Lib\Log\LOG;
use PHPUnit_Framework_TestCase;

class TestRedLockImpl extends PHPUnit_Framework_TestCase
{

    private $conf_key;

    private $lock_key_name;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        CFG::mergeCFG(array(
            'redis' => array(
                'jjb' => array(
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'index' => 0,
                    'auth' => null
                )
            ),
            'log' => array(
                'category' => 'composer.common-lib.redis-lock',
                'file_base_name' => '/tmp/logs/common-lib/redis-lock/'
            )
        ));

        $this->conf_key = 'jjb';
        $this->lock_key_name = 'test__red_lock_impl__lock';
    }

    private function checkLockValue($value)
    {
        $this->assertEquals($value, RedisHelper::getConn($this->conf_key)->get($this->lock_key_name));
    }

    public function setUp()
    {
        $ret = RedLockImpl::lock($this->conf_key, $this->lock_key_name);
        $this->assertSame(true, $ret);
        $this->checkLockValue(LOG::getTraceId());
    }

    public function testRetreenLock()
    {
        $ret = RedLockImpl::lock($this->conf_key, $this->lock_key_name, 'testRetreenLock');
        printf("lock() -> %s\n", var_export($ret, true));

        $this->assertFalse($ret);
        $this->checkLockValue(LOG::getTraceId());
    }

    public function testUnlockMismatch()
    {
        $ret = RedLockImpl::unlock($this->conf_key, $this->lock_key_name, 123456);
        printf("unlock() -> %s\n", var_export($ret, true));

        $this->assertEquals(LOG::getTraceId(), $ret);
        $this->checkLockValue(LOG::getTraceId());
    }

    public function testUnlockEmpty()
    {
        RedLockImpl::unlock($this->conf_key, $this->lock_key_name); // 先解锁掉


        $ret = RedLockImpl::unlock($this->conf_key, $this->lock_key_name, 123456);
        printf("unlock() -> %s\n", var_export($ret, true));

        // https://github.com/phpredis/phpredis#class-redis
        // https://github.com/ukko/phpredis-phpdoc/blob/6dc713f339a02b9ce0d84b8b3c95a2c3ad6ef196/src/Redis.php#L209
        $ret = RedisHelper::getConn($this->conf_key)->get($this->lock_key_name);
        printf("cur_value: %s\n", var_export($ret, true));
        $this->assertEquals('', $ret);


        RedLockImpl::lock($this->conf_key, $this->lock_key_name); // 再加锁回来
    }

    public function tearDown()
    {
        $ret = RedLockImpl::unlock($this->conf_key, $this->lock_key_name);
        $this->assertSame(1, $ret);
        $this->checkLockValue('');

        @rmdir('/tmp/logs/common-lib/redis-lock/');
        @rmdir('/tmp/logs/common-lib/');
        @rmdir('/tmp/logs/');
        parent::tearDown();
    }
}

