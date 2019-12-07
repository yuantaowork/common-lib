<?php

/**
 * Created by PhpStorm.
 * User: 陈思池 <925.andrewchan@gmail.com>
 * Time: 26/10/2017 5:22 PM
 */

namespace Cmexpro\Common\Lib\Config;

use PHPUnit_Framework_TestCase;

class CFGTest extends PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $this->assertEmpty(CFG::get(''));
    }

    public function testMergeCFG()
    {
        $data = array(
            'mysql' => array(
                'jjb' => array(
                    'host'     => 'mysql_jjb_host',
                    'port'     => 'mysql_jjb_port',
                    'user'     => 'mysql_jjb_user',
                    'password' => 'mysql_jjb_password',
                    'charset'  => 'mysql_jjb_charset',
                    'database' => 'mysql_jjb_database'
                )
            ),
            'redis' => array(
                'jjb' => array(
                    'host'  => 'redis_jjb_host',
                    'port'  => 'redis_jjb_port',
                    'index' => 'redis_jjb_index',
                    'auth'  => 'redis_jjb_auth'
                ),
                'jll_comm' => array(
                    'host'  => 'redis_jll_comm_host',
                    'port'  => 'redis_jll_comm_port',
                    'index' => 'redis_jll_comm_index',
                    'auth'  => 'redis_jll_comm_auth'
                )
            ),
            'msgq' => array(
                'jjb' => array(
                    'host'     => 'msgq_jjb_host',
                    'port'     => 'msgq_jjb_port',
                    'user'     => 'msgq_jjb_user',
                    'password' => 'msgq_jjb_password',
                    'vhost'    => 'msgq_jjb_vhost'
                ),
                'mq_cluster' => array(
                    'host'     => 'msgq_mq_cluster_host',
                    'port'     => 'msgq_mq_cluster_port',
                    'user'     => 'msgq_mq_cluster_user',
                    'password' => 'msgq_mq_cluster_password',
                    'vhost'    => 'msgq_mq_cluster_vhost'
                )
            ),
            'haoapi' => array(
                'jjb' => array(
                    'host'        => 'haoapi_jjb_host',
                    'device_type' => 'haoapi_jjb_device_type',
                    'dt_secret'   => 'haoapi_jjb_dt_secret'
                ),
                'dgq' => array(
                    'host'        => 'haoapi_dgq_host',
                    'device_type' => 'haoapi_dgq_device_type',
                    'dt_secret'   => 'haoapi_dgq_dt_secret'
                ),
                'dgd' => array(
                    'host'        => 'haoapi_dgd_host',
                    'device_type' => 'haoapi_dgd_device_type',
                    'dt_secret'   => 'haoapi_dgd_dt_secret'
                )
            ),
            'log' => array(
                'category'       => 'log_category',
                'file_base_name' => 'log_file_base_name',
                'backup_data' => array(
                    'host_prefix' => 'log_backup_data_host_prefix',
                    'max_files'   => 'log_backup_data_max_files'
                ),

                'app_debug' => array(
                    'host_prefix' => 'log_app_debug_host_prefix',
                    'max_files'   => 'log_app_debug_max_files'
                )
            ),
        );

        CFG::mergeCFG($data);

        $this->assertEquals($data['mysql']['jjb'], CFG::get('mysql/jjb'));
        $this->assertEquals($data['redis']['jjb'], CFG::get('redis/jjb'));
        $this->assertEquals($data['redis']['jll_comm'], CFG::get('redis/jll_comm'));
        $this->assertEquals($data['msgq']['jjb'], CFG::get('msgq/jjb'));
        $this->assertEquals($data['msgq']['mq_cluster'], CFG::get('msgq/mq_cluster'));
        $this->assertEquals($data['haoapi']['jjb'], CFG::get('haoapi/jjb'));
        $this->assertEquals($data['haoapi']['dgq'], CFG::get('haoapi/dgq'));
        $this->assertEquals($data['haoapi']['dgd'], CFG::get('haoapi/dgd'));
        $this->assertEquals($data['log']['category'], CFG::get('log/category'));
        $this->assertEquals($data['log']['file_base_name'], CFG::get('log/file_base_name'));
        $this->assertEquals($data['log']['backup_data'], CFG::get('log/backup_data'));
        $this->assertEquals($data['log']['app_debug'], CFG::get('log/app_debug'));
    }
}
