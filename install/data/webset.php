<?php
return "INSERT INTO `".$BIAOTOU."webset` (`id`, `var`, `val`, `type`) VALUES
(1, 'fxbl', 'a:4:{i:100;s:3:\"0.8\";i:50;s:3:\"0.7\";i:20;s:3:\"0.6\";i:0;s:3:\"0.5\";}', 1),
(2, 'sign', 'a:3:{s:4:\"open\";s:1:\"1\";s:5:\"money\";s:1:\"0\";s:5:\"jifen\";s:2:\"10\";}', 1),
(3, 'baobei', 'a:10:{s:10:\"shai_jifen\";s:1:\"2\";s:11:\"share_jifen\";s:1:\"1\";s:10:\"hart_jifen\";s:1:\"1\";s:11:\"shai_s_time\";s:10:\"2011-10-01\";s:8:\"word_num\";s:2:\"80\";s:16:\"comment_word_num\";s:2:\"50\";s:11:\"share_level\";s:1:\"0\";s:13:\"comment_level\";s:1:\"0\";s:3:\"cat\";a:10:{i:1;s:6:\"上装\";i:2;s:6:\"下装\";i:3;s:6:\"鞋子\";i:4;s:6:\"包包\";i:5;s:6:\"配饰\";i:6;s:6:\"美妆\";i:7;s:6:\"内衣\";i:8;s:6:\"家居\";i:9;s:6:\"数码\";i:999;s:6:\"其他\";}s:10:\"re_tao_cid\";s:1:\"1\";}', 1),
(4, 'picwjt', '0', 2),
(5, 'picjm', '0', 2),
(6, 'comment_interval', '86400', 0),
(7, 'chanet', 'a:4:{s:4:\"name\";s:11:\"a0504030301\";s:3:\"pwd\";s:0:\"\";s:4:\"wzid\";s:6:\"431726\";s:3:\"key\";s:16:\"2a784eee44480173\";}', 1),
(8, 'static', 'a:1:{s:5:\"index\";a:1:{s:6:\"random\";s:1:\"0\";}}', 1),
(9, 'tixian_limit', '10', 0),
(10, 'txxz', '10', 0),
(11, 'user', 'a:8:{s:5:\"jihuo\";s:1:\"0\";s:7:\"autoreg\";s:1:\"0\";s:11:\"reg_between\";s:1:\"0\";s:9:\"reg_money\";s:1:\"0\";s:9:\"reg_jifen\";s:1:\"0\";s:9:\"up_avatar\";s:1:\"2\";s:14:\"auto_increment\";s:1:\"2\";s:8:\"limit_ip\";s:0:\"\";}', 1),
(12, 'taobao_nick', '飞翔的波斯猫', 0),
(13, 'taobao_session', '', 0),
(14, 'tao_report_interval', '1200', 0),
(15, 'jifenbl', '0', 0),
(16, 'tgbl', '0.1', 0),
(17, 'taoapi', 'a:20:{s:8:\"pagesize\";s:2:\"20\";s:13:\"goods_comment\";s:1:\"0\";s:11:\"trade_check\";s:1:\"1\";s:2:\"s8\";s:1:\"0\";s:6:\"freeze\";s:1:\"0\";s:12:\"freeze_limit\";s:1:\"0\";s:12:\"auto_jiesuan\";s:2:\"28\";s:8:\"fanlitip\";s:1:\"0\";s:10:\"goods_show\";s:1:\"1\";s:4:\"sort\";s:18:\"commissionNum_desc\";s:6:\"shield\";s:1:\"0\";s:10:\"cache_time\";s:2:\"10\";s:13:\"cache_monitor\";s:1:\"0\";s:8:\"errorlog\";s:1:\"0\";s:9:\"promotion\";s:1:\"0\";s:12:\"callback_key\";s:0:\"\";s:9:\"jssdk_key\";s:8:\"21165987\";s:12:\"jssdk_secret\";s:32:\"b99c6c50088ed36ad0035b71126c8222\";s:17:\"taobao_search_pid\";s:0:\"\";s:19:\"taobao_chongzhi_pid\";s:0:\"\";}', 1),
(18, 'hotword', 'a:10:{i:0;s:6:\"热卖\";i:1;s:6:\"新款\";i:2;s:6:\"秒杀\";i:3;s:6:\"减肥\";i:4;s:6:\"内衣\";i:5;s:6:\"丰胸\";i:6;s:6:\"衬衣\";i:7;s:6:\"短袖\";i:8;s:9:\"连衣裙\";i:9;s:9:\"电风扇\";}', 1),
(19, 'wjt', '0', 2),
(20, 'webclose', '0', 0),
(21, 'webclosemsg', '网站升级中。。。', 0),
(22, 'webtype', '1', 2),
(23, 'webname', '网站名称', 2),
(24, 'title', '网站标题', 2),
(25, 'webnick', '网站昵称', 2),
(26, 'keyword', '网站关键字', 2),
(27, 'description', '网站描述', 2),
(28, 'url', '".$url."', 2),
(29, 'email', 'email', 0),
(30, 'qq', 'qq', 0),
(31, 'surl', '', 2),
(32, 'liebiao', '1', 0),
(33, 'moban', 'default', 2),
(34, 'level', 'a:4:{i:0;s:12:\"普通会员\";i:20;s:12:\"黄金会员\";i:50;s:12:\"白金会员\";i:100;s:12:\"钻石会员\";}', 1),
(35, 'mallfxbl', 'a:4:{i:100;s:1:\"1\";i:50;s:3:\"0.9\";i:20;s:3:\"0.8\";i:0;s:3:\"0.7\";}', 1),
(36, 'smtp', 'a:4:{s:4:\"type\";s:1:\"1\";s:4:\"host\";s:0:\"\";s:4:\"name\";s:0:\"\";s:3:\"pwd\";s:0:\"\";}', 1),
(84, 'sql_debug', '0', 0),
(37, 'hytxjl', '0', 0),
(38, 'tgurl', 'http://".$url."/index.php?', 0),
(39, 'searchlimit', '0', 0),
(40, 'linktech', 'a:3:{s:4:\"name\";s:0:\"\";s:3:\"pwd\";s:0:\"\";s:4:\"wzbh\";s:0:\"\";}', 1),
(41, 'duomai', 'a:4:{s:3:\"uid\";s:5:\"10440\";s:4:\"wzid\";s:5:\"52244\";s:4:\"wzbh\";s:3:\"001\";s:3:\"key\";s:32:\"35ad3d58d228787714d72e1ded84d40a\";}', 1),
(42, 'gzip', '0', 0),
(43, 'shop', 'a:3:{s:4:\"open\";s:1:\"1\";s:6:\"slevel\";s:2:\"11\";s:6:\"elevel\";s:2:\"20\";}', 1),
(44, 'yiqifa', 'a:4:{s:3:\"uid\";s:0:\"\";s:4:\"wzid\";s:0:\"\";s:4:\"name\";s:0:\"\";s:3:\"key\";s:0:\"\";}', 1),
(45, 'yiqifaapi', 'a:6:{s:4:\"open\";s:1:\"0\";s:3:\"key\";s:17:\"13399929765611312\";s:6:\"secret\";s:32:\"4ff6a7f2d44ef876d15eabffe1c799ee\";s:8:\"pagesize\";s:2:\"20\";s:10:\"cache_time\";s:1:\"0\";s:17:\"shield_merchantId\";s:6:\"100016\";}', 1),
(46, 'tuan', 'a:7:{s:4:\"open\";s:1:\"0\";s:3:\"cid\";s:1:\"1\";s:7:\"autoget\";s:1:\"2\";s:8:\"autogdel\";s:1:\"1\";s:7:\"shownum\";s:1:\"6\";s:7:\"listnum\";s:1:\"9\";s:8:\"mall_cid\";s:2:\"21\";}', 1),
(47, 'ucenter', 'a:11:{s:4:\"open\";s:1:\"0\";s:8:\"UC_APPID\";s:0:\"\";s:6:\"UC_KEY\";s:0:\"\";s:6:\"UC_API\";s:0:\"\";s:12:\"UC_DBCHARSET\";s:0:\"\";s:10:\"UC_CHARSET\";s:0:\"\";s:9:\"UC_DBHOST\";s:0:\"\";s:9:\"UC_DBUSER\";s:0:\"\";s:7:\"UC_DBPW\";s:0:\"\";s:9:\"UC_DBNAME\";s:0:\"\";s:13:\"UC_DBTABLEPRE\";s:0:\"\";}', 1),
(48, 'spider', 'a:12:{s:10:\"sosospider\";s:3:\"100\";s:11:\"baiduspider\";s:2:\"20\";s:5:\"yahoo\";s:3:\"100\";s:7:\"bingbot\";s:3:\"100\";s:9:\"googlebot\";s:3:\"100\";s:11:\"ia_archiver\";s:3:\"100\";s:9:\"youdaobot\";s:3:\"100\";s:4:\"sohu\";s:3:\"100\";s:6:\"msnbot\";s:3:\"100\";s:5:\"slurp\";s:3:\"100\";s:5:\"sogou\";s:3:\"100\";s:8:\"QihooBot\";s:3:\"100\";}', 1),
(49, 'seo', 'a:1:{s:12:\"spider_limit\";s:1:\"0\";}', 1),
(50, 'urlencrypt', '', 2),
(51, 'fxb', 'a:2:{s:4:\"open\";s:1:\"0\";s:4:\"name\";s:15:\"多多返现宝\";}', 1),
(52, 'logo', 'upload/logo.gif', 2),
(53, 'tao_report_time', '1349691838', 0),
(54, 'tuan_goods_time', '1349601945', 0),
(55, 'tao_cache_time', '1349666230', 0),
(56, 'login_tip', '1', 0),
(57, 'taobao_pid', '25328448', 0),
(58, 'taobao_session_time', '0', 0),
(59, 'jiesuan_date', '201208', 0),
(60, 'phpwind', 'a:4:{s:4:\"open\";s:1:\"0\";s:3:\"key\";s:0:\"\";s:3:\"url\";s:0:\"\";s:7:\"charset\";s:0:\"\";}', 1),
(61, 'yinxiangma', 'a:2:{s:4:\"open\";s:1:\"0\";s:3:\"key\";s:32:\"b44c8d448bab2e6583ad6595ca50642e\";}', 1),
(62, 'bshare_code', '<script type=\"text/javascript\" charset=\"utf-8\" src=\"http://static.bshare.cn/b/buttonLite.js#uuid=c196de18-8f38-410e-8ae0-834dd0ec2c86&amp;style=3&amp;fs=4&amp;textcolor=#fff&amp;bgcolor=#F60&amp;text=分享到...\"></script>', 0),
(63, 'paipai_report_time', '1349691838', 0),
(64, 'paipaifxbl', 'a:4:{i:100;s:1:\"1\";i:50;s:3:\"0.9\";i:20;s:3:\"0.8\";i:0;s:3:\"0.7\";}', 1),
(65, 'url_mulu', '".str_replace($_SERVER['HTTP_HOST'],'',$url)."', 2),
(66, 'bshare', 'a:4:{s:4:\"user\";s:19:\"anzhongxiao@126.com\";s:3:\"pwd\";s:9:\"an4659862\";s:4:\"uuid\";s:36:\"c196de18-8f38-410e-8ae0-834dd0ec2c86\";s:9:\"secretKey\";s:36:\"158d59b4-0e48-4240-8ff9-de000aa0b4e2\";}', 1),
(67, 'collect', 'a:3:{s:4:\"curl\";s:1:\"1\";s:17:\"file_get_contents\";s:1:\"2\";s:9:\"fsockopen\";s:1:\"3\";}', 1),
(68, 'tao_zhe', 'a:19:{s:7:\"keyword\";s:6:\"热卖\";s:3:\"cid\";s:2:\"16\";s:11:\"coupon_type\";s:1:\"1\";s:9:\"shop_type\";s:3:\"all\";s:4:\"sort\";s:19:\"commissionRate_desc\";s:17:\"start_coupon_rate\";s:4:\"1000\";s:15:\"end_coupon_rate\";s:4:\"9000\";s:12:\"start_credit\";s:6:\"1heart\";s:10:\"end_credit\";s:12:\"5goldencrown\";s:21:\"start_commission_rate\";s:4:\"1000\";s:19:\"end_commission_rate\";s:4:\"9000\";s:23:\"start_commission_volume\";s:0:\"\";s:21:\"end_commission_volume\";s:0:\"\";s:20:\"start_commission_num\";s:0:\"\";s:18:\"end_commission_num\";s:0:\"\";s:12:\"start_volume\";s:0:\"\";s:10:\"end_volume\";s:0:\"\";s:9:\"page_size\";s:2:\"16\";s:13:\"ajax_load_num\";s:1:\"5\";}', 1),
(69, 'sql_log', '0', 0),
(70, 'yiqifa_cache_time', '1347281665', 0),
(71, 'replace', '0', 2),
(72, 'corrent_time', '0', 0),
(73, 'authorize', '9c89xfJXhJ9Xm/d2WduYAzG+4bLtHL/jwVfEA87XAawgMJgdRvBa/9gE46XMVTerDGZHV3X0SlbCJx5wGbT+zSU/MwsNYQZN/XJnIALXIUaZZSSIIrlFiskX3CmD3meXg5TioYruzk7cTA7iH83/pyqV/OpEZpgqcoQmfA', 0),
(74, 'shop_count', 'a:22:{s:32:\"c3423b50b6bc6f096c8adb67d138a03f\";a:2:{s:5:\"count\";i:123;s:4:\"time\";i:1344958234;}s:32:\"b3238ee9a748de831d373d2cb67eb896\";a:2:{s:5:\"count\";i:36;s:4:\"time\";i:1343919212;}s:32:\"345860b0cc5bf16991899d57d15e9b05\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1344959071;}s:32:\"26463dfff3cfa230ece11a054330fd1d\";a:2:{s:5:\"count\";s:3:\"157\";s:4:\"time\";i:1349591435;}s:32:\"cba0c3c4eba6ea656323750c80c35510\";a:2:{s:5:\"count\";i:1;s:4:\"time\";i:1346215972;}s:32:\"ddbc652ae832177d9ea36c40b4982040\";a:2:{s:5:\"count\";i:1;s:4:\"time\";i:1346216605;}s:32:\"1081f1dcbe8c6f15da37dc330ff28279\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346429307;}s:32:\"15e58b831c48b54374c20ad80729f2c9\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882387;}s:32:\"c622a8583962dafc67f0df71a3902ee9\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882390;}s:32:\"9d9d07719dcf3a029bd9c71ccc233243\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882392;}s:32:\"6a4389c47e5116359a6cb88d16f9231d\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882392;}s:32:\"92d072dcd68592a552157a15d9d86069\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882393;}s:32:\"cd405da34b6a1e01f4cf38dc830ec8f6\";a:2:{s:5:\"count\";i:2;s:4:\"time\";i:1346882394;}s:32:\"20233a79e8a58c9a15ff381fc85b8585\";a:2:{s:5:\"count\";i:1;s:4:\"time\";i:1346882395;}s:32:\"bdbd221a0d0e8e7084bd57ee83d8f362\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882395;}s:32:\"a8227e987bfbf21877b728b1313b05a5\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882397;}s:32:\"cafa1e0950af3db7056cf85ddcf7a1fe\";a:2:{s:5:\"count\";i:16;s:4:\"time\";i:1347013694;}s:32:\"3c585a0d110870e379197d5f4acb6102\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1346882400;}s:32:\"9bc5a0e8027145ce11161820efb9a9d9\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1347983694;}s:32:\"dc0f8f7ea1eef59212b1c93890fbb0b6\";a:2:{s:5:\"count\";i:1;s:4:\"time\";i:1348408611;}s:32:\"d7e4f0a1be5271c549f7280bec16ab3a\";a:2:{s:5:\"count\";i:0;s:4:\"time\";i:1348650799;}s:32:\"5462da8bb8f268bec9c82b7c5339d5af\";a:2:{s:5:\"count\";i:1;s:4:\"time\";i:1348675819;}}', 1),
(75, 'banquan', 'Copyright ©2008-2012&nbsp;&nbsp; <a href=\"http://soft.duoduo123.com\" target=\"_blank\">多多返利建站系统</a>&nbsp;&nbsp;&nbsp;<a href=\"index.php?mod=about&amp;act=index\" target=\"_blank\">关于我们</a>', 0),
(76, 'email_notice', 'a:1:{s:2:\"dd\";s:1:\"1\";}', 1),
(77, 'ddjson', '0', 2),
(78, 'paipai', 'a:11:{s:4:\"open\";s:1:\"0\";s:6:\"userId\";s:5:\"12245\";s:2:\"qq\";s:9:\"332439180\";s:10:\"appOAuthID\";s:9:\"700028903\";s:14:\"secretOAuthKey\";s:16:\"0cQC1gfECGxeLXvS\";s:11:\"accessToken\";s:32:\"164cb25e20b6415e684000650fb62cf1\";s:7:\"keyWord\";s:6:\"女装\";s:8:\"pageSize\";s:2:\"20\";s:4:\"sort\";s:2:\"11\";s:10:\"cache_time\";s:1:\"0\";s:8:\"errorlog\";s:1:\"0\";}', 1),
(79, 'admintempdata', 'a:5:{s:3:\"zsy\";i:0;s:6:\"tixian\";i:0;s:9:\"usermoney\";i:0;s:7:\"usernum\";i:0;s:4:\"time\";i:1347378137;}', 3),
(80, 'sms', 'a:5:{s:4:\"name\";s:9:\"an4659862\";s:3:\"pwd\";s:6:\"aaaaaa\";s:6:\"newpwd\";s:6:\"aaaaaa\";s:6:\"mobile\";s:0:\"\";s:5:\"check\";s:1:\"0\";}', 1),
(81, 'qq_meta', '', 0);";