$(document).ready(function() {
    $(".sw_active a").click();
    abc('TJXAG'); ///////////////////////
    $('.index,.mask').css({
        minHeight: $(document).height()
    });
    //首页tab切换
    $('.info-nav li').click(function() {
        $(this).parent().find('a').removeClass('selected');
        $(this).find('a').addClass('selected');
        var index = $('.info-nav li').index(this);
        $(this).parent().nextAll('.info-d').hide();
        $('.info-d').eq(index + 1).show();
    });
    //K线切换
    $('.trend-nav li').click(function() {
        $(this).parent().find('a').removeClass('changed');
        $(this).find('a').addClass('changed');
    });
    $('.onepro div').click(function() {
        $(this).parent().find('div').removeClass('proqie');
        $(this).addClass('proqie');
    });
    $('.twopro div').click(function() {
        $(this).parent().find('div').removeClass('proqie');
        $(this).addClass('proqie');
    });
    $('.threepro div').click(function() {
        $(this).parent().find('div').removeClass('proqie');
        $(this).addClass('proqie');
    });
    $(".back").click(function() {
        window.location.reload();
    });


    /*投票操作*/
    $(".r-4").click(function() {

        $(".mask").show();

        $("#vote-f").show();
    });
    $(".vote-btn").click(function() {
        var postData = $("#vote").serialize();
        $.ajax({
            type: 'POST',
            url: '/index/vote',
            data: postData,
            beforeSend: function() {

                $(".vote-f-btn").attr("disabled", true);
                $("#pwds").show();

            },
            success: function(data) {
                $("#pwds").hide();

                if (data) {

                    if (data == 1) {

                        msg('投票成功!');
                        setTimeout('window.location.reload()', 500);

                    } else if (data == -1) {

                        msg('今天已投票!');
                        //setTimeout('window.location.reload()',500);

                    } else {
                        $(".vote-f-btn").removeAttr("disabled");
                        msg('投票失败');

                    }
                }

            }
        });
    });
    var $pwdForm = $('#pwdForm'),
        $qPwd = $('#pwdCode');
    $pwdForm.submit(function() {
        var notPass = [],
            postData = {};
        if (!$qPwd.val()) {
            msg('请输入密码！');
            $qPwd.focus();
            return false;
        }
        postData = $(this).serialize();
        var tongzhi = $("#tongzhi").val();

        $.ajax({
            type: 'POST',
            url: '/index/pwd',
            data: postData,
            dataType: 'json',
            beforeSend: function() {
                $(".pwd-btn").attr("disabled", true);
                $("#pwds").show();

            },
            success: function(data) {
                $("#pwds").hide();

                if (data.statue == 1) {
                    //$("#pwd-box").hide();
                    //$("#gonggao").show();


                    if (tongzhi == 1) {
                        window.location.href = '/index/notice';
                    } else {
                        window.location.reload();
                    }

                } else {
                    msg("密码不正确!");
                    $(".pwd-btn").removeAttr("disabled");
                }
            },
            error: function() {
                alert(errorInfo);
            }
        });
        return false;
    });

    //平仓确认
    $(".f-r-q").click(function() {

        var $sell = $("#sell");

        postData = $sell.serialize();

        $.ajax({
            type: 'POST',
            url: '/index/pcqr',
            data: postData,
            dataType: 'json',
            beforeSend: function() {

                $(".f-r").attr('disabled', true);
                $("#pwds").show();

            },
            success: function(data) {

                if (data.code == 1) {
                    $("#pwds").hide();

                    msg('平仓成功!');

                    window.location.reload();

                } else if (data == -1) {
                    $("#pwds").hide();

                    msg('网络繁忙或超时!');

                    window.location.reload();

                } else {
                    $("#pwds").hide();

                    $(".f-r").removeAttr('disabled');

                    msg('确认失败');

                }
            }
        });
    });

    //建仓数量增减
    $(function() {
        $('#jcsh  .num-right').click(function() {
            var $numValue = parseInt($(this).prev().val());
            var isJuan = $("#isJuan").val();
            if (isJuan == 1) {
                return false;
            }
            if ($numValue < 50) {
                jcqr($numValue + 1);
                $(this).prev().val($numValue + 1);
            }

        });
        $('#jcsh  .num-left').click(function() {
            var $numValue = parseInt($(this).next().val());
            var isJuan = $("#isJuan").val();
            if (isJuan == 1) {
                return false;
            }
            if ($numValue > 1) {
                jcqr($numValue - 1);
                $(this).next().val($numValue - 1);
            }
        });
    });
    //关闭广告 
    $(".ad-close").click(function() {
        $(".ad").addClass("none");
    });
    /*
     *  优惠劵的选择
     */
    $("#choose").click(function() {

        var juansl = $("#juansl").val();
        var juan = $("#isJuan").val();
        var bz = $("#bz").val();
        //手续费
        var sf = $("#sxf").val();
        //金额
        var $jine = $("#jine").val();
        if (juansl == 0) {
            msg('您还没有此体验劵!');
            return false;
        }
        //使用优惠劵
        if (juan == 0) {
            $("#isJuan").val(1);
            $("#sls").val(1);
            $(".pay").html("<span>0</span>元");
            $("#j-5").html(0);
            //体验劵
            $(".big").html(juansl - 1);
            //$("#juansl").val(juansl-1);
            $(".conform").attr("type", "submit");
            $(".failure").hide();
            $("#sl").val(1);
            $('#mychoose').css('background', '#2c8ff4');
        } else {

            $(".num-in").val(1);
            $("#isJuan").val(0);
            $("#sl").val(1);
            $(".pay").html("<span>" + bz + "</span>元");
            $("#j-5").html(sf);
            $(".j-4").html(bz);
            $('#mychoose').css('background', '#fff');
            //体验劵
            $(".big").html(juansl);
            if (parseInt(sf) + parseInt(bz) + 1 > $jine) {
                $(".conform").attr("type", "hidden");
                $(".failure").show();
            } else {
                $(".conform").attr("type", "submit");
                $(".failure").hide();
            }
        }
    });
    $('#yingjia  .num-right').click(function() {
        var juansl = $("#juansl").val();
        var $num = $("#yingjia .num-in").val();
        var juan = $("#isJuan").val();
        if (juan == 0) {
            return false;
        }
        if (juansl == 0) {
            msg('您还没有此体验劵!');
            return false;
        }
        if ((parseInt($num) + 1) > juansl) {
            return false;
        }
        if ((parseInt($num) + 1) > 10) {
            return false;
        }
        $(".num-in").val(parseInt($num) + 1);
        $("#sl").val(parseInt($num) + 1);
        $(".big").html(juansl - (parseInt($num) + 1));
        $("#sls").val(parseInt($num) + 1);
    });
    $('#yingjia  .num-left').click(function() {
        var juansl = $("#juansl").val();
        var $num = $(".num-in").val();
        var juan = $("#isJuan").val();
        if (juan == 0) {
            return false;
        }
        if (juansl == 0) {
            msg('您还没有此体验劵!');
            return false;
        }
        if ($num > 1) {
            $(".num-in").val($num - 1);
            $("#sl").val($num - 1);
            $(".big").html(juansl - ($num - 1));
            $("#sls").val($num - 1);
        }

    });

    //止盈
    $('.b-profit .t3  li').click(function() {
        $(this).parent().find('a').removeClass('selected');
        $(this).find('a').addClass('selected');
        var sz = $(this).find('a').html();

        if (sz == '不设') {
            $("#zy").val('0%');
        } else {
            $("#zy").val(sz);
        }

    });

    //止亏
    $('.b-profit .t4  li').click(function() {
        $(this).parent().find('a').removeClass('selected');
        $(this).find('a').addClass('selected');
        var sz = $(this).find('a').html();

        if (sz == '不设') {
            $("#zk").val('0%');
        } else {
            $("#zk").val(sz);
        }

    });
    //确认建仓
    $(".save").click(function() {

        var $jcsuccess = $("#jccg");

        postData = $jcsuccess.serialize();

        $.ajax({
            type: 'POST',
            url: '/index/jcqr',
            data: postData,
            dataType: 'json',
            beforeSend: function() {

                $("#pwds").show();


            },
            success: function(data) {


                if (data == 1) {
                    $("#pwds").hide();

                    msg('建仓成功!');
                    window.location.reload();

                } else {
                    $("#pwds").hide();

                    msg('确认失败');

                }
            }
        });
    });
    //建仓数字选择、充值数字选择
    $('.b-num li,.b-profit li,.b-profit-1 li,.num-list li').click(function() {
        $(this).parent().find('a').removeClass('selected');
        $(this).find('a').addClass('selected');
    });

});
$(".switch-product ul li a").on("click", function(e) {
    var this_ = $(this).parent();
    var index_ = this_.index();
    var swproduct_ = this_.parent().parent();

    var one = $(".product-box").eq(0);
    $(".product-box").each(function() {
        if ($(this).attr('value') == this_.val()) {
            var two = $(".product-box[value=" + this_.val() + "]");
            two.insertBefore(one);
            $(".product-box").removeAttr('status');
            $(this).attr('status', 'mark');
        }
    })
    this_.siblings().removeClass("sw_active");
    this_.addClass("sw_active");
    $("#product-box-all .product-box").eq(0).show().siblings().hide();
    e.preventDefault();

    if (this_.attr('value') == 1) {
        code = 'TJXAG';
    } else if (this_.attr('value') == 2) {
        code = 'TJCU';
    }else if (this_.attr('value') == 3) {
        // code = 'DLO1';
        code= 'BU0001';
    }
    abc(code);
})

