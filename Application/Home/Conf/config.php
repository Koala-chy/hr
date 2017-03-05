<?php
return array(
    //'配置项'=>'配置值'
    'EDULEVEL'=>array( //最高学历
        '1'=>'博士研究生',
        '2'=>'硕士研究生',
        '3'=>'大学本科',
        '4'=>'大学专科',
        '5'=>'中等专科',
        '6'=>'高中',
        '7'=>'初中',
        '8'=>'小学',
        '9'=>'其他',
    ),
    'EXPERIENCE' => array(
        '1'=>'应届毕业生',
        '2'=>'一年',
        '3'=>'二年',
        '4'=>'三年',
        '5'=>'四年',
        '6'=>'五年',
        '7'=>'六年',
        '8'=>'七年',
        '9'=>'八年',
        '10'=>'九年',
        '11'=>'十年以上',

    ),
    
    'JOBSTATUS'=>array(

        '1'=>'已面试',
        '2'=>'未面试',
        '3'=>'邀约',    
        '4'=>'面试合格',
        '5'=>'不合格',


    ),


    'UPLOADFILE' => array(
        'maxSize'   =>'0',
        'exts'      =>array('pdf'),
        'rootPath'  =>'./Public/Uploads/',

    ),


       /* 信息提示页面模板 */
    'TMPL_ACTION_ERROR'     =>  MODULE_PATH.'View/Public/error.html', // 默认错误跳转对应的模板文件

    'TMPL_ACTION_SUCCESS'   =>  MODULE_PATH.'View/Public/success.html',



);