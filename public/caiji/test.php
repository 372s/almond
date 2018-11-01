<?php
/**
 * Created by PhpStorm.
 * User: wangqiang
 * Date: 2018/10/16
 * Time: 15:31
 */

header("Content-type: text/html; charset=utf-8");

$html = '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<div class="wrap">
<ul class="newsPage"><li><a href="2018-10/05/content_11539382.htm">原中央政治局常委、中纪委书记吴官正： ...</a></li><li><a href="focus/2018-09/28/content_11532979.htm">应急管理部：西藏日土县5.1级地震暂无人...</a></li><li><a href="2018-09/28/content_11532971.htm">台大研究：睡前滑手机8分钟 会让人晚睡1...</a></li><li><a href="2018-09/28/content_11532335.htm">铁路公安打击倒票“秋风-2018”战役查缴...</a></li><li><a href="2018-09/28/content_11532128.htm">动辄上亿！超“壕”的苏富比秋拍来了， ...</a></li><li><a href="2018-09/27/content_11530473.htm">零下40度不懈巡逻 他们在中俄边境守住祖...</a></li><li><a href="2018-09/26/content_11529057.htm">焦虑、马屁、戏精、广告 家长群渐渐多了...</a></li><li><a href="2018-09/21/content_11523531.htm">海关提醒：携带月饼出境需谨慎</a></li><li><a href="2018-09/21/content_11523523.htm">教育部规范中小学生竞赛：不再是升学“ ...</a></li><li><a href="2018-09/21/content_11523063.htm">全国146个城市集中统一销毁非法枪爆物品</a></li><li><a href="2018-09/19/content_11520298.htm">第四届杭州灯光小品秀举行</a></li><li><a href="2018-09/18/content_11519022.htm">川藏铁路拉林段车站道岔进入铺设阶段</a></li><li><a href="2018-09/13/content_11514310.htm">99%阳澄湖大闸蟹都是冒牌货？认准品牌，...</a></li><li><a href="2018-09/13/content_11514209.htm">史上最蠢抢匪？抢劫时“手滑”掉枪 落荒...</a></li><li><a href="2018-09/11/content_11511944.htm">自闭症发病率超1% ?专家提醒要警惕孩子 ...</a></li></ul>
</div>';
// $html = mb_convert_encoding($html, 'gb2312', 'utf-8');
// $html = '<meta http-equiv="Content-Type" content="text/html;charset=gb2312">' . $html;
$doc = new DomDocument('1.0','UTF-8');
$doc->loadHtml($html);
$node = $doc->getElementsByTagName('div')->item(0);
// print_r($node);die;
$outerHTML = $doc->ownerDocument->saveHTML($node);
$innerHTML = '';
foreach ($node->childNodes as $childNode){
    $innerHTML .= $childNode->ownerDocument->saveHTML($childNode);
}
echo '<h2>outerHTML: </h2>';
echo htmlspecialchars($outerHTML);
echo '<h2>innerHTML: </h2>';
echo htmlspecialchars($innerHTML);die;


$xml = "<?xml version='1.0' encoding='UTF-8'?>
         <test>
             <tag1>
                 <uselesstag>
                     <tag2>test</tag2>
                 </uselesstag>
             </tag1>
             <tag2>test2</tag2>
         </test>";

$dom = new DomDocument();
$dom->loadXML($xml);
$xpath = new DomXPath($dom);

$tag1 = $dom->getElementsByTagName("tag1")->item(0);

echo $xpath->query("//tag2")->length; //output 2 -> correct
echo $xpath->query("//tag2", $tag1)->length; //output 2 -> wrong, the query is not relative
echo $xpath->query(".//tag2", $tag1)->length; //output 1 -> correct (note the dot in front of //)