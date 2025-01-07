$(function(){
	if(code=="JHCL"){
        $('.t_right li').eq(2).remove();
    }
	$('.t_right p,.t_right li').css('line-height',$('.t_right').height()+'px');
	$('.money_choose .top p').css('line-height',$('.money_choose .top p').height()+'px');
	//下拉select
	$('.t_right p').on('click',function(){
		if($('.t_right ul').css('display')=='none'){
			$('.t_right ul').slideDown(200);
		}else{
			$('.t_right ul').slideUp(200);
		}
	})
	//选择选项
	$('.t_right li').on('click',function(){
		$('.t_right ul').slideUp(100);
		$('.t_right p span').html($(this).html());
		$('.t_right p span').attr('value',$(this).attr('value'));
	})
	var w_num=parseInt(window.location.href.split('id/')[1]);
	$('.t_right li').eq(w_num).click();
	//左边时间切换
	$('.content .left ul li,.money_choose .bottom ul li').on('click',function(){
		$(this).addClass('active').siblings('li').removeClass('active');
	})
	//看涨看跌切换
	$('.footer div').on('click',function(){
		$(this).attr('stats','on').siblings('div').attr('stats','off');
		// 切换背景
		change_bg();
	})
})