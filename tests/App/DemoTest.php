<?php
/*
 * @Date         : 2022-03-02 14:49:25
 * @LastEditors  : Jack Zhou <jack@ks-it.co>
 * @LastEditTime : 2022-03-02 17:22:16
 * @Description  : 
 * @FilePath     : /recruitment-php-code-test/tests/App/DemoTest.php
 */

namespace Test\App;

use PHPUnit\Framework\TestCase;
use App\Service\AppLogger;
use App\Util\HttpRequest;



class DemoTest extends TestCase {
    public function test_foo() {
        $this->assertEquals('bar',Demo::foo());
    }

    /**
     *@dataProvider userInfoSuccessProvider
     * @param $except
     */
    public function test_get_user_info_success($except)
    {
        $logger = new AppLogger();
        $req = new HttpRequest();
        $this->assertEquals($except, (new Demo($logger,$req))->get_user_info());
    }


    public function userInfoSuccessProvider()
    {
        return [
            [json_encode([
                'error' => 0,
                'data' =>[
                    'id'=> 1,
                    'username'=>'hello world'
                ]
            ])]
        ];
    }


}