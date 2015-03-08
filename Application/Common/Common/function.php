<?php
/**
 * 公用函数库
 */

/**
 * 实例化Common下的公共Model类 格式 模型
 * @param string $name 资源地址
 * @return Model
 */
function model($name='') {
    return D('Common/'.$name);
}

/**
 * 实例化Common下的公共Model类 格式 模型
 * @param string $name 资源地址
 * @return Model
 */
function service($name='') {
    return D('Common/'.$name, 'Service');
}

/**
 * 生成验证码
 * @param array $config
 * @return img
 */
function create_verify($config = array()) {
    $Verify = new \Think\Verify($config);
    return $Verify->entry();
}

/**
 * 检测输入的验证码是否正确，
 * @param string $code 为用户输入的验证码字符串
 * @param string $id
 * @return bool
 */
function check_verify($code, $id = ''){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置，默认从0开始
 * @param string $length 截取长度，默认截取30个字
 * @param string $charset 编码格式，默认utf-8
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start=0, $length=30, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr")){
        $slice = mb_substr($str, $start, $length, $charset);
    }elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 单位 秒
 * @return string
 */
function sys_encrypt($data, $key = '', $expire = 0) {
    $key = $key ? $key : C('DATA_CRYPT_KEY');
    return Think\Crypt::encrypt($data, $key, $expire);
}

/**
 * 系统解密方法
 * @param  string $data 要解密的字符串 
 * @param  string $key  加密密钥
 * @return string
 */
function sys_decrypt($data, $key = ''){
    $key = $key ? $key : C('DATA_CRYPT_KEY');
    return Think\Crypt::decrypt($data, $key);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}

/**
 * 根据传入的数据返回查询条件 是用in 还是等于
 * @param mixed $data
 * @return array
 */
function whereCan($data){
    if(!is_array($data)){
        $data = filterStrPunc($data);//将其它支持的符号替换为英文逗号
        if(stripos(',', $data) !== false){
            $data = explode(',', $data);
        }else{
            return $data;
        }
    }
    return array('in', $data);
}

/**
 * 渲染输出Widget
 * @param string $name Widget名称
 * @param array $data 传入的参数
 * @return void
 */
function Widget($name, $data=array()) {
    return R($name,array($data),'Widget');
}

/**
 * 过滤字符串中的字符，将不合法的逗号替换为合法的逗号将回车，中文逗号替换为英文逗号
 * @param string $str
 * @return string
 */
function filterStrPunc(string $str){
    $search = array('，', ':', ';', '；', '：');
    
    $str = str_replace($search, ',', $str);
    $str = preg_replace("/[\n\r\t]+/", ',', $str);
    $arr = explode(',', $str);
    foreach($arr as &$v){
        $v = trim($v);
    }
    $arr = array_filter($arr);
    
    return implode(',', $arr);
}

/**
 * 将"0：错误,1：正确"这种数据转换为array(0=>"错误",1=>"正确")
 * @param string $value
 * @return array
 */
function optionStrToArr($value){
    $array = preg_split('/[,;\r\n]+/', trim($value, ",;\r\n"));
    if (strpos($value, ':')) {
        $value = array();
        foreach ($array as $val) {
            list($k, $v) = explode(':', $val);
            $value[$k] = $v;
        }
    } else {
        $value = $array;
    }
    return $value;
}

/**
 * 判断传入的参数是否是整数，包括整数字符串
 * @param int||string $int_str
 * @return boolean
 */
function is_intstr($int_str){
   if(is_numeric($int_str)){
       $int_str += 0;
       if(is_int($int_str)){
           return TRUE;
       }
   }
   return FALSE;
}

/**
 * 将二维数组中的一个key值做为key格式化数组
 * @param array $arrs
 * @param string $key
 * @return array
 */
function formatArrByValue($arrs, $key){
    $res = array();
    foreach($arrs as &$arr){
        $res[$arr[$key]] = $arr;
        unset($arr);
    }
    return $res;
}

function getTree($datas){
    foreach($datas as $key=>&$data){
        if($data['fid']){
            $datas[$data['fid']]['children'][] = $data;
            unset($datas[$key]);
        }
    }
    return $datas;
}