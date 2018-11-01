<?php
/**
 * Created by PhpStorm.
 * User: wq455
 * Date: 2018/10/18
 * Time: 02:10
 */

$html = file_get_contents('http://m.zynews.cn/zz/node_9025.htm');

$dom = new DomDocument();
$dom->loadHTML($html);
$xpath = new DomXPath($dom);
// $tag1 = $dom->getElementsByTagName("tag1")->item(0);

$href = $xpath->query('//div[@class="news-list"]/a/@href'); //output 2 -> correct

foreach ($href as $url) {
    echo $url->value;
}


die;
//建立Dom对象，分析HTML文件；
$doc = new DOMDocument;
@$doc->loadHTML($html);
$doc->validateOnParse = true;
$doc->preserveWhiteSpace = false;
$params = $doc->getElementsByTagName("li");
echo $doc->saveHTML($doc->getElementsByTagName("li")->item(0));die;

foreach($params as $param)
{
    foreach($params->item($i)->childNodes as $node)
    {
        if($node->nodeName == 'a')
        {
            //assert ($node != null);
            echo $node->getAttribute("href") . "<br>"; // bug? empty
            echo $node->nodeValue . "<br>";
        }
    }

}
die;
$as = $doc->getElementsByTagName("a");
foreach ($as as $finance) {
//    $child = $finance->childNodes;
    assert ($finance != null);
    echo $finance->getAttribute("href") . "<br>";
}
die;
assert ($res != null);
$strId = $res->getAttribute("id"); // bug? empty
print_r($strId);die;


$html = file_get_contents('http://m.zynews.cn/zz/2018-10/15/content_11547998.htm');
// echo $html;die;
//建立Dom对象，分析HTML文件；
$doc = new DOMDocument;
$doc->validateOnParse = true;
@$doc->loadHTML($html);
$doc->preserveWhiteSpace = false;
$res = $doc->getElementById("text");
assert ($res != null);
$strId = $res->getAttribute("id"); // bug? empty
print_r($strId);die;
echo $res->nodeValue; die;

$doc = new DOMDocument();
@$doc->loadHTML($html);
$xpath = new DOMXpath($doc);
$elements = $xpath->query("//div[@class='text']");
// print_r($elements);die;
if (!is_null($elements)) {
    foreach ($elements as $element) {
        echo "<br/>[" . $element->nodeName . "]";
        print_r($element) ;die;
        $nodes = $element->childNodes;
        foreach ($nodes as $node) {
            echo $node->nodeValue . "\n";
        }
    }
}
die;