function abc(code) {
      url = '/Home/Index/tu';

    $('.TimeMenu li a').click(function() {

        if ($('.TimeMenu li a.cur').attr('data-type') != $(this).attr('data-type') || $(this).attr('data-type') == 'area') {
            $('.TimeMenu li a.cur').removeClass('cur');
            $(this).addClass('cur');
            get_url(1);
        } else {

            interval = $(this).attr('data-interval');
            $('.TimeMenu li a.cur').removeClass('cur');
            $(this).addClass('cur');
            get_url(0);
            document.getElementById('chart').contentWindow.changeInterval(interval);
        }

    });

    get_url = function(is_iframe) {
        rows = 45;
        interval = $('.TimeMenu li a.cur').attr('data-interval');
        type = $('.TimeMenu li a.cur').attr('data-type');
        // type = $('.Linemenu li.cur').attr('data-type');
        if (!type) {
            type = 'candlestick';
        }
        if (code == "TJXAG") {
            var rate = $("#rate1").val();
        } else if (code == "TJCU") {
            var rate = $("#rate2").val();
        }else if (code == "BU0001") {
            var rate = $("#rate3").val();
        }

        parameter = { 'interval': interval, 'type': type, 'rows': rows, 'code': code, 'rate': rate };
        parameter_str = ""
        for (var i in parameter) {
            parameter_str += '&' + i + '=' + parameter[i];
        }
        // alert(parameter_str);
        parameter_str = parameter_str.substr(1);
        // if(is_iframe==1){
        $('.trend-chart').html('Loading...');

        $('.trend-chart').html('<iframe id="chart" class="efc" width="100%" height="220" scrolling="no" frameborder="0" src="' + url + '?' + parameter_str + '"></iframe>');
        // }

    }
    get_url(1);

};

