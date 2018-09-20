<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;

class Page extends Validate
{
	protected $rule
		= [
			'id'               => 'require',
			'name'             => 'require',
			'background_color' => 'require',
			'body'             => 'require|array|checkBody',
			'type'             => 'require|checkType',
			'module'           => 'require|checkModule',
		];
	protected $message
		= [
			'id.require'               => 'ID必填',
			'name.require'             => '模板名称必填',
			'background_color.require' => '模板背景色彩必填',
			'body.require'             => '模板内容必填',
			'body.array'               => '模板内容必须是数组',
			'type.require'             => '类型必填',
			'module.require'           => '模块名字必填',
		];
	protected $scene
		= [
			'add' => [
				'name',
				'body',
				'background_color',
				'module',
			],

			'edit'      => [
				'id',
				'name',
				'background_color',
				'body',
				'module',
			],
			'setPortal' => [
				'id',
			],

		];

	/**
	 * 检测模块名称
	 * @method
	 * @param mixed $value 验证参数
	 * @param mixed $rule  验证规则
	 * @param array $data  数据
	 */
	protected function checkModule( $value, $rule, $data )
	{
		if( !$this->in( $value, ['mobile', 'wechat_mini', 'app'] ) ){
			return '模块类型不正确';
		}
		return true;
	}

