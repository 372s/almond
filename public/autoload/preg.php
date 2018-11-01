<?php
require_once dirname(__DIR__) . '/../vendor/autoload.php';

$html = '<div>我</div>';
print_r(filter_me($html));