//白银
function butt1() {
   
    var yprice = $('#oneprice').html();
    var alldata_url = "http://"+window.location.host+"/Home/Getdata/getnowdata";
    var code = "TJXAG";

    $.ajax({
        url: alldata_url,
        dataType: 'jsonp',
        data: { code: code },
        success: function(result) {
            var asd = sort_data(result);
            var intev = asd['44'];
            var intev2 = intev.toString().split(",");
            var last = intev2['1'];
            var put = parseFloat(eval(last)).toFixed(0);
            $('#oneprice').html(put);
            $('#onedqj').html(put);
            if (put > yprice) {
				$('#oneprice').attr("style",'color:red');
                $("#one").show();
                $("#two").hide();
            } else if (put == yprice) {} else {
				$('#oneprice').attr("style",'color:green');
                $("#one").hide();
                $("#two").show();
            }

        }
    });
}

//铜
function butt2() {
    var yprice = $('#twoprice').html();
    var alldata_url = "http://"+window.location.host+"/Home/Getdata/getnowdata";
    var code = "TJCU";
    $.ajax({
        url: alldata_url,
        dataType: 'jsonp',
        data: { code: code },
        success: function(result) {
            var asd = sort_data(result);
            var intev = asd['44'];
            var intev2 = intev.toString().split(",");
            var last = intev2['1'];
            var put = parseFloat(eval(last)).toFixed(0);
            $('#twoprice').html(put);
            $('#twodqj').html(put);
            if (put > yprice) {
                $('#twoprice').attr("class", "rise");
				$('#twoprice').attr("style",'color:red');
                $("#six").hide();
                $("#five").show();
            } else if (put == yprice) {} else {
                $('#twoprice').attr("class", "drop");
				$('#twoprice').attr("style",'color:green');
                $("#five").hide();
                $("#six").show();
            }

        }
    });


}

//大连油
function butt3() {
    var yprice = $('#threeprice').html();
    var alldata_url = "http://"+window.location.host+"/Home/Getdata/getnowdata";
    var code = "BU0001";
    $.ajax({
        url: alldata_url,
        dataType: 'jsonp',
        data: { code: code },
        success: function(result) {
            var asd = sort_data(result);
            var intev = asd['44'];
            var intev2 = intev.toString().split(",");
            var last = intev2['1'];
            var put = parseFloat(eval(last)).toFixed(2);
            $('#threeprice').html(put);
            $('#threedqj').html(put);
            if (put > yprice) {
                $('#threeprice').attr("class", "rise");
				$('#threeprice').attr("style",'color:red');
                $("#four").hide();
                $("#three").show();
            } else if (put == yprice) {} else {
                $('#threeprice').attr("class", "drop");
				$('#threeprice').attr("style",'color:green');
                $("#three").hide();
                $("#four").show();
            }

        }
    });


}

