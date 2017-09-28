<?php
namespace app\admin\controller;
use think\Controller;

class Pay extends Controller {

    public function index() {
        $pay = model('Payfs')->getPayfsInfo();
        return $this->fetch('',[
            'pay' => $pay,
        ]);
    }

    /**
     * 添加支付渠道
     */
    public function addPay() {
        return $this->fetch();
    }

    /**
     * 添加支付方式
     */
    public function addPayway() {
        return $this->fetch();
    }

    /**
     * 修改支付方式
     * @param  integer $id [description]
     * @return [type]      [description]
     */
    public function edit($id=0) {
        if(request()->isPost()) {
            $data = input('post.');

            try {
                $res = model('Payfs')->allowField(true)->update($data);
                if($res) {
                    return show(1,'修改成功');
                }else {
                    return show(0,'修改失败');
                }
            } catch (\Exception $e) {
                return show(0,$e->getMessage());
            }
        }else {
            $gameType = model('PayType')->getPayTypeInfo();
            $payWay = model('Payfs')->get($id);
            return $this->fetch('',[
                'gameType' => $gameType,
                'payWay' => $payWay,
            ]);
        }
    }
}
