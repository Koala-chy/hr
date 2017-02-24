<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 23:30
 */


//分页函数
/**
 * @param type $model
 * @param type $where
 * @param type $p
 * @param type $pagenumb
 * @param type $rollpage
 * @return \Common\Util\MyPage
 * @author 常 弘扬 <changhongyang@123.com.cn>
 */
function  getPage(&$model,$where,$p='p',$pagenumb=5,$rollpage=5){
        
        $m =  clone  $model;
                //分页
         $count =$model ->where($where)->count();
         
         $model =$m;

         $nowPage = I("get.$p",1);

         $PageNum = $pagenumb;

         $starPage =($nowPage -1)*$PageNum;

         $page =new \Common\Util\MyPage($count,$PageNum);

         $page -> setConfig('prev', '上一页');
         $page -> setConfig('next','下一页');
         $page -> setConfig('last','末页');
         $page -> setConfig('first','首页');
//         $page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
         $page->rollPage = $rollpage;
         $page->lastSuffix = false;
        
         $model ->limit($starPage,$PageNum);
         
         return $page;
    
  
}