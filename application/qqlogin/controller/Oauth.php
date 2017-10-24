<?php
namespace app\qqlogin\controller;
use think\Controller;
use kuange\qqconnect\QC;

class Oauth extends Controller {

    public function qqAction() {
        $qc = new QC();
        return redirect($qc->qq_login());
    }
}
