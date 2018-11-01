<?php
class DatetimeUtil {
    /**
     * 时间差计算
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function format($timestamp, $short=FALSE, $needtime=TRUE) {
        if(empty($timestamp)) {
            $timestamp = time();
        } elseif ($timestamp < 0) {
            return '';
        }
        $sResult = '';
        $time = time() - $timestamp;
        if($time > 24 * 3600) {
            $iThisYear = mktime(0,0,0,1,1,intval(date("Y")));
            if ($short && $timestamp >= $iThisYear) {
                $tmp = 'm-d';
            } else {
                $tmp = 'Y-m-d';
                $needtime = false;
            }
            $tmp .= $needtime ? ' H:i' : '';
            $sResult = date($tmp, $timestamp);
        } elseif ($time > 3600) {
            $sResult = intval($time / 3600).'小时前';
        } elseif ($time > 60) {
            $sResult = intval($time / 60).'分钟前';
        } elseif ($time > 0) {
            $sResult = $time.'秒前';
        } else {
            $sResult = '现在';
        }
        return $sResult;
    }

    /**
     * UNIX时间转换为常用表示时间（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function unixTime2date($timestamp, $short=FALSE, $needtime=FALSE) {
        if ($timestamp <= 0) {
            return '';
        }
        if(empty($timestamp)) {
            $timestamp = time();
        }
        $sFormat = 'm-d';
        if (!$short) {
            $sFormat = 'Y-' . $sFormat;
        }
        if ($needtime) {
            $sFormat = $sFormat . ' H:i';
        }
        return date($sFormat, $timestamp);
    }

    /**
     * UNIX时间转换为常用表示时间（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function dateAdd($timestamp, $interval='1d') {
        if(empty($timestamp)) {
            $timestamp = time();
        }
        $date = new DateTime(self::unixTime2date($timestamp, false, true));
        date_add($date, new DateInterval("P" . strtoupper($interval)));
        return $date->format("Y-m-d");
    }

    /**
     * 当前时间（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentDate() {
        return date ( 'Y-m-d' );
    }
    /**
     * 前一天（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getLastDay() {
        return self::getLastDateCore ( "P1D" );
    }

    /**
     * 前一周（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getLastWeek() {
        return self::getLastDateCore ( "P1W" );
    }

    /**
     * 前一月（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getLastMonth() {
        return self::getLastDateCore ( "P1M" );
    }

    /**
     * 前一季节（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getLastSeason() {
        return self::getLastDateCore ( "P3M" );
    }

    /**
     *
     * @param $offset
     * @return string
     */
    private static function getLastDateCore($offset) {
        // 7 days; 24 hours; 60 mins; 60secs
        $date = new DateTime ( date ( 'Y-m-d' ) );
        date_sub ( $date, new DateInterval ( $offset ) );
        return date ( 'Y-m-d', $date->getTimestamp () );
    }

    /**
     * 取指定时间（年-月-日）
     *
     * @param $sType '1d' '1w' '1m'
     * @return String Time Format
     */
    public static function getSpecifyDateRange($sType) {
        switch (strtolower($sType)) {
            case '1d' :
                return array(self::getLastDay(), self::getCurrentDate());
            case '1w' :
                return array(self::getLastWeek(), self::getCurrentDate());
            case '1m' :
                return array(self::getLastMonth(), self::getCurrentDate());
            case '1s' :
                return array(self::getLastSeason(), self::getCurrentDate());
            default :
                return array('', '');
        }
    }

    /**
     * 本周开始（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentWeekStart() {
        return date("Y-m-d ",mktime(0, 0, 0,date("m"),date("d")-date("w")+1,date("Y")));
    }

    /**
     * 本周结束（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentWeekEnd() {
        return date("Y-m-d ",mktime(23,59,59,date("m"),date("d")-date("w")+7,date("Y")));
    }

    /**
     * 本月开始（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentMonthStart() {
        return date("Y-m-d ",mktime(0, 0, 0,date("m"),1,date("Y")));
    }

    /**
     * 本月结束（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentMonthEnd() {
        return date("Y-m-d ",mktime(23,59,59,date("m"),date("t"),date("Y")));
    }


    /**
     * 本季度开始（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentSeasonStart() {
        return date('Y-m-d ', mktime(0, 0, 0,date('n')-(date('n')-1)%3,1,date('Y')));
    }

    /**
     * 本季度结束（年-月-日）
     *
     * @param Timestamp $time
     * @return String Time Format
     */
    public static function getCurrentSeasonEnd() {
        //本季度未最后一月天数
        $getMonthDays = date("t",mktime(0, 0, 0,date('n')+(date('n')-1)%3,1,date("Y")));
        return date('Y-m-d ', mktime(23,59,59,date('n')+(date('n')-1)%3 + 2,$getMonthDays,date('Y')));
    }

    /**
     * 取指定时间（年-月-日）
     *
     * @param $sType '1d' '1w' '1m'
     * @return String Time Format
     */
    public static function getCurrentDateRange($sType) {
        switch (strtolower($sType)) {
            case '1d' :
                return array(self::getCurrentDate(), self::getCurrentDate());
            case '1w' :
                return array(self::getCurrentWeekStart(), self::getCurrentWeekEnd());
            case '1m' :
                return array(self::getCurrentMonthStart(), self::getCurrentMonthEnd());
            case '1s' :
                return array(self::getCurrentSeasonStart(), self::getCurrentSeasonEnd ());
            default :
                return array('', '');
        }
    }
}
