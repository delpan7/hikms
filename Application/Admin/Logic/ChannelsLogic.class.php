<?php

/**
 * Description of ChannelLogic
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-7-6
 */
namespace Admin\Logic;
class ChannelsLogic {
    
    public function getFormatTree($datas, $fid=0, $level=1) {
        $class = ($level === 1) ? 'tree-container' : '';
        $str = '<ul class="channel-tree-ul '.$class.'" '.($fid ? 'id="channel_fid_'.$fid.'"' : '').'>';
        $count = count($datas);
        $i = 0;
        foreach ($datas as $data) {
            $i++;
            $children_tree = $class = '';
            $class .= $i == $count ? " li-last" : '';
            if(isset($data['children']) && $data['children']){
                $children_tree .= $this->getFormatTree($data['children'], $data['id'], ++$level);
            }else{
                $class .= " li-leaf";
            }
            $str .= '<li class="channel-tree-li li-closed'.$class.'" >'
            .'<i class="tree_icon tree_ocl" rel="'.$data['id'].'"></i><i class="tree_icon tree_folder"></i>'
            .'<input type="checkbox" class="ids row-selected" name="id[]" value="'.$data['id'].'"/><a href="'.$data['url'].'">'.$data['name'].'</a>'
            .'<span style="float: right;">
        <a href="'.U('Admin/Channel/add', array('pid'=>$data['id'])).'" title="添加子栏目">添加子栏目</a>
        <a href="'.U('Admin/Channel/edit', array('id'=>$data['id'])).'" title="修改">修改</a>
        <a href="'.U('Admin/Channel/delete', array('id'=>$data['id'])).'" title="删除" class="confirm ajax-get">删除</a>
      </span>';
            $str .= $children_tree;
            $str .= '</li>';
        }
        $str .= '</ul>';
        return $str;
    }
    
    
}
