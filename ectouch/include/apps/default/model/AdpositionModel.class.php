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

class AdpositionModel extends BaseModel {

    /**
     * 根据指定的描述获取相应的广告资源
     */
    public function getPositionId($position_desc)
    {
        $sql = ' SELECT position_id '
            .' FROM '.$this->pre.'touch_ad_position'
            .' WHERE position_desc = "'.$position_desc.'" ';
        file_put_contents('./test.json', $sql);
        $res = $this->query($sql);

        return $res[0]['position_id'];
    }
}