	/**
	 * 检测模板内容
	 * @method
	 * @param mixed $value 验证参数
	 * @param mixed $rule  验证规则
	 * @param array $data  数据
	 */
	protected function checkBody( $bodys, $rule, $data )
	{
		if( empty( $bodys ) || !is_array( $bodys ) ){
			return '模板内容错误';
		} else{
			foreach( $bodys as $body ){
				switch( $body['type'] ){
				case 'goods':
					$goods_result = $this->checkGoods( $body['data'] );
					if( $goods_result !== true ){
						return '商品配置'.$goods_result;
					}
					if( !isset( $body['options'] ) || !is_array( $body['options'] ) ){
						return '商品配置项有误';
					}
					if( !isset( $body['options']['layout_style'] ) ){
						return '商品配置错误：布局方式必选';
					}
					if( !$this->between( $body['options']['layout_style'], [1, 4] ) ){
						return '商品配置错误：布局方式必须是1-4';
					}
				break;
				case 'goods_list':
//					$goods_result = $this->checkGoodsList( $body['data'] );
//					if( $goods_result !== true ){
//						return '商品列表'.$goods_result;
//					}
					if( empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 4 ){
						return '商品列表配置项有误';
					}
					if( !isset( $body['options']['goods_sort'] ) ){
						return '商品列表错误：商品排序必填';
					}
					if( !isset( $body['options']['goods_display_num'] ) ){
						return '商品列表错误：显示数量必填';
					}
					if( !isset( $body['options']['goods_display_field'] ) || empty( $body['options']['goods_display_field'] ) || !is_array( $body['options']['goods_display_field'] ) || count( $body['options']['goods_display_field'] ) < 1 ){
						return '商品列表错误：显示内容必填';
					}
					if( !isset( $body['options']['layout_style'] ) ){
						return '商品列表错误：展示形式必填';
					}
					if( !$this->in( $body['options']['goods_sort'], [1, 2, 3] ) ){
						return '商品列表错误：商品排序必须是最新商品（上架从晚到早）,最热商品（销量从高到低）,商品排序（序号有大到小）';
					}
					if( !$this->in( $body['options']['goods_display_num'], [6, 12, 18] ) ){
						return '商品列表错误：显示数量必须是前6个商品 ,前12个商品 ,前18个商品';
					}
					if( !$this->in( $body['options']['layout_style'], [1, 2, 3, 4] ) ){
						return '商品列表错误：展示形式必须是大图 ,小图 ,一大两小 ,列表';
					}
				break;
				case 'goods_search':
					if( !isset( $body['options']['background_color'] ) ){
						return '商品搜索配置项有误';
					}
				break;
				case 'separator':
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 2 ){
						return '分割线配置项有误';
					}
					if( !isset( $body['options']['color'] ) ){
						return '分割线错误：颜色必填';
					}
					if( !isset( $body['options']['style'] ) ){
						return '分割线错误：样式必填';
					}
					if( !$this->in( $body['options']['style'], ['dotted', 'solid'] ) ){
						return '分割线错误：样式必须是虚线 ,实线';
					}
				break;
				case 'auxiliary_blank':
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 1 ){
						return '辅助空白配置项有误';
					}
					if( !isset( $body['options']['height'] ) ){
						return '辅助空白错误：高度必填';
					}
					if( !$this->between( $body['options']['height'], [1, 100] ) ){
						return '辅助空白错误：高度必须是1-100';
					}
				break;
				case 'image_ads':
					$ads_result = $this->checkAds( $body['data'] );
					if( $ads_result !== true ){
						return '图片广告'.$ads_result;
					}
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 1 ){
						return '图片广告配置项有误';
					}
					if( !isset( $body['options']['layout_style'] ) ){
						return '图片广告错误：显示形式必填';
					}
					if( !$this->in( $body['options']['layout_style'], [1, 2] ) ){
						return '图片广告错误：显示形式必须是折叠轮播 ,上下平铺';
					}
				break;
				case 'image_nav':
					$nav_result = $this->checkNavs( $body['data'], $body );
					if( $nav_result !== true ){
						return '图片导航'.$nav_result;
					}
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 2 ){
						return '图片导航配置项有误';
					}
					if( !isset( $body['options']['rows'] ) ){
						return '图片导航错误：行数必填';
					}
					if( !isset( $body['options']['each_row_display'] ) ){
						return '图片导航错误：每行数必填';
					}
					if( !$this->between( $body['options']['rows'], [1, 4] ) ){
						return '图片导航错误：行数必须是1行 ,2行 ,3行 ,4行';
					}
					if( !$this->between( $body['options']['each_row_display'], [1, 5] ) ){
						return '图片导航错误：每行数必须是1个 ,2个 ,3个 ,4个 ,5个';
					}
				break;
				case 'shop_window':
					$image_result = $this->checkAds( $body['data'] );
					if( $image_result !== true ){
						return '橱窗'.$image_result;
					}
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 1 ){
						return '橱窗配置项有误';
					}
					if( !isset( $body['options']['layout_style'] ) ){
						return '橱窗错误：展现形式必填';
					}
					if( !$this->between( $body['options']['layout_style'], [1, 4] ) ){
						return '橱窗错误：展现形式必须是2列 ,一大两小 ,3列 ,三小图';
					}
				break;
				case 'video':
					$video_result = $this->checkVideo( $body['data'] );
					if( $video_result !== true ){
						return '视频'.$video_result;
					}
					if( $body['options'] != null ){
						return '视频配置项有误';
					}
				break;
				case 'top_menu':
					$menus_result = $this->checkMenus( $body['data'], $body );
					if( $menus_result !== true ){
						return '顶部菜单'.$menus_result;
					}
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 2 ){
						return '顶部菜单配置项有误';
					}
					if( !isset( $body['options']['menu_format'] ) ){
						return '顶部菜单错误：菜单格式必填';
					}
					if( !isset( $body['options']['menu_space'] ) ){
						return '顶部菜单错误：菜单间距必填';
					}
					if( !$this->in( $body['options']['menu_format'], [1, 2] ) ){
						return '顶部菜单错误：菜单格式必须是纯文字导航 ,小图标导航';
					}
					if( !$this->in( $body['options']['menu_space'], [1, 2] ) ){
						return '顶部菜单错误：菜单间距必须是无间距 ,有间距';
					}
				break;
				case 'title':
					if( !isset( $body['options'] ) || empty( $body['options'] ) || !is_array( $body['options'] ) || count( $body['options'] ) != 5 ){
						return '标题配置项有误';
					}
					if( !isset( $body['options']['title'] ) ){
						return '标题错误：标题名称必填';
					}
					if( !isset( $body['options']['align'] ) ){
						return '标题错误：对齐方式必填';
					}
					if( !isset( $body['options']['background_color'] ) ){
						return '标题错误：背景颜色必填';
					}
					if( !isset( $body['options']['font_color'] ) ){
						return '标题错误：文字颜色必填';
					}
					if( !isset( $body['options']['leading_image']['url'] ) ){
						return '标题错误：前导图片必填';
					}
					if( !$this->in( $body['options']['align'], ['left', 'center', 'right'] ) ){
						return '标题错误：对齐方式必须是左对齐 ,居中对齐 ,右对齐';
					}
				break;
				case 'text_nav':
					$nav_result = $this->checkNavs( $body['data'], $body );
					if( $nav_result !== true ){
						return '文本导航'.$nav_result;
					}
					if( $body['options'] != null ){
						return '文本导航配置项有误';
					}
				break;
				default:
					return '模板内容无对应类型';
				}
			}
		}
		return true;
	}

	/**
	 * checkGoods 检测商品信息
	 * @param array $value 参数
	 */
	private function checkGoodsList( array $value )
	{
		if( empty( $value ) ||  count( $value ) < 1 ){
			return '信息有误';
		}
		foreach( $value as $goods ){
			if( !isset( $goods['id'] ) ){
				return '错误：商品ID必填';
			}
			if( !isset( $goods['img'] ) ){
				return '错误：商品图片路径必填';
			}
			if( !isset( $goods['price'] ) ){
				return '错误：商品销售价必填';
			}
		}
		return true;
	}

	/**
	 * checkGoods 检测商品信息
	 * @param array $value 参数
	 */
	private function checkGoods( array $value )
	{
		if( empty( $value ) || count( $value ) < 1 ){
			return '信息有误';
		}
		foreach( $value as $goods ){
			if( !isset( $goods['id'] ) ){
				return '错误：商品ID必填';
			}
			if( !isset( $goods['img'] ) ){
				return '错误：商品图片路径必填';
			}
			if( !isset( $goods['price'] ) ){
				return '错误：商品销售价必填';
			}
		}
		return true;
	}

	/**
	 * checkAds 检测图片设置信息
	 * @param array $value 参数
	 */
	private function checkAds( $value )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) < 1 ){
			return '信息有误';
		}
		foreach( $value as $ads ){
			if( !isset( $ads['img']['url'] ) ){
				return '错误：图片路径必填';
			}
			if( !isset( $ads['link']['action'] ) ){
				return '错误：链接地址必填';
			}
		}
		return true;
	}

	/**
	 * checkVideo
	 * @param array $value 参数
	 */
	private function checkVideo( $value )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) != 1 ){
			return '信息有误';
		}
		if( !isset( $value['url'] ) ){
			return '错误：视频路径必填';
		}
		return true;
	}

	/**
	 * checkMenus
	 * @param array $value 参数
	 */
	private function checkMenus( $value, $data )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) < 1 ){
			return '信息有误';
		}
		foreach( $value as $menus ){
			switch( $data['options']['menu_format'] ){
			case 1:
				if( !isset( $menus['title'] ) ){
					return '错误：标题必填';
				}
			break;
			case 2:
				if( !isset( $menus['img']['url'] ) ){
					return '错误：图片路径必填';
				}
			break;
			}
			if( !isset( $menus['background_color'] ) ){
				return '错误：背景颜色必填';
			}
			if( !isset( $menus['font_color'] ) ){
				return '错误：字体颜色必填';
			}
			if( !isset( $menus['link']['action'] ) ){
				return '错误：链接地址必填';
			}
		}
		return true;
	}

	/**
	 * checkNavs
	 * @param array $value 参数
	 * @param array $data  数据源
	 */
	private function checkNavs( $value, $data )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) < 1 ){
			return '信息有误';
		}
		foreach( $value as $navs ){
			if( $data['type'] == 'image_nav' ){
				if( !isset( $navs['img']['url'] ) ){
					return '错误：图片路径必填';
				}
			}
			if( !isset( $navs['title'] ) ){
				return '错误：标题必填';
			}
			if( !isset( $navs['link']['action'] ) ){
				return '错误：链接地址必填';
			}

		}
		return true;
	}
}