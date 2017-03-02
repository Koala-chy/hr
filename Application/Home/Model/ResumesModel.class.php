<?php
/**
 * Created by PhpStorm.
 * User: koala
 * Date: 2017/3/2
 * Time: 15:41
 */

namespace Home\Model;

use Think\Model;

class ResumesModel extends  Model{


    /**
     * 统计数据
     * @param string $where
     * @return mixed
     */
    public function getCount($where=''){


      return  $this ->where($where)->count();

    }









}