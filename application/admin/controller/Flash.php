<?php
namespace app\admin\controller;
use think\Controller;

class Flash extends BaseController {
    private $_db;
    public function _initialize() {
        $this->_db = model('Flash');
    }

    /**
     * 广告投放 列表
     * @return [type] [description]
     */
    public function index() {
        $games = $this->_db->getFlashInfo();
        $count = $this->_db->getFlashCount();
        return $this->fetch('',[
            'games' => $games,
            'count' => $count,
        ]);
    }

    /**
     * 添加游戏
     */
    public function add() {
        if(request()->isPost()) {
            $data = input('post.');

            // 接受文件
            $fileSize = $_FILES['swf']['size'];

            if($fileSize > 2*1024*1024) {
                $this->error('文件大小不能超过2M');
            }
            if($_FILES['swf']['type'] != 'application/x-shockwave-flash') {
                $this->error('文件格式不是SWF');
            }
            // 判断文件是否上传成功
            if(is_uploaded_file($_FILES['swf']['tmp_name'])) {
                $uploadedFile = $_FILES['swf']['tmp_name'];
                // 给每个游戏创建一个文件夹 用于存放SWF文件
                $gamePath = $_SERVER['DOCUMENT_ROOT']."/swf/".$_POST['gid'];
                if(!file_exists($gamePath)) {
                    mkdir($gamePath);
                }
                $swfPath = $gamePath . '/' . $_FILES['swf']['name'];
                if(move_uploaded_file($uploadedFile, $swfPath)) {
                    $swfSuccessPath = "/swf/".$_POST['gid'].'/'.$_FILES['swf']['name'];
                }else {
                    $swfSuccessPath = '';
                }
            }
            $data['swf'] = $swfSuccessPath;
            try {
                $res = $this->_db->save($data);
                if($res) {
                    $this->success('添加成功','index');
                }else {
                    $this->error('添加失败');
                }
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }else {
            return $this->fetch();
        }
    }

    public function edit() {
        if(request()->isPost()) {
            $data = input('post.');
            $res = $this->_db->where('id',$data['id'])->update($data);
            if($res) {
                $this->success('修改成功');
            }else {
                $this->error('修改失败');
            }
        }else {
            $id = input('param.id');
            $flash = model('Flash')->get($id);
            return $this->fetch('',[
                'flash' => $flash,
            ]);
        }
    }
}
