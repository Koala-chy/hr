<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 22:02
 */

namespace Home\Controller;

use Think\Controller;

//招聘管理  
class RecruitController extends Controller{


    //招聘人数图表数据调取

     public function   job_chart(){

         $model = D('Requirements');

        $where['type'] = 0;

        $data = $model ->getList('position,number,type',$where);

        $data = json_encode($data);


        $this -> ajaxReturn($data);

     }



    //部门及岗位管理

    /**
     * 添加部门
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */

    public function Ad_section(){

        if(IS_POST){
            $model = M('section');

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

           $model = M('section');

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
        
        if(IS_POST){
            
        $id = I('post.id');
        
         $val = I('post.val');  
         
         $data['job'] = $val ;
              
         $where['id'] = $id;
        
         $model = M('section');
        
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
              
}

    
    /**
     * 删除部门操作
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */
    public function del_section(){
       
          $id =I('get.id');
          
         $model = D('section');
         
         $where['id'] = $id;
             
         $res = $model ->where($where)->delete();
                 
        if($res){
            
               $this -> success('删除成功','/Index/section_manage');
               
        }  else {
            
              $this -> success('删除失败','/Index/section_manage');
        }
         
    }


    /**
     * 修改部门
     * @开发者:ChangHongYang
     */
    
    public function save_resume(){
        
        if(IS_POST){
            
             $id = I('post.id');
              
             $job = I('post.job');
             
              $where['id'] = $id;
              $data['job'] = $job;
              $model = M('section');
             
             $res = $model -> where($where) ->save($data);      
             
             if($res){
                 
                 $this->success('修改成功','/Index/section_manage');
                 
             }  else {
                 
                 $this->error('修改失败');
             }
           
        }
        
    }


    /**
     * 增加招聘需求
     * @开发者:ChangHongYang
     */
    
    public function Ad_need(){
        
         if(IS_POST){
            
                 $model = D('Requirements');

//       var_dump($model);

             if(!empty($model ->create())){

                 $model ->arrivaldate =strtotime($model->arrivaldate);

                 $res = $model ->add();

                 if($res){
                     $this ->success('添加成功','/Index/recruit');
                 }else{
                     $this ->error('添加失败');
                 }

             }else{

                 $this ->error($model ->getError());
             }

           }
        
    }

    
  /**
   * 修改招聘状态
   */
    public function  save_type(){
        
        $model = M('requirements');
        
         $id = I('get.id');
        
         $type = I('get.type');
        
         $where['id'] = $id;
        
         $data['type'] = $type;
         
         $res =$model ->where($where) ->save($data);
         
          if($res){
                  
                 $this ->success('状态修改成功','/Index/recruit');
           }
        
        
    }
    
    /**
     * 修改招聘信息
     */
    public function save_need(){
         
          $model = M('requirements');
          
          $model ->create();
         
          $where['id'] =$model ->id;
          
          $model ->arrivaldate =  strtotime($model ->arrivaldate);
          
          $model->createtime = time();
          
         $res = $model ->where($where)  ->save();
        
         if($res){
             
                 $this ->success('修改成功','/Index/recruit');
         }  else {
             
                $this ->error($model ->getError());
         }
         
    }
    
    
    public function del_need(){
        
        $model = M('requirements');
        
        $where['id'] = I('get.id');
        
        $res =$model ->where($where)->delete();
        
        if($res){
            
              $this ->success('删除成功','/Index/recruit');
        }  else {
            
            $this ->error('删除失败');
           
        }
        
    }
    
    
    
    


}