<?php

namespace Home\Model;

class SectionModel extends \Think\Model {

    protected function _after_delete($data, $options) {
        
         parent::_after_delete($data, $options);
         
         D('Resumes')->where('reals='.$data['id'])->delete();
        
    }
    
       public function getList($map,$order,$limit,$field){
           
          return $this->where($map)->order($order)->limit($limit)->select();
         
     }
    
    
    
    
  
    
}
