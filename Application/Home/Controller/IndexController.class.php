<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {


    public  function  index(){
        
         $this -> display();

     }


  //部门及岗位管理

     
     /**
      * 调取部门及岗位管理视图页面数据
      * @author 常 弘扬 <changhongyang@123.com.cn>
      */
     public function section_manage(){

         $model = M('H_section');

         $search = I('get.search');

//         var_dump($search);

         $arr['job']  = array('like', "%$search%");
         $arr['_logic'] = 'and';
         $where['_complex'] = $arr;
         $where['pid'] = array('eq',0);

         $page =  getPage($model, $where);

         $data = $model->field('id,pid,job')->where($where)->select();

//         var_dump($model ->getLastSql());

         $Job_data = $model -> field('id,pid,job') ->where('pid !=0') ->select();

//         var_dump($a);
//         var_dump($data);
         $this -> Job_data =$Job_data;
         $this ->data =$data;
         $this ->search =$search;
         $this -> page =  $page ->show();
         $this->display();
         
     }


    
    /**
     *  获取部门参数id
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */ 
     
    public function add_job(){

         $id = I('get.id');

         $this -> id = $id;

         $this -> display();

    }

    
    
    /**
     *   调取岗位下拉框一级目录数据
     * @author 常 弘扬 <changhongyang@123.com.cn>
     */
    
    public function add_resume(){
        
         $model = M('H_section');
        
        $data = $model->field('id,pid,job')->where('pid =0 ')->select();
        
         $this ->data =$data;
      
         $this -> display();
        
    }
    
    
    
    public function edit_resume(){
        
        $model = M('H_section');
        
        $id = I('get.id');
        
        $where['id'] = $id;
       
       $data = $model -> where($where) ->find();
        
       $this ->data =$data;
       
//        var_dump($data) ;
        
         $this ->display();
        
    }

    






    /**
    * ajax接收 并返回
    * @author 常 弘扬 <changhongyang@123.com.cn>
    */
    public function getAjax(){
        
          $id = I('post.id');
        
          $model = M('H_section');
        
          $arr['pid'] = $id;
          
          $data =array();
          
          $data = $model->field('id,pid,job')->where($arr)->select();
         
         $this ->ajaxReturn($data,'JSON');
          
          
    }
    
    
            
            
       

   



}