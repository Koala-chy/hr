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
 * @param type $where  条件
 * @param type $p    页码初始值P
 * @param type $pagenumb  页码
 * @param type $rollpage   显示几条数据
 * @return \Common\Util\MyPage   调用分页类
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

/**
 *  统计面试信息数据
 * @param type $job  面试岗位
 * @param type $jobstatus  面试状态
 * @return type  
 */
 function   invite($job,$jobstatus){
     
            $model = M('resumes');
            
             $where['jobstatus'] = $jobstatus;
      
             $where['job'] =$job;
            
             $count = $model ->where($where) ->count();
         
    
             return $count;
    
}


