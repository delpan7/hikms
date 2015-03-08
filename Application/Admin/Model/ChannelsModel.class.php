<?php

/**
 * Description of ChannelModel
 *
 * @author delpan <delpan.sinasae.com>
 * @email 243334464@qq.com
 * @date 2014-7-6
 */

namespace Admin\Model;
use Common\Core\Model;
class ChannelsModel extends Model {
    
    public function getchannels() {
        $channels = $this->order('fid DESC')->select();
        return formatArrByValue($channels, 'id');
    }
    public function getChannelById($id) {
        $map['id'] = intval($id);
        return $this->where($map)->find();
    }
    
    public function addChannel($data) {
        if($this->create($data)){
            if($id = $this->add()){
                return $id;
            }
        }
        return FALSE;
    }
    public function updateChannel($id, $data) {
        $map['id'] = intval($id);
        if($this->create($data)){
            if($this->where($map)->save($data)){
                return TRUE;
            }
        }
        return FALSE;
    }
    function deleteChannel($ids) {
        $map['id'] = whereCan($ids);
        return $this->where($map)->delete();
    }
}
