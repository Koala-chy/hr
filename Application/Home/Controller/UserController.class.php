<?php

namespace   Home\Controller;

use Think\Controller;
   

//角色管理
class UserController  extends  Controller{
    
            
    //添加管理员
         public function role(){
                 
            $model = D('user');

            if(!empty($model ->create())){

                 $model -> password = sha1(sha1($model->password));

                  $res = $model ->add();

                  if($res){
                      $this ->success('添加成功');
                  }else{
                      $this ->error('添加失败');
                  }

            }else{

                $this ->error($model ->getError());
            }

                 
       }



    //获取管理员列表


      public function list_admin(){

          $model =D('user');

          $filed =array('id,username,rank,createtime');

          $order =array('id desc');

          $data = $model ->getList('',$filed,$order);

          $this ->data = $data;

          $this -> display();

      }






    
    
    
   
}