<?php

/**
 * ECTouch Open Source Project
 * ============================================================================
 * Copyright (c) 2012-2014 http://ectouch.cn All rights reserved.
 * ----------------------------------------------------------------------------
 * 文件名称：ActivityModel.class.php
 * ----------------------------------------------------------------------------
 * 功能描述：ECTOUCH 优惠活动模型
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.ectouch.cn/docs/license.txt )
 * ----------------------------------------------------------------------------
 */
/* 访问控制 */
defined('IN_ECTOUCH') or die('Deny Access');

class AdModel extends BaseModel {

    /**
     * 根据指定的描述获取相应的广告资源
     */

    public function getAds($position_desc)
    {
        $now = time();
        $sql = ' SELECT a.ad_id, a.position_id, a.ad_code, a.ad_link,  a.ad_name '
            .' FROM '.$this->pre.'ad a'
            .' LEFT JOIN '.$this->pre.'ad_position p ON a.position_id = p.position_id'
            .' WHERE p.position_desc = '.$position_desc
            .' AND a.start_time < '.$now
            .' AND a.end_time > '.$now;
        $res = $this->query($sql);

        return $res;
    }
}
