<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {


    public  function  index(){
        
         $this -> display();

     }
     
     
     
     /**
      * 清除缓存
      * @param type $R
      * @return type
      */
    private function _deleteDir($R){
                                                     //打开一个目录句柄
        $handle = opendir($R);
                                                   //读取目录,直到没有目录为止
        while(($item = readdir($handle)) !== false){
                                          //跳过. ..两个特殊目录
            if($item != '.' and $item != '..'){
                                        //如果遍历到的是目录
                if(is_dir($R.'/'.$item)){
                                     //继续向目录里面遍历
                    $this->_deleteDir($R.'/'.$item);
                }else{
                                 //如果不是目录，删除该文件
                    if(!unlink($R.'/'.$item))
                        die('error!');
                }
            }
        }
        //关闭目录
        closedir( $handle );
        //删除空的目录
        return rmdir($R);
    }

    //清除缓存--删除runtime文件夹
    public function delRun () {
        //获取url的第三项值
                 $get =I('get.url');
        //如果目录是 delRun
            if($get == 'delRun'){
            //获取当前的缓存目录
                      $R =RUNTIME_PATH;
            //执行删除函数
                       if($this->_deleteDir($R)){

                       $this -> ajaxReturn(1);
            }

        }
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

         $data = $model->field('id,pid,job')->where($where)->order(' id desc')->select();

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


    /**
     * 修改部门
     * @开发者:ChangHongYang
     */
    
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
     * 显示招聘需求列表
     * @开发者:ChangHongYang
     */
    public function recruit(){

        $model = M('H_requirements');
        
         $search = I('get.search');
         
     
         $where['position']  = array('like', "%$search%");
      
        $page =  getPage($model, $where);
       
       $data = $model ->field('id,position,priority,createtime,number,type')->where($where)->order(' createtime desc')->select();

//       var_dump($data);
   
      $this ->search =$search;
      $this ->data =$data;
      $this -> page =  $page ->show();
       $this -> display();
    }




    /**
     * 新增招聘需求
     * @开发者:ChangHongYang
     */

    public function add_need(){

        $model = M('H_section');

        $data =$model -> field('id,pid,job')->select();

//        var_dump($data);

        $this ->data =$data;

        $this -> display();

    }
    
    
    public function alert_need(){
        
          $model_1 = M('H_requirements');
          
          $model_2 = M('H_section');
          
          $where['id'] = I('get.id');
        
          $data_1 =$model_1 ->where($where)->find();
          
          $data_2 =$model_2 -> field('id,pid,job')->select();
        
//          var_dump($data_1);
        
           $this ->  data_1 =$data_1;
            $this -> data_2 =$data_2;
            $this ->display();
        
    }




    /**
     * 查看招聘信息
     * @开发者:ChangHongYang
     */
    public function look_recruit(){

        $model = M('H_requirements');

        $id = I('get.id');

        $where['id'] = $id;

        $data = $model ->where($where)->find();

//        var_dump($data);

        $this -> data =$data;

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