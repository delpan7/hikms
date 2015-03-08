<?php

/**
 * 插件基类
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-5-9
 */
namespace Common\Core;
class Widget extends \Think\Controller {
    
    public $widget_path          =   '';
    protected $method = '';

    public function _initialize() {
        $this->addon_path = C('WIDGET_PATH').$this->getName().'/';
        layout(false); // 临时关闭当前模板的布局功能
    }
    public function __call($method, $args) {
        $this->method = str_replace(C('ACTION_SUFFIX'), '', $method);
        if(method_exists($this,$this->method)) {
            $this->{$this->method}($args[0]);
        }elseif(method_exists($this,'_empty')){
            // 如果定义了_empty操作 则调用
            $this->_empty($this->method,$args[0]);
        }elseif(file_exists_case($this->getTemplateFile())){
            // 检查是否存在默认模版 如果有直接输出模版
            $this->assign($args[0]);
            $this->display();
        }else{
            E(L('_ERROR_ACTION_').':'.$this->method);
        }
    }
    
    //显示方法
    protected function display($template=''){
        echo ($this->fetch($template));
    }
    
    /**
     *  获取输出页面内容  本方法覆盖父类的方法
     * 调用内置的模板引擎fetch方法，
     * @access protected
     * @param string $templateFile 指定要调用的模板文件
     * 默认为空 由系统自动定位模板文件
     * @param string $content 模板输出内容
     * @param string $prefix 模板缓存前缀* 
     * @return string
     */
    protected function fetch($templateFile='',$content='',$prefix='') {
        $templateFile = $this->getTemplateFile($templateFile);
        if(!is_file($templateFile)){
            throw new \Exception("模板不存在:$templateFile");
        }
        return $this->view->fetch($templateFile,$content,$prefix);
    }
    
    public function getTemplateFile($templateFile='') {
        if($templateFile == ''){
            $templateFile = $this->method;
        }
        if(!is_file($templateFile)){
            $templateFile = $this->addon_path.$templateFile.C('TMPL_TEMPLATE_SUFFIX');
        }
        return $templateFile;
    }
    
    public function getName(){
        $class = get_class($this);
        return substr($class,strrpos($class, '\\')+1, -6);
    }
}
