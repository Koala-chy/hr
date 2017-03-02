<?php

namespace   Home\Controller;

use Think\Controller;
   

//角色管理
class UserController  extends  Controller{
    
            
    /**
     * 验证登陆
     */
    
    public function checkLogin(){
        
           if(IS_POST){
          
                 $model = D('user');
                 
                $where['username'] = I('post.username');
             
                $where['password'] = sha1(sha1(I('post.password')));
                
                $res = $model ->getFind($where);
                
//                var_dump($res);
                
                 if($res != NULL){
                      
                     session('Userid', $res['id']);
                    
                     session('name', $res['username']);
                     
          
                     redirect('/Index/index') ;
                     
                     
                 }else{
                     
                      $this ->error('登陆失败');
                      
                      exit();
                 }
                 
           }
        
        
    }

    
    //注销登陆
    
    public function loginOut(){
        
        unset($_SESSION['name']);
        unset($_SESSION['Userid']);
        
        $this ->redirect('/Index/login');
        
        
        
    }


    //添加管理员
         public function role(){
             
           if(IS_POST){
                           
                 $model = D('User');

             if(!empty($model ->create())){

                 $model -> password = sha1(sha1($model->password));

                  $res = $model ->add();

                  if($res){
                      $this ->success('添加成功','/User/list_admin');
                  }else{
                      $this ->error('添加失败');
                  }

            }else{

                $this ->error($model ->getError());
            }
                                
         }  
                          
    }



    //获取管理员列表


      public function list_admin(){

          $model =D('user');
          
          $search = I('get.search');
          
//          var_dump($search);
          
          $where['username'] = array('like',"%$search%");
          
         $page =  getPage($model, $where);

          $filed =array('id,username,rank,createtime');

          $order =array('id desc');

          $data = $model ->getList($where,$filed,$order);

          $this ->data = $data;
          $this ->search =$search;
         $this -> page =  $page ->show();
          $this -> display();

      }
      
      
      
     // 修改用户
      
     public function  edit_admin(){
         
           $model = D('user');
         
           $id = I('get.id');
           
           $where['id'] =$id;
           
           $field =array('id,username,rank');
          
          $data = $model ->getFind($where,$field);
           
           $this ->data =$data;
                   
            $this ->display();       
         
         
     }

    
     //提交修改用户数据
     public function save_admin(){
         
         if(IS_POST){
             
                 $model = D('user');
              
                  $where['id'] = I('post.id');
               
                  $data['username'] = I('post.username');
               
                  $data['password'] =sha1(sha1(I('post.password')));
                 
                  $data['rank'] = I ('post.rank');
                 
                  $res = $model ->where($where) ->save($data);
                  
                  if($res){
                      
                       $this ->success('修改成功','/User/list_admin');
                       
                  }else{
                      
                      $this ->error($model ->getError());
                  }
                
            }
            
      }

  
     //删除用户信息数据
      
     public function del_admin(){
         
          $model = D('user');
         
           $id =I('get.id');
         
           $where['id'] = $id;
           
          $res = $model ->delList($where);
          
          if($res){
              
               $this ->success('删除成功','/User/list_admin');
               
          }else{
              
                $this ->error('删除失败');
          }
          
         
     }
      
      
      //修改密码
     
      public function  save_psd(){
          
       if(IS_POST){
           
              $model = D('User') ;
           
             $where['id'] = I('post.id');
           
              $data['password'] = sha1(sha1(I('post.password')));
             
              $res = $model ->Update($where,$data);
               
             if($res){
                 
                 $this ->success('修改成功','/User/list_admin');
                         
             }else{
                 
                 $this ->error('修改失败');
                         
             }
           
       }      
        
         
    
      }
     
     
     
     
     
     
     
     
 
   
}