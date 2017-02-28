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


    );

   //自动完成

    protected $_auto = array (

        array('createtime','time',1,'function'), // 对createtime字段在更新的时候写入当前时间戳



    );

    public function getList($where='',$field,$order){


      return   $this ->where($where)->field($field)->order($order)->select();

    }





}