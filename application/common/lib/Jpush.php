<?php

namespace app\common\lib;

/**
 * 极光推送封装
 * Class Jpush
 *
 * @package \app\common\lib
 */
class Jpush
{
    /**
     * @param        $title
     * @param int    $newId
     * @param string $type
     */
    public static function push($title,$newId = 0, $type='android')
    {


        try {
            $app_key = '66843dcb64c55c53714913bb';
            $master_secret = '26d15c559d7094202455fde4';
            $client = new \JPush\Client($app_key, $master_secret);


            $client->push()
                ->addAllAudience()
                ->setPlatform(array('ios', 'android'))
                ->setNotificationAlert($title)
                ->androidNotification($title, array(
                    'title' => $title,
                    // 'builder_id' => 2,
                    'extras' => array(
                        'id' => $newId,
//                    'jiguang'
                    ),
                ))
                ->send();
        }catch (\Exception $e){
            echo $e->getMessage();
        }

        return true;
    }
}
