/* 为PREFIX_touch_shop_config表添加配置项IMG_BASE_URL值为PC站的URL */
INSERT INTO `ecs_touch_shop_config`(`parent_id`, `code`, `type`, `value`, `sort_order`) VALUES (1, 'img_base_url', 'text', 'http://study.ecshop.com/', '1')

/*  删除 ectouch\data\cache\static_caches\touch_shop_config.php 刷新页面重新生成  */