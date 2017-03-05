<?php

namespace Home\Behavior;

use Think\Behavior;

class TestBehavior extends Behavior {

    public function run(&$params){

//        var_dump(MODULE_NAME);
//        var_dump(CONTROLLER_NAME);
//        var_dump(ACTION_NAME);
//        var_dump($_SESSION['name']);
        $arr= array(
             
                  'index','add_admin','list_admin','add_admin','edit_admin','section_manage',
                 
                   'add_section','add_job','edit_section','recruit','add_need','look_recruit',
               
                   'alert_need','talents','add_resume','view_resume','edit_resume','interview',
            
                   'view_resume','edit_resume'
                 
        );


      if(MODULE_NAME=='Home'){

          if( in_array(ACTION_NAME,$arr)){

              if(session('name')==''|| session('Userid')==''){
                  
                  redirect('/Index/login');         
                  
                  exit;
            }
            
        }
    }


     //权限判定


     //普通用户

        $normal = array(

             'add_admin','list_admin','section_manage','recruit','talents','interview'

        );

        if(MODULE_NAME=='Home'){

            if( in_array(ACTION_NAME,$normal)){

                if(session('rank') == 0){

                     echo "<div style='text-align: center;margin-top: 80px'><img src='/Public/images/permission.png'></div>";

                    exit;
                }
            }
        }




      //管理员

        $admin  = array(

               'add_admin','list_admin'


        );

        if(MODULE_NAME=='Home'){

            if( in_array(ACTION_NAME,$admin)){

                if(session('rank') == 1){

                    echo "<div style='text-align: center;margin-top: 80px'><img src='/Public/images/permission.png'></div>";

                    exit;
                }
            }
        }


    }

}