function sort_data(result) {




    var data = result;
    var ohlc = [],
        volume = [],
        dataLength = data.length;



    for (var i = 0; i < dataLength; i++) {
        ohlc.push([
            data[i][0], // the date
            parseFloat(data[i][1]) // close
        ]);
    }


    return ohlc;
}
//查看交易列表
$("#trade_btn").on("click", function(e) {
    $(".mask").show();
    $("#trade-list").show();
    e.preventDefault();
});
$(".close_list").on("click", function(e) {
    $("#trade-list").hide();
    $(".mask").hide();
    e.preventDefault();
});



//消息的提示
function msg(content) {

    $("#msg").show();

    $(".msg").html(content);

    setTimeout('$("#msg").fadeOut()', 2000)
}
//增加的方法
function accAdd(arg1, arg2) {
    var r1, r2, m, c;
    try {
        r1 = arg1.toString().split(".")[1].length;
    } catch (e) {
        r1 = 0;
    }
    try {
        r2 = arg2.toString().split(".")[1].length;
    } catch (e) {
        r2 = 0;
    }
    c = Math.abs(r1 - r2);
    m = Math.pow(10, Math.max(r1, r2));
    if (c > 0) {
        var cm = Math.pow(10, c);
        if (r1 > r2) {
            arg1 = Number(arg1.toString().replace(".", ""));
            arg2 = Number(arg2.toString().replace(".", "")) * cm;
        } else {
            arg1 = Number(arg1.toString().replace(".", "")) * cm;
            arg2 = Number(arg2.toString().replace(".", ""));
        }
    } else {
        arg1 = Number(arg1.toString().replace(".", ""));
        arg2 = Number(arg2.toString().replace(".", ""));
    }
    return (arg1 + arg2) / m;
}

//建仓数字选择
function jcqr(sz) {

    var bz = $("#bz").val();
    var $jine = $("#jine").val();
    var $sf = $("#sxf").val();
    var juan = $("#isJuan").val();
    var ss = $sf * sz;
    if (juan == 1) {
        return false;
    }
    $(".pay").html("<span id='opprice'>" + bz * sz + "</span>元");
    $("#j-5").html(parseFloat(ss.toFixed(2)));
    $("#sl").val(sz);
    if ($("#conform3").css("display") == "block") {
        $("#conform2").hide();
    } else {
        if (accAdd(bz * sz, $sf * sz) > $jine) {
            $(".conform").attr("type", "hidden");
            $("#conform2").show();
        } else {
            $(".conform").attr("type", "submit");
            $("#conform2").hide();
        }
    }

}
//产品更换
function cpupdate(pId, bz, $sf, juans) {

    var $jine = $("#jine").val();
    var sz = $("#sl").val();
    var ss = $sf * sz;
    $("#bz").val(bz);
    $("#sxf").val($sf);
    $("#product").val(pId);
    $(".pay").html("<span>" + bz * sz + "</span>元");
    $("#j-5").html(parseFloat(ss.toFixed(2)));
    //体验劵
    $(".c11").html(bz);
    $(".big").html(juans);
    $("#juansl").val(juans);
    if (accAdd(bz * sz, $sf * sz) > $jine) {
        $(".conform").attr("type", "hidden");
        $(".failure").show();
    } else {
        $(".conform").attr("type", "submit");
        $(".failure").hide();
    }
}

//帮助问题切换
$('.faq-list li').click(function() {
    $(this).parent().find('a').removeClass('down');
    $(this).find('a').addClass('down');
    $(this).parent().find('.faq-con').hide();
    $(this).find('a').next('.faq-con').show();
});


//榜单切换
$('.nav-list li').click(function() {
    var index = $(this).index();
    $(this).parent().find('li').removeClass('selected');
    $(this).addClass('selected');
    $('.data-box').addClass('none');
    $('.data-box').eq(index).removeClass('none');
});


//获取数据库保持的比例，取出赋值到弹出显示的窗口。
$(".toclearfix  li").click(function() {
    $(".toclearfix  li").eq($(this).index()).addClass("selected").siblings().removeClass("selected");
});
$(".myclearfix  li").click(function() {
    $(".myclearfix  li").eq($(this).index()).addClass("selected").siblings().removeClass("selected");
});
//获取最终改好的数据，并赋值到页面。然后提交方法
function baocun() {
    $('.toclearfix').each(function() {
        var zhiyin = $(this).children(".selected").val();
        $('#zy').val(zhiyin);
    });
    $('.myclearfix').each(function() {
        var zhikui = $(this).children(".selected").val();
        $('#zk').val(zhikui);
    });
}
