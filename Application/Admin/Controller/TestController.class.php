<?php

namespace Admin\Controller;
use Think\Controller;
class TestController extends CommonController
{
	

	public function test()
	{
		//echo 111;
        echo date('Y-m-d H:i:s',1490793603);
	}


    public function get_oids()
    {
        $rs = M()->query('SELECT COUNT(*) AS cott, oid, tempdate FROM wp_journal GROUP BY oid HAVING cott>2');

        //vD($rs);

        $oidArr = array();
        foreach($rs as $k => $v)
        {
            array_push($oidArr, $v['oid']);
        }

        $oidStr = implode(',', $oidArr);

        

        vD($oidStr);
    }
}