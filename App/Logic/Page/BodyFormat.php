<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/8/28
 * Time: 下午11:23
 *
 */

namespace App\Logic\Page;


class BodyFormat
{
	const goods_type           = 'goods';
	const goods_list_type      = 'goods_list';
	const goods_search_type    = 'goods_search';
	const separator_type       = 'separator';
	const auxiliary_blank_type = 'auxiliary_blank';
	const image_ads_type       = 'image_ads';
	const image_nav_type       = 'image_nav';
	const shop_window_type     = 'shop_window';
	const video_type           = 'video';
	const top_menu_type        = 'top_menu';
	const title_type           = 'title';
	const text_nav_type        = 'text_nav';

	/**
	 * @param array $body
	 * @return array
	 * @throws \Exception
	 */
	function formatBody( array $body ) : array
	{
		foreach( $body as $key => $item ){
			$body[$key] = $this->formatBodyItem( $item );
		}
		return $body;

	}

	/**
	 * @param array $body
	 * @return array
	 * @throws \Exception
	 */
	private function formatBodyItem( array $body ) : array
	{
		switch( $body['type'] ){
		case self::goods_type :
			$data = $this->formatGoods( $body['options'], $body['data'] );
		break;
		case self::goods_list_type :
			$data = $this->formatGoodsList( $body['options'] );
		break;
		case self::goods_search_type :
			$data = $this->formatGoodsSearch($body['options']);
		break;
		case self::separator_type :
			$data = $this->formatSeparator( $body['options'] );
		break;
		case self::auxiliary_blank_type :
			$data = $this->formatAuxiliaryBlank( $body['options'] );
		break;
		case self::image_ads_type :
			$data = $this->formatImageAds( $body['options'], $body['data'] );
		break;
		case self::image_nav_type :
			$data = $this->formatImageNav( $body['options'], $body['data'] );
		break;
		case self::shop_window_type :
			$data = $this->formatShopWindow( $body['options'], $body['data'] );
		break;
		case self::video_type :
			$data = $this->formatVideo( $body['data'] );
		break;
		case self::top_menu_type :
			$data = $this->formatTopMenu( $body['options'], $body['data'] );
		break;
		case self::title_type :
			$data = $this->formatTitle( $body['options'] );
		break;
		case self::text_nav_type :
			$data = $this->formatTextNav( $body['data'] );
		break;
		default:
			throw new \Exception( "不存在该类型{$body['type']}" );
		}
		return $data;
	}

	private function formatGoods( array $options, array $data ) : array
	{
		if( count( $data ) > 0 ){
			foreach( $data as $key => $item ){
				$data[$key] = [
					'id'    => (int)$item['id'],
					'img'   => (string)$item['img'],
					'title' => (string)$item['title'],
					'price' => (float)$item['price'],
				];
			}
		}
		return [
			'type'    => self::goods_type,
			'options' => [
				'layout_style' => in_array( $options['layout_style'], [1, 2, 3, 4] ) ? (int)$options['layout_style'] : 1,
			],
			'data'    => $data,
		];
	}

	private function formatGoodsList( array $options ) : array
	{
		$goods_display_field  = ['title', 'price'];
		$_goods_display_field = [];
		foreach( $options['goods_display_field'] as $field ){
			if( in_array( $field, $goods_display_field ) ){
				$_goods_display_field[] = $field;
			}
		}
		return [
			'type'    => self::goods_list_type,
			'options' => [
				'goods_sort'          => in_array( $options['goods_sort'], [1, 2, 3] ) ? $options['goods_sort'] : 1,
				'goods_display_num'   => in_array( $options['goods_display_num'], [6, 12, 18] ) ? (int)$options['goods_display_num'] : 6,
				'goods_display_field' => $_goods_display_field ? $_goods_display_field : $goods_display_field,
				'layout_style'        => in_array( $options['layout_style'], [1, 2, 3, 4] ) ? (int)$options['layout_style'] : 1,
			],
			'data'    => [],
		];
	}

	private function formatGoodsSearch( array $options ) : array
	{
		return [
			'type'    => self::goods_search_type,
			'options' => [
				'background_color' => $options['background_color'] ? $options['background_color'] : '#FFFFFF',
			],
			'data'    => [],
		];
	}

	private function formatSeparator( array $options ) : array
	{
		return [
			'type'    => self::separator_type,
			'options' => [
				'color' => $options['color'] ? $options['color'] : '#000000',
				'style' => in_array( $options['style'], ['dotted', 'solid'] ) ? (int)$options['goods_display_num'] : 'solid',
			],
			'data'    => [],
		];
	}

