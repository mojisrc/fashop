<?php
/**
 *
 */
namespace App\HttpController\Admin;
use App\Utils\Db;
use App\Utils\Storage;
use ezswoole\Cache;

/**
 * 安装
 * Class Install
 * @package App\HttpController\Admin
 */
class Install extends Admin {
	public function _initialize() {
		parent::_initialize();
	}

	public function index() {
		$host   = request()->host();
		$port   = \Conf\Config::getInstance()->getConf("SERVER.PORT");
		$url    = '';
		$ip_arr = array('i.0.0.1', '0.0.0.1', '59.110.140.150');
		if (in_array($host, $ip_arr)) {
			$url = "{$host}:{$port}";
		} else {
			$url = $host;
		}
		return $this->View('Install/index');
	}
	/**
	 * 检测本地环境是否符合当前安装要求
	 */
	public function configure() {
		header("Content-Type:text/html;charset=utf-8");
		$testing = array();
		session('error', false);
		//环境检测
		$env       = check_env();
		$configure = $env;

		// //目录文件读写检测
		if (IS_WRITE) {
			$dirfile      = check_dirfile();
			$jurisdiction = $dirfile;
		}
		session('step', 1);
		return $this->View('Install/configure', ['jurisdiction' => $jurisdiction, 'configure' => $configure]);
	}

	//创建数据库
	public function establishDb() {
		if ($this->post) {
			$post  = $this->post;
			$admin = $post['admin']; //临时手动添加数据
			$db    = $post['db']; //临时手动添加数据
			//检测管理员信息
			if (!is_array($admin) || empty($admin[0]) || empty($admin[1])) {
				$this->send(-1, [], '请填写完整管理员信息');
			} else if ($admin[1] != $admin[2]) {
				$this->send(-1, [], '确认密码和密码不一致');
			} else {
				$info                                                           = array();
				list($info['username'], $info['password'], $info['repassword']) = $admin;
				//缓存管理员信息
				session('admin_info', $info);
			}
			// //检测数据库配置
			if (!is_array($db) || empty($db[0]) || empty($db[1]) || empty($db[2]) || empty($db[3])) {
				$this->send(-1, [], '请填写完整的数据库配置');
			} else {
				$DB = array();
				list($DB['DB_TYPE'], $DB['DB_HOST'], $DB['DB_NAME'], $DB['DB_USER'], $DB['DB_PWD'],
					$DB['DB_PORT'], $DB['DB_PREFIX']) = $db;
				//缓存数据库配置
				session('db_config', $DB);

				//创建数据库
				$dbname = $DB['DB_NAME'];
				unset($DB['DB_NAME']);
				$db = Db::getInstance($DB);

				$sql = "CREATE DATABASE IF NOT EXISTS `{$dbname}` DEFAULT CHARACTER SET utf8";
				if (!$db->execute($sql)) {
					$this->send(-1, [], $db->getError());
				} else {
					session('step', 2);
					// 跳转到数据库安装页面
					$this->response()->redirect("/Admin/Install/createSheet");
				}
			}

		} else {
			if (session('error') === true) {
				$this->send(-1, [], '环境检测没有通过，请调整环境后重试！');
			}
			$step = session('step');
			if ($step != 1 && $step != 2) {
				// 跳转到入口文件index.php
				$this->response()->redirect("http://59.110.140.150:9505");
			} else {
				return $this->View('Install/establishDb');
			}

		}
	}

	//安装第三步，安装数据表，创建配置文件
	public function createSheet() {
		if (session('step') != 2) {
			$this->response()->redirect("/Admin/Install/establishDb");
		}
		//连接数据库
		$dbconfig = session('db_config');
		$db       = Db::getInstance($dbconfig);
		//创建数据表
		create_tables($db, $dbconfig['DB_PREFIX']);

		//注册创始人帐号
		$auth  = build_auth_key();
		$admin = session('admin_info');
		register_administrator($db, $dbconfig['DB_PREFIX'], $admin, $auth);
		//创建配置文件
		$conf = write_config($dbconfig, $auth);

		session('config_file', $conf);
		$msg = Cache::getInstance()->get('msg');
		session('step', 3);
		// error为true代表有错误
		return $this->View('Install/createSheet', ['msg' => $msg, 'error' => session('error')]);

		// $this->response()->redirect('/Admin/Install/complete');

	}

	//安装完成
	public function complete() {
		$step = session('step');
		if (!$step) {
			$this->response()->redirect('/Admin/Install/index');
		} elseif ($step == 2) {
			$this->response()->redirect("/Admin/Install/createSheet");
		} elseif ($step == 1) {
			$this->response()->redirect("/Admin/Install/establishDb");
		}
		Storage::put(ROOT . '/Data/install.lock', 'lock');

		//创建配置文件
		$this->assign('info', session('config_file'));

		session('step', null);
		session('error', null);
	}

}
