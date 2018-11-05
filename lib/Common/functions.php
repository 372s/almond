<?php

if (function_exists('import')) {
    /**
     * 导入所需的类库 同java的Import 本函数有缓存功能
     * @param string $class 类库命名空间字符串
     * @param string $baseUrl 起始路径
     * @param string $ext 导入的文件扩展名
     * @return boolean
     */
    function import($class, $baseUrl = '', $ext= '.class.php')
    {
        static $_file = array();
        $class = str_replace(array('.', '#'), array('/', '.'), $class);
        if (isset($_file[$class . $baseUrl])){
            return true;
        } else {
            $_file[$class . $baseUrl] = true;
        }

        if (empty($baseUrl)) {
            $baseUrl = LIB_PATH;
        }

        if (substr($baseUrl, -1) != '/') {
            $baseUrl .= '/';
        }
        $class_file = $baseUrl . $class . $ext;
        require_once $class_file;
    }
}

if (function_exists('vendor')) {
    /**
     * 快速导入第三方框架类库 所有第三方框架的类库文件统一放到 系统的Vendor目录下面
     * @param string $class 类库
     * @param string $baseUrl 基础目录
     * @param string $ext 类库后缀
     * @return boolean
     */
    function vendor($class, $baseUrl = '', $ext='.php')
    {
        if (empty($baseUrl)) {
            $baseUrl = LIB_PATH;
        }
        return import($class, $baseUrl, $ext);
    }
}


if (function_exists('load')) {
    function load()
    {

    }
}

if (function_exists('view')) {
    /**
     * 导入视图
     * @throws \InvalidArgumentException
     * @param mixed $name
     * @return object
     */
    function view($name = null)
    {
        return \Bootstrap\View::make($name);
    }
}
