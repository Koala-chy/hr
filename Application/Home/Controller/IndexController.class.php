<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {


    protected $trueTableName = 'resumes'; //定义真实表名，人才库表


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



    //部门及岗位
    /*
     * 人才库视图列表数据
     * @开发者:tianYongquan

     */
    public function Talents() {
        $Data = M($this->trueTableName);
        if (!$Data) {
            echo $Data->getDbError();
        }

        // 获取当前页码，默认第一页，设置每页默认显示条数
        $nowpage = I('get.page', 1, 'intval');
        $keyword = I('get.keyword', '');
        $map['name|telphone'] = array('LIKE', "%$keyword%");
	//$map['telphone'] = array('LIKE', "%$keyword%");
        $limits = 15;
        // 获取总条数
        $count = $Data->where($map)->count();
        //$Page = new \Think\Page($count,3); //实例化分页类，传入条数为默认3条
        // 计算总页面
        $allpage = ceil($count / $limits);
        $allpage = intval($allpage);
        $lists = $Data
            ->alias('a')
            ->join(C('DB_PREFIX')."section as b ON a.reals=b.id",'left')
            ->page($nowpage, $limits)  // page 方法分页
            ->where($map)
            ->order('addsubtime desc')
            ->field('a.*,b.job as bumen')
            ->select();
	 // echo $Data->getLastSql($lists);//打印SQL语句
	
	
        //dump($lists);
        // 跳转分页输出
        $this->assign('lists', $lists);
        $this->assign('allpage', $allpage);
        $this->assign('nowpage', $nowpage);
        $this->assign('keyword', $keyword);
        $this->display('');
    }



    //部门及岗位
    /*
     * 新增箭头数据视图
     * @开发者:tianYongquan

     */
    public function edit_resume($id) {

        if (!empty($id)) {
            $Form = M($this->trueTableName);
            $model = M('section');
            $data = $model->field('id,pid,job')->where('pid =0 ')->select();
            $this->data = $data;
            $vo = $Form->getById($id);
            if ($vo) {
                $this->info = $vo;
                $this->display();
            } else {
                $this->error('数据不存在！');
            }
        } else {
            $this->error('数据不存在！');
        }
    }

    public function view_resume($id) {
        if (!empty($id)) {
            $Form = M($this->trueTableName);
            $id = I('get.id');
            $vo = $Form ->alias('a')
                ->join(C('DB_PREFIX')."section as b ON a.reals=b.id",'left')
                ->field('a.*,b.job as bumen')
                ->where('a.id='.$id)
                ->find();
            if ($vo) {
                $this->info = $vo;
                $this->display();
            } else {
                $this->error('数据不存在！');
            }
        } else {
            $this->error('数据不存在！');
        }
    }


    // 更新数据
    public function update() {
        $upload = new \Think\Upload(C('UPLOADFILE'));
        $info = $upload->uploadOne($_FILES['file']);
        if (!empty($info['size'])) {
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功 获取上传文件信息
                //  echo $info['savepath'].$info['savename'];
                $upname = $info['savename'];
                $uppath = $info['savepath'];
            }
        }

        $Upform = D($this->trueTableName);
        if ($Upform->create()) {
            $id = I('post.id');
            $Upform->filename = $upname;
            $Upform->filpath = $uppath;
            $Upform->addsubtime = date('Y-m-d H:i:s',time());
            $list = $Upform->where('id=' . $id)->save();
            if ($list !== false) {
                $this->success('数据更新成功！', U('Index/talents'));
            } else {
                $this->error("没有更新任何数据!");
            }
        } else {
            $this->error($Upform->getError());
        }
    }



    //部门及岗位
    /*
     * 更新简历状态信息
     * @开发者:tianYongquan

     */

   public function upjobstatus() {
	$upload = new \Think\Upload(C('UPLOADFILE'));
        $info = $upload->uploadOne($_FILES['file']);
        $Upform = D($this->trueTableName);
        $id = I('post.id');	
        $_map['id'] = I('post.id');
	if (I('post.upname') && I('post.uppath') != '' && empty($info['size'])) { 
	     $upname = I('post.upname');
	     $uppath  = I('post.uppath');
	     $_postdata = array(
	       'jobstatus'=> I('post.jobstatus'),
	       'filename' => $upname,
	       'filpath'  => $uppath);	     
	}elseif(I('post.upname') && I('post.uppath') != '' && !empty($info['size'])){
	        $upname = $info['savename'];
		$uppath = $info['savepath'];
	      $_postdata = array(
	       'jobstatus'=> I('post.jobstatus'),
	       'filename' => $upname,
	       'filpath'  => $uppath);
	       
	} elseif(!empty($info['size']) && I('post.upname')=='' ){
	     	 if (!$info) {// 上传错误提示错误信息
		    $this->error($upload->getError());
	        } else {
                  // 上传成功 获取上传文件信息
		    $upname = $info['savename'];
		    $uppath = $info['savepath'];
		    $_postdata = array(
		   'jobstatus'=> I('post.jobstatus'),
		   'filename' => $upname,
		   'filpath'  => $uppath);
		}} else {  
	      $_postdata = array('jobstatus'=>I('post.jobstatus'));
	
	}
        $list = $Upform->where($_map)->setField($_postdata);
       // echo $Upform->getLastSql($list).'ddddd'.$info['size'];//打印SQL语句
	//exit;
	
       if ($list !== false) {
            $this->success('简历状态更新成功！', U('Index/talents'));
        } else {
            $this->error("没有更新任何数据!");
        }
    }


    //部门及岗位
    /*
     * 新增简历数据
     * @开发者:tianYongquan

     */
    public function insert() {
        $upload = new \Think\Upload(C('UPLOADFILE'));
        $info = $upload->uploadOne($_FILES['file']);
	 if (!empty($info['size'])) {
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功 获取上传文件信息
                //  echo $info['savepath'].$info['savename'];
                $upname = $info['savename'];
                $uppath = $info['savepath'];
            }
        }
	
	
        $_date = date('Y-m-d H:i:s',time());
        $Form = D($this->trueTableName);
        if ($Form->create()) {

            $Form->filename = $upname;
            $Form->filpath = $uppath;
            $Form->addsubtime = $_date;
            $list = $Form->add();
            if ($list !== false) {
                $this->success('数据保存成功！', U('Index/talents'));
            } else {
                $this->error('数据写入错误！');
            }
        } else {
            $this->error($Form->getError());
        }
    }

    //部门及岗位管理
    /*
      简历删除
     * @开发者:tianYongquan
     *
     */

    public function del_resume($id) {
        //echo $id;
        //exit;
        if (!empty($id)) {
            $Form = M($this->trueTableName);
            $result = $Form->delete($id);
            if (false !== $result) {
                $this->success('删除成功！');
            } else {
                $this->error('删除出错！');
            }
        } else {
            $this->error('ID错误！');
        }
    }


    //部门及岗位
    /*
     * 人才库视图列表数据
     * @开发者:tianYongquan

     */
     public function interview() {
        $Data = M($this->trueTableName);
        if (!$Data) {
            echo $Data->getDbError();
        }
        // 获取当前页码，默认第一页，设置每页默认显示条数
        $nowpage = I('get.page', 1, 'intval');
        $keyword = I('get.keyword', '');
        $map['name'] = array('LIKE', "%$keyword%");
	$map['jobstatus']   = array('in','1,2,3');
        //$map['jobstatus']=1;
        $limits = 10;
        // 获取总条数
        $count = $Data->where($map)->count();
        //$Page = new \Think\Page($count,3); //实例化分页类，传入条数为默认3条
        // 计算总页面
        $allpage = ceil($count / $limits);
        $allpage = intval($allpage);
        $lists = $Data
            ->alias('a')
            ->join(C('DB_PREFIX')."section as b ON a.reals=b.id",'left')
            ->page($nowpage, $limits)  // page 方法分页
            ->where($map)
            ->field('a.*,b.job as bumen')
            ->order('addsubtime desc')
            ->select();


        // 跳转分页输出
        $this->assign('lists', $lists);
        $this->assign('allpage', $allpage);
        $this->assign('nowpage', $nowpage);
        $this->assign('keyword', $keyword);
        $this->display('');
    }


    //部门及岗位管理
     /**
      * 调取部门及岗位管理视图页面数据
      * @author 常 弘扬 <changhongyang@123.com.cn>
      */
     public function section_manage(){

         $model = M('section');

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
        
         $model = M('section');
        
        $data = $model->field('id,pid,job')->where('pid =0 ')->select();
        
         $this ->data =$data;
      
         $this -> display();
        
    }


    /**
     * 修改部门
     * @开发者:ChangHongYang
     */
    
    public function edit_section(){
        
        $model = M('section');
        
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

        $model = M('requirements');
        
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

        $model = M('section');

        $data =$model -> field('id,pid,job')->select();

//        var_dump($data);

        $this ->data =$data;

        $this -> display();

    }
    
    
    public function alert_need(){
        
          $model_1 = M('requirements');
          
          $model_2 = M('section');
          
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

        $model = M('requirements');

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
        
          $model = M('section');
        
          $arr['pid'] = $id;
          
          $data =array();
          
          $data = $model->field('id,pid,job')->where($arr)->select();
         
         $this ->ajaxReturn($data,'JSON');
          
          
    }
    
    
            
            
       

   



}