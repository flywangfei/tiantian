<?php
include('../../../comm/dd.config.php');
$alias=dd_get_cache('alias');
$cur_path=str_replace('data/rewrite/php/'.filename(),'',$_SERVER['PHP_SELF']);
$cur_path=preg_replace('#^/#','',$cur_path);
ob_start();
echo '<?xml version="1.0" encoding="UTF-8"?>';
$rule_name=1;
?>
<configuration>
    <system.webServer>
	    <rewrite>
            <rules>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/list'][0]?>/<?=$alias['mall/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=list&amp;cid={R:1}&amp;page={R:2}" />
                </rule>
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/list'][0]?>/<?=$alias['mall/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=list&amp;cid={R:1}" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/list'][0]?>/<?=$alias['mall/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=list" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/view'][0]?>/<?=$alias['mall/view'][1]?>-(\d+)-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=view&amp;id={R:1}&amp;do={R:2}&amp;page={R:3}" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/view'][0]?>/<?=$alias['mall/view'][1]?>-(\d+)-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=view&amp;id={R:1}&amp;do={R:2}" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/view'][0]?>/<?=$alias['mall/view'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=view&amp;id={R:1}" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/goods'][0]?>/<?=$alias['mall/goods'][1]?>-(.*)-(\d+)-(\d+)-(\d+)-(\d+)-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=goods&amp;merchantId={R:1}&amp;order={R:2}&amp;start_price={R:3}&amp;end_price={R:4}&amp;list={R:5}&amp;q={R:6}&amp;page={R:7}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/goods'][0]?>/<?=$alias['mall/goods'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=goods&amp;q={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['mall/goods'][0]?>/<?=$alias['mall/goods'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=mall&amp;act=goods" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/index'][0]?>/<?=$alias['article/index'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/index'][0]?>/$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/index'][0]?>$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/list'][0]?>/<?=$alias['article/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/list'][0]?>/<?=$alias['article/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/list'][0]?>/<?=$alias['article/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=list" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['article/view'][0]?>/<?=$alias['article/view'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=article&amp;act=view&amp;id={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huodong/list'][0]?>/<?=$alias['huodong/list'][1]?>-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huodong&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huodong/list'][0]?>/<?=$alias['huodong/list'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huodong&amp;act=list&amp;page={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huodong/list'][0]?>/<?=$alias['huodong/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huodong&amp;act=list" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huodong/view'][0]?>/<?=$alias['huodong/view'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huodong&amp;act=view&amp;id={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huan&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huan&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huan&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huan/list'][0]?>/<?=$alias['huan/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huan&amp;act=list" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['huan/view'][0]?>/<?=$alias['huan/view'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=huan&amp;act=view&amp;id={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/index'][0]?>/<?=$alias['tao/index'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/index'][0]?>/$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/index'][0]?>$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-(.*)-(.*)-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=list&amp;cid={R:1}&amp;q={R:2}&amp;list={R:3}&amp;page={R:4}" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-0-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=list&amp;cid=0&amp;q={R:1}" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/list'][0]?>/<?=$alias['tao/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=list" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/view'][0]?>/<?=$alias['tao/view'][1]?>-(.*)-(.*)-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=view&amp;iid={R:1}&amp;promotion_price={R:2}&amp;promotion_endtime={R:3}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/view'][0]?>/<?=$alias['tao/view'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=view&amp;iid={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="<?=$cur_path?><?=$alias['tao/shop'][0]?>/<?=$alias['tao/shop'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=shop&amp;nick={R:1}&amp;list={R:2}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/shop'][0]?>/<?=$alias['tao/shop'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=shop&amp;nick={R:1}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/zhe'][0]?>/<?=$alias['tao/zhe'][1]?>-(.*)-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=zhe&amp;q={R:1}&amp;cid={R:2}&amp;page={R:3}" appendQueryString="false" />
                </rule>
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/zhe'][0]?>/<?=$alias['tao/zhe'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=zhe&amp;q={R:1}" appendQueryString="false" />
                </rule>
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tao/zhe'][0]?>/<?=$alias['tao/zhe'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tao&amp;act=zhe" appendQueryString="false" />
                </rule>
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>-(\d+)-(\d+)-(\d+)-(\d+)-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=shop&amp;act=list&amp;cid={R:1}&amp;start_level={R:2}&amp;end_level={R:3}&amp;type={R:4}&amp;nick={R:5}&amp;page={R:6}" appendQueryString="false" />
                </rule>
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=shop&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=shop&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['shop/list'][0]?>/<?=$alias['shop/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=shop&amp;act=list" appendQueryString="false" />
                </rule>
                
                
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-0-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=list&amp;cid=0&amp;q={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-0-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=list&amp;cid=0&amp;q={R:1}" appendQueryString="false" />
                </rule>
                
                
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-(.*)-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=list&amp;sort={R:1}&amp;cid={R:2}&amp;page={R:3}" appendQueryString="false" />
                </rule>
				
				<rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/list'][0]?>/<?=$alias['baobei/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=list" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/user'][0]?>/<?=$alias['baobei/user'][1]?>-(\d+)-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=user&amp;uid={R:1}&amp;xs={R:2}&amp;page={R:3}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/user'][0]?>/<?=$alias['baobei/user'][1]?>-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=user&amp;uid={R:1}&amp;xs={R:2}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/user'][0]?>/<?=$alias['baobei/user'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=user&amp;uid={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['baobei/view'][0]?>/<?=$alias['baobei/view'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=baobei&amp;act=view&amp;id={R:1}" appendQueryString="false" />
                </rule>
                
                
                
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)-(\d+)-(\d+)-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;cid={R:1}&amp;mall_id={R:2}&amp;city_id={R:3}&amp;sort={R:4}&amp;page={R:5}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)-(\d+)-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;cid={R:1}&amp;city_id={R:2}&amp;sort={R:3}" appendQueryString="false" />
                </rule>

                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;cid={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;q={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(.*)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;q={R:1}&amp;page={R:2}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list&amp;q={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/list'][0]?>/<?=$alias['tuan/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=list" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['tuan/view'][0]?>/<?=$alias['tuan/view'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=tuan&amp;act=view&amp;id={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['help/index'][0]?>/<?=$alias['help/index'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=help&amp;act=index&amp;cid={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['help/index'][0]?>/<?=$alias['help/index'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=help&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['help/index'][0]?>/$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=help&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['help/index'][0]?>$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=help&amp;act=index" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['about/index'][0]?>/<?=$alias['about/index'][1]?>-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=about&amp;act=index&amp;id={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['about/index'][0]?>/<?=$alias['about/index'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=about&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['about/index'][0]?>/$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=about&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['about/index'][0]?>$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=about&amp;act=index" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['paipai/index'][0]?>/<?=$alias['paipai/index'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=paipai&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['paipai/index'][0]?>/$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=paipai&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['paipai/index'][0]?>$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=paipai&amp;act=index" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['paipai/list'][0]?>/<?=$alias['paipai/list'][1]?>-(\d+)-(.*)-(\d+)-(.*)-(\d+)-(\d+)-(\d+)-(\d+).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=paipai&amp;act=list&amp;cid={R:1}&amp;q={R:2}&amp;sort={R:3}&amp;property={R:4}&amp;begPrice={R:5}&amp;endPrice={R:6}&amp;list={R:7}&amp;page={R:8}" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['paipai/list'][0]?>/<?=$alias['paipai/list'][1]?>-(.*).html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=paipai&amp;act=list&amp;q=$1" appendQueryString="false" />
                </rule>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['paipai/list'][0]?>/<?=$alias['paipai/list'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=paipai&amp;act=list" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?>tbimg/(.*).jpg$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>comm/showpic.php?pic={R:1}" appendQueryString="false" />
                </rule>
                
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?><?=$alias['sitemap/index'][0]?>/<?=$alias['sitemap/index'][1]?>.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php?mod=sitemap&amp;act=index" appendQueryString="false" />
                </rule>
                <?php if($webset['static']['index']['index']!=1){?>
                <rule name="Imported Rule <?=$rule_name++?>">
                    <match url="^<?=$cur_path?>index.html$" ignoreCase="false" />
                    <action type="Rewrite" url="<?=$cur_path?>index.php" appendQueryString="false" />
                </rule>
                <?php }?>
            </rules>
        </rewrite> 
        <directoryBrowse enabled="false" />
        <defaultDocument>
            <files>
                <clear />
                <add value="index.php" />
                <add value="index.html" />
                <add value="Default.htm" />
                <add value="index.htm" />
            </files>
        </defaultDocument>
		<httpErrors>
            <remove statusCode="404" subStatusCode="-1" />
            <error statusCode="404" prefixLanguageFilePath="" path="/404.html" responseMode="ExecuteURL" />
        </httpErrors>
		<security> 
            <requestFiltering allowDoubleEscaping="true"></requestFiltering> 
        </security>
    </system.webServer>
</configuration>

<?php
$c=ob_get_contents();
dd_file_put(DDROOT.'/data/rewrite/web.config',$c);
ob_clean();
?>