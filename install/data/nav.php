<?php
return "INSERT INTO `".$BIAOTOU."nav` (`id`, `title`, `url`, `tip`, `sort`, `hide`, `type`, `auto`, `target`, `custom`, `mod`, `act`, `tag`, `addtime`, `pid`, `alt`, `sys`) VALUES
(1, '首页', '', 0, 100, 0, 0, 0, 0, '', 'index', 'index', 'index', 1343495490, 0, '', 1),
(2, '淘宝返利', '', 0, 60, 0, 0, 0, 0, '', 'tao', 'index', 'tao', 1343495490, 0, '', 1),
(3, '商家返利', '', 0, 70, 0, 0, 0, 0, '', 'mall', 'list', 'mall', 1343495490, 0, '', 1),
(4, '比价搜索', '', 0, 50, 1, 0, 0, 0, '', 'mall', 'goods', 'mall', 1343495490, 3, '比一比', 1),
(9, '晒单分享', '', 0, 50, 0, 0, 0, 0, '', 'baobei', 'list', 'baobei', 1343495490, 0, '', 1),
(8, '淘宝折扣', '', 0, 40, 0, 0, 0, 0, '', 'tao', 'zhe', 'zhekou', 1343495490, 0, '', 1),
(7, '兑换认领', '', 0, 45, 0, 0, 0, 0, '', 'huan', 'list', 'huan', 1343495490, 0, '', 1),
(6, '优惠促销', '', 0, 20, 0, 0, 0, 0, '', 'huodong', 'list', 'mall', 1343495490, 3, '最新活动', 1),
(10, '团购返利', '', 0, 0, 1, 0, 0, 0, '', 'tuan', 'list', 'mall', 1343495490, 3, '还能更省', 1),
(11, '精品店铺', '', 0, 0, 0, 0, 0, 0, '', 'shop', 'list', 'tao', 1343495490, 2, '优质商家', 1),
(12, '淘宝男装', 'index.php?mod=tao&act=list&q=%E7%94%B7%E8%A3%85', 0, 0, 0, 0, 0, 0, '', 'tao', 'list', 'tao', 1343495490, 2, '走爆款', 1),
(13, '新手帮助', '', 0, 0, 0, 0, 0, 0, '', 'help', 'index', 'help', 1343495490, 0, '', 1),
(14, '站点文章', '', 0, 10, 1, 0, 0, 0, '', 'article', 'index', 'article', 1343495490, 0, '', 1),
(15, '淘宝女装', 'index.php?mod=tao&act=list&q=%E5%A5%B3%E8%A3%85', 0, 0, 0, 0, 0, 0, '', 'tao', 'list', 'tao', 1343724354, 2, '淑女典范', 0),
(16, '淘宝新款', 'index.php?mod=tao&act=list&q=%E6%96%B0%E6%AC%BE', 0, 0, 0, 0, 0, 0, '', 'tao', 'list', 'tao', 1343724434, 2, '最新最热', 0),
(17, '淘宝正品', 'index.php?mod=tao&act=list&q=%E6%AD%A3%E5%93%81', 0, 0, 0, 0, 0, 0, '', 'tao', 'list', 'tao', 1343724504, 2, '正品天下', 0),
(18, '淘宝活动', 'http://www.taobao.com/go/chn/tbk_channel/channelcode.php?pid=mm_25328448_2922415_10004886&eventid=101329', 1, 45, 0, 1, 0, 1, '', '', '', '', 1345987893, 0, '', 0),
(19, '聚划算', 'http://www.taobao.com/go/chn/tbk_channel/jkwt.php?pid=mm_25328448_2922415_10004886&eventid=102405', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345988037, 18, '淘宝团购', 0),
(20, '店铺导航', 'http://dianpu.tao123.com?pid=mm_25328448_2922415_10004886&eventid=102167', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345988218, 18, '', 0),
(21, '母婴频道', 'http://www.taobao.com/go/chn/tbk_channel/child.php?pid=mm_25328448_2922415_10004886&eventid=102185', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345990393, 18, '', 0),
(22, '食品频道', 'http://www.taobao.com/go/chn/tbk_channel/food.php?pid=mm_25328448_2922415_10004886&eventid=101865', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345991331, 18, '', 0),
(23, '机票频道', 'http://www.taobao.com/go/chn/tbk_channel/trip.php?pid=mm_25328448_2922415_10004886&eventid=101829', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345993630, 18, '', 0),
(24, '女装频道', 'http://www.taobao.com/go/chn/tbk_channel/lady.php?pid=mm_25328448_2922415_10004886&eventid=101345', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345993708, 18, '', 0),
(31, '拍拍返利', '', 0, 55, 0, 1, 0, 0, '', 'paipai', 'index', 'paipai', 1347540002, 0, '', 1),
(25, '天猫频道', 'http://www.tmall.com/go/chn/tbk_channel/tmall_new.php?pid=mm_25328448_2922415_10004886&eventid=101334', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345993791, 18, '', 0),
(26, '数码频道', 'http://www.taobao.com/go/chn/tbk_channel/digital.php?pid=mm_25328448_2922415_10004886&eventid=101332', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345993897, 18, '', 0),
(27, '饰品鞋包', 'http://www.taobao.com/go/chn/tbk_channel/jewelry.php?pid=mm_25328448_2922415_10004886&eventid=101331', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345994068, 18, '', 0),
(28, '男人频道', 'http://www.taobao.com/go/chn/tbk_channel/man.php?pid=mm_25328448_2922415_10004886&eventid=101330', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345994241, 18, '', 0),
(30, '家装频道', 'http://www.taobao.com/go/chn/tbk_channel/baby.php?pid=mm_25328448_2922415_10004886&eventid=101326', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345995711, 18, '', 0),
(29, '美容频道', 'http://www.taobao.com/go/chn/tbk_channel/beauty.php?pid=mm_25328448_2922415_10004886&eventid=101328', 1, 0, 0, 0, 0, 1, '', '', '', '', 1345994918, 18, '', 0),
(32, '我的返利', '', 0, 0, 0, 0, 0, 0, '', 'user', 'index', 'user', 1348990104, 0, '', 0);";