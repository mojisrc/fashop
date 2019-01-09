<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/24
 * Time: 下午8:22
 *
 */

namespace FaShopTest;
use PHPUnit\Framework\TestCase;
use EasySwoole\Core\Component\Spl\SplArray;
use FaShopTest\utils\Curl;
use GuzzleHttp\Client;
use App\Utils\Code;
use ezswoole\Db;
use FaShopTest\framework\Config;

/**
 * Class BaseTestCase
 * @package FaShopTest
 */
abstract class BaseTestCase extends TestCase
{
	protected static $initIsEnd = false;
	protected static $config;
	/**
	 * @var \FaShopTest\utils\Curl
	 */
	protected static $curl;


	/**
	 * @var \App\Utils\Code
	 */
	protected static $code;

    protected static $base_arr;
	/**
	 * @var string
	 */
	protected static $accessToken;
	/**
	 * @var \ezswoole\Db;
	 */
	protected static $db;


    protected static $client;



    //throw new \InvalidArgumentException(self::$accessToken);


    public final function __construct()
    {
        parent::__construct();
        $client_conf = Config::get();
        self::$base_arr = $client_conf['client'];
        self::$base_arr['headers'] = ['access_token' => self::$accessToken];
        self::$client = new Client(self::$base_arr);
    }

    protected static function getAccessToken() : string
	{
        if( !self::$accessToken ) {
            $response = self::$client->request('POST', 'admin/member/login', [
                'form_params' => [
                    'username' => self::getTestConfig()->login['username'],
                    'password' => self::getTestConfig()->login['password'],
                ],
            ]);
            $return_data = json_decode($response->getBody(), true);

            self::$accessToken = $return_data['result']['access_token'];

            self::$base_arr['headers'] = ['access_token' => self::$accessToken];
            self::$client = new Client(self::$base_arr);
        }
        return self::$accessToken;
	}


	public static function setUpBeforeClass()
	{
		self::initConfig();

		self::initCurl();

//		self::initDb();

		self::$code = new Code;

		self::$initIsEnd = true;

//		$this->__instance();
	}

	public static function tearDownAfterClass()
	{
		self::$db = null;
	}

	private static function initDb()
	{
//	    2018-12-25
//		\ezswoole\FaShop::register();

		self::$db = new Db();
	}

	protected static function initCurl()
	{
		self::$curl = new Curl();
		self::$curl->setBaseUrl( self::getTestConfig()->url );
		self::$curl->setAccessToken( self::getAccessToken() );
	}

	protected static function initConfig()
	{
		$config = [
			'url'      => 'http://127.0.0.1:9510/',
			'register' => [
				'username' => 'admin',
			],
			'login'    => [
				'username' => 'admin',
				'password' => '123456',
			],
		];

		$splArray = new SplArray( $config );
		self::setTestConfig( $splArray );
	}

	protected static  function setTestConfig( SplArray $array ) : void
	{
		self::$config = $array;
	}

	protected static  function getTestConfig() : SplArray
	{
		return self::$config;
	}

	public function __instance()
	{

	}
}

?>