<?php
namespace Home\Controller;
use Think\Controller;
use Org\Util\Log;


class TestController extends Controller
{

    public function test(Log $log){

        $log->t();
    }

}