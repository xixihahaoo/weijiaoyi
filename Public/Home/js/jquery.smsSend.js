/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var Account;
var Time;
var iTime;
function code_res()
{
    if (document.getElementById('mobile').value != null)
    {
        var regex = new RegExp('^[0-9]{11}$');
        var regex_res = regex.test(document.getElementById('mobile').value);
        if (regex_res == false)
        {
            // alert('手机号格式不符');
            var d = dialog({
                title: '提示',
                content: '手机号格式不符',
                okValue: '确定',
                ok: function () {}
            });
            d.showModal();
            document.getElementById("code_click").src = "App/Common/Common/vcode.php? height=40 & width=100";
        } else
        {
            $.post('index.php?m=admin&c=index&a=smsRecv', {mobile: document.getElementById('mobile').value, code: document.getElementById('vcode').value}, function (msg) {

                if (msg == '1') {
                    myDate = new Date();
                    Time = myDate.getTime();
                    Account = setInterval('RemainTime()', 1000);
                    //alert('验证码发送成功');
                    var d = dialog({
                        title: '提示',
                        content: '验证码发送成功',
                        okValue: '确定',
                        ok: function () {}
                    });
                    d.showModal();
                } else
                {
                    //alert(msg);
                    var d = dialog({
                        title: '提示',
                        content: (msg),
                        okValue: '确定',
                        ok: function () {}
                    });
                    d.showModal();
                    document.getElementById("code_click").src = "App/Common/Common/vcode.php? height=40 & width=100";
                }
            });
        }
    }
}

function RemainTime() {
    myDate = new Date();
    iTime = parseInt((myDate.getTime() - Time) / 1000);
    iTime = 119 - iTime;
    document.getElementById('zphone').disabled = true;
    var iSecond, sSecond = "", sTime = "";
    if (iTime >= 0) {
        iSecond = parseInt(iTime % 60);
        iMinute = parseInt(iTime / 60)
        if (iSecond >= 0) {
            if (iMinute > 0) {
                sSecond = iMinute + "分" + iSecond + "秒";
            } else {
                sSecond = iSecond + "秒";
            }
        }
        sTime = sSecond;
        if (iTime == 0) {
            clearInterval(Account);
            document.getElementById("code_click").src = "App/Common/Common/vcode.php? height=40 & width=100";
            sTime = '获取验证码';
            document.getElementById('zphone').disabled = false;
        } else {
            iTime = iTime - 1;
        }
    } else {
        clearInterval(Account);
        sTime = '获取验证码';
        document.getElementById('zphone').disabled = false;
    }
    document.getElementById('zphone').value = sTime;
}