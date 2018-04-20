<?php
namespace app\index\controller;
use app\index\model\Brand;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        return $this->fetch();
    }
    function show(){
        $data=Db::name('brand')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }
    function add(){
        return $this->fetch();
    }
    function addSave(){
        $data=$_POST;
        $data['createT']=time();
        $file = request()->file('logo');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            $data['logo']= $info->getSaveName();
        }else{// 上传失败获取错误信息16.
            $this->error($file->getError());
        }
        $re=Db::name('brand')->insert($data);
        if($re){
            $this->success('添加成功','show');
        }else{
            $this->error('添加失败');
        }
    }
    function edit(){
        $id=input('id');
//        $data=Db::name('brand')->select($id);
        $model=new Brand();
        $data=$model->find($id);
//        dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch();
    }
    function editSave(){
        $data=$_POST;
        $data['updateT']=time();
        $file = request()->file('logo');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            $data['logo']= $info->getSaveName();
        }else{// 上传失败获取错误信息16.
            $this->error($file->getError());
        }
        $re=Db::name('brand')->update($data);
        if($re){
            $this->success('修改成功','show');
        }else{
            $this->error('修改失败');
        }
    }
    function delete(){
        $id=input('id');
        $re=Db::name('Brand')->delete($id);
        if($re){
            $this->success('删除成功','show');
        }else{
            $this->error('删除失败');
        }
    }
}
