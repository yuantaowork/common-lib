<?php

namespace Cmexpro\Common\Lib\Config;

/**
 * 配置管理通用类.
 * 参考用法: CFG::get('/xxx/yyy')
 *
 * @author sangechen
 */
class CFG
{

    /**
     * 配置数据, 通过CFG::get()读取.
     *
     * @var array
     */
    protected static $_data = array(

        'log' => array(
            'category' => 'common-lib',
            'file_base_name' => '/data/logs/common-lib/',
        ),

    );

    /**
     * 各自业务里面的CFG的$data是同构的, 做merge就好了.
     * @param $data
     */
    static function mergeCFG($data)
    {
        self::$_data = array_replace_recursive(self::$_data, $data);
    }

    static function getCFGTemplate()
    {
        return array(
            'mysql' => array(
                '$conf_key' => array(
                    'driver' => 'mysql',
                    'host' => '127.0.0.1',
                    'port' => 3306,
                    'database' => '库名',
                    'username' => '用户名',
                    'password' => '密码',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_bin',
                    'prefix' => '',
                    'timezone' => '+08:00',
                    'strict' => false,
                ),
            ),

            'redis' => array(
                '$conf_key' => array(
                    'host' => '127.0.0.1',
                    'port' => 6379,
                    'index' => 0,
                    'auth' => null
                ),
            ),

            'msgq' => array(
                '$conf_key' => array(
                    'host' => '127.0.0.1',
                    'port' => 5672,
                    'user' => 'mq_jjb',
                    'login' => 'mq_jjb',
                    'password' => 'pwJJB@%*258',
                    'vhost' => '/', //  /dev, /pre
                    'read_timeout' => 0,
                    'write_timeout' => 0,
                    'connect_timeout' => 0,
                    'heartbeat' => 0,
                ),
            ),

            'log' => array(
                // 通用logger配置
                // 'category' => ...
                // 'file_base_name' => ...
                // ...

                // logger名为`$name`的定制化配置, 继承自通用logger配置
                // $name 不能和前面的 key 命名冲突
                '$name' => array(
                    'category' => '打印到日志中的第2部分, 格式类似: web.jjbapi, 默认: _default_',
                    'file_base_name' => '日志文件的目录, 默认: /data/logs/_default_/',
                    'host_prefix' => '是否在日志文件名将HTTP_HOST作为前缀, 默认: true',
                    'max_files' => '最多保留多少个同类别文件, 默认: 31',
                    'level' => '只记录此level之上的日志, 默认: DEBUG',
                ),
            ),

        );
    }

    static function get($key, $def_val = null)
    {
        $array = self::$_data;

        // 若key为空, 返回整个配置
        if (empty($key)) {
            return $array;
        }

        // 若key精确匹配到
        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('/', $key) as $segment) {
            if (empty($segment)) {
                continue; // 空的话允许跳过
            } elseif (!is_array($array) || !array_key_exists($segment, $array)) {
                return $def_val; // 返回默认值
            } else {
                $array = $array[$segment]; // 进入一层
            }
        }
        return $array;
    }
}

