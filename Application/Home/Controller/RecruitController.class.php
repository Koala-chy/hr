<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 22:02
 */

namespace Home\Controller;

use Think\Controller;

class RecruitController extends Controller{


    //部门及岗位管理


    /**
     * 添加部门
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */

    public function Ad_section(){

        if(IS_POST){
            $model = M('H_section');

            $data = $model ->create();

            if(!empty($data)){

               $model ->pid = 0;

               $res = $model -> add();

               if($res){
                   $this ->success('提交成功','/Index/section_manage');
               } else{

                   $this ->error('提交失败');
               }
            }
        }
    }

    
    
    /**
     * 添加岗位
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */

    public function Ad_job(){

       if(IS_POST){

           $model = M('H_section');

           $data = $model ->create();

           if(!empty($data)){

               $res = $model -> add();

               if($res){
                  $this ->success('提交成功','/Index/section_manage');
               } else{

                   $this ->error('提交失败');
               }
           }

       }

    }
    
    
    
    /**
     *  ajax 提交数据 修改工作岗位
     *  @author 常 弘扬 <changhongyang@123.com.cn>
     */
    
    public function edit_job(){
        
         $id = I('post.id');
        
         $val = I('post.val');  
         
         $data['job'] = $val ;
              
         $where['id'] = $id;
        
         $model = M('H_section');
        
         if($val == ''){
              $res = $model ->where($where) ->delete();
         }else{
             $res = $model ->where($where) ->save($data);
         }
            
        if($res){
            
            $this ->ajaxReturn(1);
            
        }  else {
            
               $this ->ajaxReturn(0);
        }
        
    }

    
    /**
     * 删除部门操作
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */
    public function del_section(){
       
          $id =I('get.id');
          
         $model = M('H_section');
         
         $where['id'] = $id;
         
         $res = $model ->where($where)->delete();
        
        if($res){
            
               $this -> success('删除成功','/Index/section_manage');
               
        }  else {
            
              $this -> success('删除失败','/Index/section_manage');
        }
         
    }
    
    
    
    
    public function save_resume(){
        
             $id = I('post.id');
              
             $job = I('post.job');
             
              $where['id'] = $id;
              $data['job'] = $job;
             $model = M('H_section');
             
             $res = $model -> where($where) ->save($data);      
             
             if($res){
                 
                 $this->success('修改成功','/Index/section_manage');
                 
             }  else {
                 
                 $this->error('修改失败');
             }
 
    }
    
    
     

    
  


}