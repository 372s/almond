<?php

/**
 * 导入所需的类库 同java的Import 本函数有缓存功能
 * @param string $class 类库命名空间字符串
 * @param string $baseUrl 起始路径
 * @param string $ext 导入的文件扩展名
 * @return mixed
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

/**
 * 快速导入第三方框架类库 所有第三方框架的类库文件统一放到 系统的Vendor目录下面
 *
 * @param string $class 类库
 * @param string $baseUrl 基础目录
 * @param string $ext 类库后缀
 * @return mixed
 */
function vendor($class, $baseUrl = '', $ext='.php')
{
    if (empty($baseUrl)) {
        $baseUrl = LIB_PATH;
    }
    return import($class, $baseUrl, $ext);
}

/**
 * 基于命名空间方式导入函数库
 * load('PHPPager.Pager'); new \PHPPager\Pager();
 *
 * @param string $class 函数库命名空间字符串
 * @param string $baseUrl 起始路径
 * @param string $ext 导入的文件扩展名
 * @return mixed
 */
function load($class, $baseUrl = '', $ext='.php')
{
    if (empty($baseUrl)) {
        $baseUrl = LIB_PATH;
    }
    return import($class, $baseUrl, $ext);
}

/**
 * 加载配置文件 支持格式转换 仅支持一级配置
 * @param string $file 配置文件名
 * @return array
 */
function load_config($file){
    if (! is_file($file)) {
        $file = BASE_PATH . '/config/' . $file . '.php';
    }
    $ext  = pathinfo($file,PATHINFO_EXTENSION);
    switch($ext){
        case 'php':
            return include $file;
        case 'ini':
            return parse_ini_file($file);
        case 'yaml':
            return yaml_parse_file($file);
        case 'xml':
            return (array)simplexml_load_file($file);
        case 'json':
            return json_decode(file_get_contents($file), true);
        default:
            return include $file;
    }
}

/**
 * 导入视图
 * @throws \InvalidArgumentException
 * @param mixed $name
 * @return object
 */
function view($name = null)
{
    return \Bootstrap\View\View::make($name);
}

/**
 * array to json
 * @param array $arr
 * @return string
 */
function json($arr)
{
    return \Bootstrap\View\View::json($arr);
}
