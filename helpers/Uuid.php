<?php

namespace wartron\yii2uuid\helpers;

use Rhumsaa\Uuid\Uuid as BaseUuid;

use Yii;

class Uuid
{
    static public $defaultStrategy = 'uuid1';

    public static function setStrategy($strategy)
    {
        self::$defaultStrategy = $strategy;
    }

    public static function uuid($strategy = null)
    {
        if(!$strategy)
            $strategy = self::$defaultStrategy;

        switch ($strategy) {
            case 'uuid1':
                return self::uuid1();
                break;
            case 'uuid3':
                return self::uuid3();
                break;
            case 'uuid4':
                return self::uuid4();
                break;
            case 'uuid5':
                return self::uuid5();
                break;
            case 'sql':
                return Yii::$app->getDb()->createCommand("SELECT UNHEX(REPLACE(UUID(),'-',''))")->queryScalar();
                break;
            default:
                throw new \Exception("Invalid UUID Strategy '$strategy'", 1);

                break;
        }
    }

    public static function uuid1($node = null, $clockSeq = null)
    {
        return self::bin(BaseUuid::uuid1($node,$clockSeq));
    }

    public static function uuid3($ns, $name)
    {
        return self::bin(BaseUuid::uuid3($ns, $name));
    }

    public static function uuid4()
    {
        return self::bin(BaseUuid::uuid4());
    }

    public static function uuid5($ns, $name)
    {
        return self::bin(BaseUuid::uuid5($ns, $name));
    }

    public static function bin($uuid)
    {
        return hex2bin(str_replace('-','', $uuid));
    }

    public static function str2uuid($s)
    {
        if(!$s) return null;
        if(strlen($s)==32)
            return hex2bin($s);
        return $s;
    }

    public static function uuid2str($u)
    {
        if(!$u) return null;
        if(strlen($u)==16)
            return strtoupper(bin2hex($u));
        return $u;
    }

}