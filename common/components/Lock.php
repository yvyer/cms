<?php
namespace common\components;

use Yii;

class Lock {

    const DEFAULT_EXPIRE = 10;//默认时效 秒
    const DEFAULT_WAIT = 3;//秒
    const DEFAULT_WAIT_SEC = 100;//毫秒
    const DEFAULT_VALUE = 1;

    /**
     * 互斥锁
     * @param string $lock_id
     * @param $expire
     * @return bool
     */
    public static function mutexLock($lock_id = '', $expire = self::DEFAULT_EXPIRE) {
        $lock = Yii::$app->redis->setnx($lock_id, 1);
        if (!$lock) {
            return false;
        }
        Yii::$app->redis->expire($lock_id, $expire);
        return true;
    }

    /**
     * 阻塞锁
     * @param $lock_id
     * @param $expire
     * @param $wait_time
     * @return bool
     */
    public static function blockLock($lock_id, $expire = self::DEFAULT_EXPIRE, $wait_time = self::DEFAULT_WAIT ) {
        $ret = self::mutexLock($lock_id, $expire);
        if($ret){
            return true;
        }else{
            $i = 0;
            $num = intval(($wait_time*1000)/self::DEFAULT_WAIT_SEC);
            while($i < $num){
                $ret = self::mutexLock($lock_id, $expire);
                if($ret){
                    return true;
                }else{
                    usleep(self::DEFAULT_WAIT_SEC*1000);
                    $i++;
                }
            }
            return false;
        }
    }

    /**
     * 释放锁
     * @param string $lock_id
     * @return bool
     */
    public static function unlock($lock_id = '') {
        $ret = Yii::$app->redis->del($lock_id);
        return $ret?true:false;
    }
}