	private function formatAuxiliaryBlank( array $options ) : array
	{
		return [
			'type'    => self::auxiliary_blank_type,
			'options' => [
				'height' => (int)$options['height'] ? (int)$options['height'] : 5,
			],
			'data'    => [],
		];
	}

	private function formatImageAds( array $options, array $data ) : array
	{
		if( count( $data ) > 0 ){
			foreach( $data as $key => $item ){
				$data[$key] = [
					'img'   => [
						'url' => (string)$item['img']['url'],
					],
					'title' => (string)$item['title'],
					'link'  => [
						'action' => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (string)$item['link']['action'] : 'portal',
						'param'  => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (array)$item['link']['param'] : [],
					],
				];
			}
		}
		return [
			'type'    => self::image_ads_type,
			'options' => [
				'layout_style' => in_array( $options['layout_style'], [1, 2] ) ? (int)$options['layout_style'] : 1,
			],
			'data'    => $data,
		];
	}

	private function formatImageNav( array $options, array $data ) : array
	{
		if( count( $data ) > 0 ){
			foreach( $data as $key => $item ){
				$data[$key] = [
					'img'   => [
						'url' => (string)$item['img']['url'],
					],
					'title' => (string)$item['title'],
					'link'  => [
						'action' => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (string)$item['link']['action'] : 'portal',
						'param'  => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (array)$item['link']['param'] : [],
					],
				];
			}
		}
		return [
			'type'    => self::image_nav_type,
			'options' => [
				'rows'             => in_array( $options['rows'], [1, 2, 3, 4] ) ? (int)$options['rows'] : 1,
				'each_row_display' => in_array( $options['each_row_display'], [1, 2, 3, 4, 5] ) ? (int)$options['each_row_display'] : 1,
			],
			'data'    => $data,
		];
	}

	private function formatShopWindow( array $options, array $data ) : array
	{
		if( count( $data ) > 0 ){
			foreach( $data as $key => $item ){
				$data[$key] = [
					'img'   => [
						'url' => (string)$item['img']['url'],
					],
					'title' => (string)$item['title'],
					'link'  => [
						'action' => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (string)$item['link']['action'] : 'portal',
						'param'  => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (array)$item['link']['param'] : [],
					],
				];
			}
		}
		return [
			'type'    => self::shop_window_type,
			'options' => [
				'layout_style' => in_array( $options['layout_style'], [1, 2, 3, 4] ) ? (int)$options['layout_style'] : 1,
			],
			'data'    => $data,
		];
	}

	private function formatVideo( array $data ) : array
	{
		return [
			'type'    => self::video_type,
			'options' => null,
			'data'    => ['url' => (string)$data['url']],
		];
	}

	private function formatTopMenu( array $options, array $data ) : array
	{
		if( count( $data ) > 0 ){
			foreach( $data as $key => $item ){
				$data[$key] = [
					'img'              => [
						'url' => (string)$item['img']['url'],
					],
					'title'            => (string)$item['title'],
					'link'             => [
						'action' => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (string)$item['link']['action'] : 'portal',
						'param'  => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (array)$item['link']['param'] : [],
					],
					'background_color' => (string)$item['background_color'],
					'font_color'       => (string)$item['font_color'],
				];
			}
		}
		return [
			'type'    => self::top_menu_type,
			'options' => [
				'menu_format' => in_array( $options['menu_format'], [1, 2] ) ? (int)$options['menu_format'] : 1,
				'menu_space'  => in_array( $options['menu_space'], [1, 2] ) ? (int)$options['menu_space'] : 1,
			],
			'data'    => $data,
		];
	}

	private function formatTitle( array $options ) : array
	{
		return [
			'type'    => self::title_type,
			'options' => [
				'title'            => (string)$options['title'],
				'align'            => in_array( $options['align'], ['left', 'center', 'right'] ) ? (string)$options['align'] : 'left',
				'background_color' => (string)$options['background_color'],
				'font_color'       => (string)$options['font_color'],
				'leading_image'    => [
					'url' => (string)$options['leading_image']['url'],
				],

			],
			'data'    => [],
		];
	}

	private function formatTextNav( array $data ) : array
	{
		if( count( $data ) > 0 ){
			foreach( $data as $key => $item ){
				$data[$key] = [
					'img'   => [
						'url' => (string)$item['img']['url'],
					],
					'title' => (string)$item['title'],
					'link'  => [
						'action' => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (string)$item['link']['action'] : 'portal',
						'param'  => in_array( $item['link']['action'], ['portal', 'page', 'goods'] ) ? (array)$item['link']['param'] : [],
					],
				];
			}
		}
		return [
			'type'    => self::text_nav_type,
			'options' => null,
			'data'    => $data,
		];
	}
}