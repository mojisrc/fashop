<?php
/**
 * Created by IntelliJ IDEA.
 * User: chenmeng
 * Date: 2018/11/28
 * Time: 23:35
 */

namespace App\Utils;
define('PI',3.1415926535898);

define('EARTH_RADIUS',6378.137);
class Coordinate{


    public function coordinate_switch($a,$b){//百度转腾讯坐标转换


        $x = (double)$b - 0.0065;
        $y = (double)$a - 0.006;
        $x_pi = 3.14159265358979324;
        $z = sqrt($x * $x+$y * $y) - 0.00002 * sin($y * $x_pi);

        $theta = atan2($y,$x) - 0.000003 * cos($x*$x_pi);

        $gb = number_format($z * cos($theta),15);
        $ga = number_format($z * sin($theta),15);


        return ['lat'=>$ga,'lng'=>$gb];

    }

    public function coordinate_switchf($a,$b){//腾讯转百度坐标转换


        $x = (double)$b ;
        $y = (double)$a;
        $x_pi = 3.14159265358979324;
        $z = sqrt($x * $x+$y * $y) + 0.00002 * sin($y * $x_pi);

        $theta = atan2($y,$x) + 0.000003 * cos($x*$x_pi);

        $gb = number_format($z * cos($theta) + 0.0065,6);
        $ga = number_format($z * sin($theta) + 0.006,6);


        return ['lat'=>$ga,'lng'=>$gb];

    }

    public function getDistance($lat1, $lng1, $lat2, $lng2){
        $radLat1 = $lat1 * (PI / 180);
        $radLat2 = $lat2 * (PI / 180);
        $a = $radLat1 - $radLat2;
        $b = ($lng1 * (PI / 180)) - ($lng2 * (PI / 180));
        $s = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1)*cos($radLat2)*pow(sin($b/2),2)));
        $s = $s * EARTH_RADIUS;
        $s = round($s * 10000) / 10000;
        return $s;
    }

    public function getDistanceNew($lat1, $lng1, $lat2, $lng2){
        $ak = 'pxBudaGK5Aez1hbfs5FQs1D5Ng0c19nH';//您的百度地图ak，可以去百度开发者中心去免费申请
        $distance = array();
        $distance['distance'] = 0.00;//距离 公里
        $distance['duration'] = 0.00;//时间 分钟
        $url = 'http://api.map.baidu.com/routematrix/v2/driving?output=json&origins='.$lat1.','.$lng1.'&destinations='.$lat2.','.$lng2.'&ak='.$ak;
        $data = file_get_contents($url);
        $data = json_decode($data,true);
        if (!empty($data) && $data['status'] == 0) {
            $distance['distance'] =preg_replace('/[^\.0123456789]/s', '', $data['result'][0]['distance']['text']); //计算距离
        }
        return $distance['distance'];
    }
}