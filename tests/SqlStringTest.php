<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/16
 * Time: 下午10:32
 *
 */

namespace FaShopTest;

class SplStringTest extends \PHPUnit\Framework\TestCase
{
	public function testSplit()
	{
		$class = new \EasySwoole\Core\Component\Spl\SplString('EasySwoole');
		$array = $class->split(2);
		$this->assertInstanceOf('\EasySwoole\Core\Component\Spl\SplArray', $array);
	}
	public function testExplode(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('Easy,Swoole');
		$array = $class->explode(',');
		$this->assertInstanceOf('\EasySwoole\Core\Component\Spl\SplArray', $array);
	}
	public function testSubString(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('EasySwoole');
		$class->subString(0,4);
		$this->assertEquals('Easy', $class->__toString());
	}
	public function testEncodingConvert(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('EasySwoole');
		$class->encodingConvert('UTF-8');
		$this->assertEquals('UTF-8', mb_detect_encoding($class->__toString(),'UTF-8'));
	}
	public function testUtf8(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('韩文博');
		$class->encodingConvert('GBK')->encodingConvert('UTF-8');
		$this->assertEquals('UTF-8', mb_detect_encoding($class->__toString(),'UTF-8'));
	}
	public function testUnicodeToUtf8(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('\u97e9\u6587\u535a');
		$class->unicodeToUtf8();
		$this->assertEquals('韩文博', $class->__toString());
	}
	public function testCompare(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo');
		$this->assertEquals(2, $class->compare('hanwen'));
	}
	public function testLTrim(){
		$class = new \EasySwoole\Core\Component\Spl\SplString(' hanwenbo');
		$this->assertEquals('hanwenbo', $class->ltrim());
	}
	public function testRTrim(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo ');
		$this->assertEquals('hanwenbo', $class->rtrim());
	}
	public function testTrim(){
		$class = new \EasySwoole\Core\Component\Spl\SplString(' hanwenbo ');
		$this->assertEquals('hanwenbo', $class->trim());
	}
	public function testPad(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('EasySwoole');
		$class->pad(20,'.');
		$this->assertEquals("EasySwoole..........",$class->__toString());
	}
	public function testRepeat(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo');
		$class->repeat(2);
		$this->assertEquals("hanwenbohanwenbo",$class->__toString());
	}
	public function testLength(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo');
		$this->assertEquals(8,$class->length());
	}
	public function testUpper(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo');
		$this->assertEquals('HANWENBO',$class->upper()->__toString());
	}
	public function testLower(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('HANWENBO');
		$this->assertEquals('hanwenbo',$class->lower()->__toString());
	}
	public function testStripTags(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('<html>HANWENBO</html>');
		$this->assertEquals('hanwenbo',$class->lower()->stripTags()->__toString());
	}
	public function testReplace(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo');
		$this->assertEquals('xiaowenbo',$class->replace('han','xiao')->__toString());
	}
	public function testBetween(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('hanwenbo');
		$this->assertEquals('wen',$class->between('han','bo')->__toString());
	}
	public function testRegex(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('http://www.easyswoole.com/index.html');
		$this->assertEquals('http://www.easyswoole.com',$class->regex("@^(?:http://)?([^/]+)@i"));
	}
	public function testExist(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('http://www.easyswoole.com/index.html');
		$this->assertEquals(true,$class->exist("easyswoole"));
	}
	public function testKebab(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('HanWenBo');
		$this->assertEquals('han-wen-bo',$class->kebab()->__toString());
	}
	public function testSnake(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('HanWenBo');
		$this->assertEquals('han_wen_bo',$class->snake('_')->__toString());
	}
	public function testStudly(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('User_info-Profile-goods_message');
		$this->assertEquals('UserInfoProfileGoodsMessage',$class->studly()->__toString());
	}
	public function testCamel(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('User_info-Profile-goods_message');
		$this->assertEquals('userInfoProfileGoodsMessage',$class->camel()->__toString());
	}
	public function testReplaceArray(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('你好啊，你在吗');
		$this->assertEquals('我好啊，他在吗',$class->replaceArray('你',['我','他'])->__toString());
	}
	public function testReplaceFirst(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('你好啊，你在吗');
		$this->assertEquals('我好啊，你在吗',$class->replaceFirst('你','我')->__toString());
	}
	public function testReplaceLast(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('你好啊，你在吗，你在吗');
		$this->assertEquals('你好啊，你在吗，他在吗',$class->replaceLast('你','他')->__toString());
	}
	public function testStart(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('user_table');
		$this->assertEquals('easyswoole_user_table',$class->start('easyswoole_')->__toString());
	}
	public function testAfter(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('easyswoole.user.png');
		$this->assertEquals('user.png',$class->after('.')->__toString());
	}
	public function testBefore(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('easyswoole.jpg');
		$this->assertEquals('easyswoole',$class->before('.')->__toString());
	}
	public function testEndsWith(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('easyswoole.jpg');
		$this->assertEquals(true,$class->endsWith(['png','gif','jpg']));
	}
	public function testStartsWith(){
		$class = new \EasySwoole\Core\Component\Spl\SplString('easyswoole.jpg');
		$this->assertEquals(true,$class->startsWith(['e','easyswoole','es']));
	}
}