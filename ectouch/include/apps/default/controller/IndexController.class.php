<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：IndexController.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：ECTouch首页控制器
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');

class IndexController extends CommonController {

    /**
     * 首页信息
     */
    public function index() {
        // 自定义导航栏
        $navigator = model('Common')->get_navigator();
        $this->assign('navigator', $navigator['middle']);
        $this->assign('best_goods', model('Index')->goods_list('best', C('page_size')));
        $this->assign('new_goods', model('Index')->goods_list('new', C('page_size')));
        $this->assign('hot_goods', model('Index')->goods_list('hot', C('page_size')));
        //首页推荐分类
        $cat_rec = model('Index')->get_recommend_res();
        $this->assign('cat_best', $cat_rec[1]);
        $this->assign('cat_new', $cat_rec[2]);
        $this->assign('cat_hot', $cat_rec[3]);
        // 促销活动
        $this->assign('promotion_info', model('GoodsBase')->get_promotion_info());
        // 团购商品
        $this->assign('group_buy_goods', model('Groupbuy')->group_buy_list(C('page_size'),1,'goods_id','ASC'));
        // 获取分类
        $this->assign('categories', model('CategoryBase')->get_categories_tree());
        // 获取品牌
        $this->assign('brand_list', model('Brand')->get_brands($app = 'brand', C('page_size'), 1));
        $this->display('index.dwt');
    }

    /**
     * ajax获取商品
     */
    public function ajax_goods() {
        if (IS_AJAX) {
            $type = I('get.type');
            $start = $_POST['last'];
            $limit = $_POST['amount'];
            $hot_goods = model('Index')->goods_list($type, $limit, $start);
            $list = array();
            // 热卖商品
            if ($hot_goods) {
                foreach ($hot_goods as $key => $value) {
                    $this->assign('hot_goods', $value);
                    $list [] = array(
                        'single_item' => ECTouch::view()->fetch('library/asynclist_index.lbi')
                    );
                }
            }
            echo json_encode($list);
            exit();
        } else {
            $this->redirect(url('index'));
        }
    }

    /**
     * ajax获取推荐列表
     * 最新团拼 热门品牌 护肤 彩妆 个人护理 香氛 男士专区 家庭护理 母婴专区
     */
    public function ajax_recommend() {
        if (IS_AJAX) {
            $list = array();
            //  获得首页推荐的团拼
            $groupbuy_list =  model('Groupbuy')->group_buy_list(2, 1,
                'act_id', 'DESC');
            if ($groupbuy_list) {
                $this->assign('cate', [
                    'name' => 'group_buy_last',
                    'url' => '/default/group_buy/index' //  团拼页面
                ]);
                $list [] = [
                    'single_item' => ECTouch::view()->fetch('library/cate_header.lbi')
                ];

                foreach ($groupbuy_list as $key => $value) {
                    $value['url'] = '/index.php?m=default&c=goods&a=index&id='.$value['goods_id'];
                    $value['group_remain'] = $value['end_time'] - time();
                    $this->assign('groupbuy', $value);
                    $list [] = array(
                        'single_item' => ECTouch::view()->fetch('library/async_groupbuy_index.lbi')
                    );
                }
            }

            //  获取热门品牌列表
            $brand_list = model('Brand')->get_brands('brand', 6, 1);
            if ($brand_list) {
                $this->assign('cate', [
                    'name' => 'hot_brand',
                    'url' => '/default/brand/index' //  热门品牌
                ]);
                $list [] = [
                    'single_item' => ECTouch::view()->fetch('library/cate_header.lbi')
                ];

                $this->assign('brand_list', $brand_list);
                $list [] = array(
                    'single_item' => ECTouch::view()->fetch('library/brand_index.lbi')
                );

            }

            //  获取分类下最热的商品，暂不设价格区间
            $category_list = model('Category')->get_cat_list(0);
            if ($category_list) {
                foreach ($category_list as $category) {
                    $subcate_list = model('Category')->get_cat_list($category['cat_id']);
                    if ($category['style'] && $subcate_list) {
                        //  分类的banner
                        $position_id = model('Adposition')->getPositionId($category['style']);
                        if ($position_id) {
                            $ads = model('Ad')->getAds($position_id);
                            if ($ads) {
                                $this->assign('ads', $ads);
                                $this->assign('id', $category['style'].'-banner');
                                $list [] = [
                                    'single_item' => ECTouch::view()->fetch('library/cate_banner.lbi')
                                ];
                            }
                        }

                        //  分类名称
                        $this->assign('cate', [
                            'name' => 'cate_'.$category['style'],
                            'style' => $category['style'],
                            'url' => '/index.php?m=default&c=category&a=index&id='.$category['cat_id']
                        ]);
                        $list [] = [
                            'single_item' => ECTouch::view()->fetch('library/cate_header.lbi')
                        ];
                        $this->assign('subcate_list', $subcate_list);
                        $this->assign('valid_count', count($subcate_list));
                        $list [] = array(
                            'single_item' => ECTouch::view()->fetch('library/async_catelist_index.lbi')
                        );
                    }
                }
            }

            echo json_encode($list);

            exit();
        } else {
            $this->redirect(url('index'));
        }
    }
}
