```$xslt
nl2br();// \n to <br>

addslashes(); stripslashes();//对数据库操作时，转义特殊字符

rtrim();//除去字符串右边空格
trim();//除去字符串中所有空格
ltrim();//除去字符串左边空格

htmlspecialchars();//转换'$','"','<','>'为相应的html实体
htmlentities();//转换所有html标记为相应的html实体

array explode(string separator, string str);//分割字符串
string implode(string separator, array arr);//连接字符串

strtoupper(); strtolower();//转换大小写
ucfirst();//只转换第一个字符为大写
ucwords();//转换每个words的第一个字母为大写 
```