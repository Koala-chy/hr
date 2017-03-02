<?php
/**
 * Created by PhpStorm.
 * User: koala
 * Date: 2017/3/2
 * Time: 15:25
 */

namespace Home\Model;

use Think\Model;

class RequirementsModel extends Model{


    //自动验证
    protected $_validate = array(

        array('position','','招聘岗位已存在！',0,'unique',1), // 在新增的时候验证position字段是否唯一


    );


    //自动完成

    protected $_auto = array (

        array('createtime','time',1,'function'), // 对createtime字段在更新的时候写入当前时间戳



    );



    /**
     * 统计某一字段和值
     * @param $where 条件
     * @param $sum  指定字段
     * @return mixed
     */
     public function getSum($sum){

         return $this->sum($sum);


     }


    /**
     * 查询数据
     * @param $field
     * @param string $where
     * @return mixed
     */

    public function getList($field,$where=''){


        return $this ->field($field) ->where($where)->select();



    }






}