<?php

$ari = '有任何肌肤问题也可以问我，微信：234132';
echo preg_match('/微信：[\w\x{4e00}-\x{9fa5}]+/ui', $ari);