<?php
require_once dirname(__DIR__) . '/../vendor/autoload.php';

// pq(); is using selected document as default phpQuery::selectDocument($doc);
// documents are selected when created or by above method
// query all unordered lists in last selected document pq('ul')->insertAfter('div');
$url = 'http://m.sohu.com/a/270911774_260616?_f=m-index_important_news_1&spm=smwp.home.fd-important.1.1540362503310t1GVfv1';
$content = file_get_contents($url);
$doc = phpQuery::newDocumentHTML($content);
$div = pq("section[id='articleContent']")->html();
echo $div;die;