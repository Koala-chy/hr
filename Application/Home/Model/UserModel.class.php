<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/28
 * Time: 23:08
 */

namespace Home\Model;

use Think\Model;

class UserModel extends Model{

    //自动验证
    protected $_validate = array(

        array('username','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一

        array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
        
         array('username','checkName','用户名错误',0,'callback',4),
        
          array('password','checkPwd','密码错误',0,'callback',4),
 
    );
    
    
    function  checkName($field){
        
               $where['username'] =$field;
               
               $res = $this ->where($where) ->find();
               
               if($res != NULL){
                   
                   return  TRUE;
                   
               }else{
                   
                   return  FALSE;
               }
              
    }
    
   
    function   checkPwd($filed){
        
                $where['password'] =  sha1(sha1($filed));
        
                 $res = $this ->where($where) ->find();
               
                if($res != NULL){
                   
                   return  TRUE;
                   
               }else{
                   
                   return  FALSE;
               }
        
    }

    






    //自动完成

    protected $_auto = array (

        array('createtime','time',1,'function'), // 对createtime字段在更新的时候写入当前时间戳



    );

    
   /**
    * 获取列表
    * @param type $where   where条件
    * @param type $field      field 字段
    * @param type $order   order
    * @return type
    */ 
    public function getList($where='',$field,$order){


        return   $this ->where($where)->field($field)->order($order)->select();

    }


   /**
    * 获取单条数据
    * @param type $where
    * @param type $field
    * @return type
    */
    public function  getFind($where,$field=''){
              
        return $this ->where($where) ->field($field)->find();
        
        
        
    }
    
    /**
     * 删除数据
     * @param type $where
     * @return type
     */
    
    public function  delList($where){
        
        
        return $this ->where($where) ->delete();
        
        
    }
    
    
    /**
     * 更新数据
     * @param type $where
     * @param type $data
     * @return type
     */
    
    public function  Update($where,$data){
        
        
        return $this ->where($where)->save($data);
        
        
    }
    
    
  

}