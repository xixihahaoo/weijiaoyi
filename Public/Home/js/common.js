function jiance(){
	$.ajax({
		type:'post',
		url:"/Admin/bao/jianceip",   
		success:function(data){
			if(data == 2){
				alert('该用户在其他地方登录！');
				WeixinJSBridge.call('closeWindow');
			}
		}
	});
}
setInterval('jiance()', 5000);