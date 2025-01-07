// JavaScript Document
var ws;
var chart;
var ohlc = [];
var ohlc1 = [];
var ohlcMa = [];
var ohlen;
var symbolName = 'ag10kg';
var chartType = 'kline';
var chartUnit = '1';
//var Ourproducts=new Array("AU","USDJPY","AUDUSD","GBPUSD","USDHKD","USDCAD","USDCNY","USDCHF");
var Ourproducts= new Array("CONC", "USD");//外汇
setFlag = 0;
//修改colum条的颜色（重写了源码方法）
var originalDrawPoints = Highcharts.seriesTypes.column.prototype.drawPoints;
Highcharts.seriesTypes.column.prototype.drawPoints = function () {
	var merge  = Highcharts.merge,
			series = this,
			chart  = this.chart,
			points = series.points,
			i      = points.length;

	while (i--) {
		var candlePoint = chart.series[0].points[i];
		if(candlePoint.open != undefined && candlePoint.close !=  undefined){  //如果是K线图 改变矩形条颜色，否则不变
			var color = (candlePoint.open < candlePoint.close) ? '#DD2200' : '#33AA11';
			var seriesPointAttr = merge(series.pointAttr);
			seriesPointAttr[''].fill = color;
			seriesPointAttr.hover.fill = Highcharts.Color(color).brighten(0.3).get();
			seriesPointAttr.select.fill = color;
		}else{
			var seriesPointAttr = merge(series.pointAttr);
		}

		points[i].pointAttr = seriesPointAttr;
	}

	originalDrawPoints.call(this);
}


Highcharts.setOptions({
	global:{
		useUTC:false
	},
	lang: {
		months: ['1月', '2月', '3月', '4月', '5月', '6月',  '7月', '8月', '9月', '10月', '11月', '12月'],
		weekdays: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
		shortMonths:['1月', '2月', '3月', '4月', '5月', '6月',  '7月', '8月', '9月', '10月', '11月', '12月'],
		rangeSelectorFrom:'从',
		rangeSelectorTo:'到',
		rangeSelectorZoom:'缩放',
		resetZoom:'重置单位'
	}
});

$(function(){
	setInterval(freshChart,1000);
	creatSocket();
	$("#timeunit li").click(function(){
		var DoubleClick = 0;
		if($(".trend_on").attr("data-unit")==0){
			DoubleClick = 1;
		}
		$("#timeunit li").removeClass("trend_on");
		$(this).addClass("trend_on");
		if($(this).attr('data-unit')=='0')
		{
			chartType = 'line';
			if(symbolName==undefined){
				symbolName = $("#symbolID").attr("sname");
			}
			$.ajax({
				url:'/?m=admin&c=index&a=getData',
				dataType:"json",
				data:{
					type:'3',
					symbol:symbolName
				},
				error:function(err){console.log(err);},
				success: function(data){

					ohlc1 = data;

					for(var i = 0; i < 20; i += 1){

						ohlc1.shift();

					}
					ohlc = ohlc1;

					var dataLength = data.length,
					// set the allowed units for data grouping
							groupingUnits = [[
								'minute',            // unit name
								[1]     // allowed multiples
							]];
					// create the chart
					$('#container').highcharts('StockChart', {
						chart:{
							backgroundColor:'',
							marginRight:40,
							marginLeft:0
						},
						exporting:{
							enabled:false
						},
						rangeSelector: {
							enabled:false,
							inputEnabled:false,
							allButtonsEnabled:true,
							buttonSpacing:10,
							buttons: [{
								type: 'minute',
								count: 45,
								text: '1分'
							}],
							selected:0
						},
						colors: ["#00a3f7", "#434348", "#90ed7d", "#f7a35c", "#8085e9", "#f15c80", "#e4d354", "#2b908f", "#f45b5b", "#91e8e1"],
						yAxis: [{
							opposite: true,
							labels: {
								align: 'left',
								x:2
							},
							lineWidth:1
						}],

						xAxis:[{
							dateTimeLabelFormats:{
								millisecond: '%H:%M:%S.%L',
								second: '%H:%M:%S',
								minute: '%H:%M',
								hour: '%H:%M',
								day: '%b%e日',
								week: '%b%e日',
								month: '%Y年%b',
								year: '%Y年'
							}
						}],

						series : [{
							name : 'AAPL',
							data : ohlc,
							tooltip: {
								valueDecimals: 2
							}
						}],
						plotOptions:{
							//修改蜡烛颜色
							candlestick: {
								color: '#17DBD2',
								upColor: '#FF0000',
								lineColor: '#17DBD2',
								upLineColor: '#FF0000',
								maker:{
									states:{
										hover:{
											enabled:false
										}
									}
								}
							},
							series:{
								events:{
									click:function(event){
										if(chartType!="line") {
											if (Ourproducts.indexOf(symbolName) >= 0) {

												$("#pointOpen").html(toDecimal2(event.point.open));
												$("#pointHigh").html(toDecimal2(event.point.high));
												$("#pointLow").html(toDecimal2(event.point.low));
												$("#pointClose").html(toDecimal2(event.point.close));

											} else {

												$("#pointOpen").html(event.point.open);
												$("#pointHigh").html(event.point.high);
												$("#pointLow").html(event.point.low);
												$("#pointClose").html(event.point.close);

											}
										}

									}
								}
							}
						},
						navigator:{
							enabled:false
						},
						scrollbar:[{
							enabled:false
						}],
						tooltip: {
							enabled:false,
							shadow:false,
							dateTimeLabelFormats:{
								millisecond:"%A, %b %e, %H:%M:%S.%L",
								second:"%A, %b %e, %H:%M:%S",
								minute:"%A, %b %e, %H:%M",
								hour:"%A, %b %e, %H:%M",
								day:"%Y年%b%e日 %A",
								week:"%Y年%b%e日 %A",
								month:"%B %Y",
								year:"%Y"
							}
						},
						legend:{
							activeColor:'#fff'
						},
						credits:{
							enabled:false
						}
					});

					chart = $('#container').highcharts();

				}
			});
		}
		else
		{	if(chartType=='line'){
			chartType = 'kline';
			chartUnit = $(this).attr('data-unit');
			if(DoubleClick==1){
				chartDraw();
			}
			chartDraw();
		}else{
			chartType = 'kline';
			chartUnit = $(this).attr('data-unit');
			chartDraw();
		}


		}
	});
});


function point(obj,objlen,type,num)
{
	if(chartType=='kline')
	{
		if(type == 'arr')
		{
			if(num==2){

				$("#pointOpen").html(toDecimal2(obj[objlen][1]));
				$("#pointHigh").html(toDecimal2(obj[objlen][2]));
				$("#pointLow").html(toDecimal2(obj[objlen][3]));
				$("#pointClose").html(toDecimal2(obj[objlen][4]));
			}else{
				$("#pointOpen").html(obj[objlen][1]);
				$("#pointHigh").html(obj[objlen][2]);
				$("#pointLow").html(obj[objlen][3]);
				$("#pointClose").html(obj[objlen][4]);
			}

		}
		else
		{
			if(num==2){

				$("#pointOpen").html(toDecimal2(obj[objlen].open));
				$("#pointHigh").html(toDecimal2(obj[objlen].high));
				$("#pointLow").html(toDecimal2(obj[objlen].low));
				$("#pointClose").html(toDecimal2(obj[objlen].close));
			}else{

				$("#pointOpen").html(obj[objlen].open);
				$("#pointHigh").html(obj[objlen].high);
				$("#pointLow").html(obj[objlen].low);
				$("#pointClose").html(obj[objlen].close);

			}


		}
	}
	else
	{
		if(type == 'arr')
		{
			if(num==2){
				$("#pointOpen").html(toDecimal2(obj[objlen][1]));
				$("#pointHigh").html(toDecimal2(obj[objlen][1]));
				$("#pointLow").html(toDecimal2(obj[objlen][1]));
				$("#pointClose").html(toDecimal2(obj[objlen][1]));
			}else{
				$("#pointOpen").html(obj[objlen][1]);
				$("#pointHigh").html(obj[objlen][1]);
				$("#pointLow").html(obj[objlen][1]);
				$("#pointClose").html(obj[objlen][1]);
			}

		}
		else
		{
			if(num==2){
				var priceT2 = toDecimal2(obj[objlen].y);
			}else{
				var priceT4 = obj[objlen].y;
			}

			if(num==2){
				$("#pointOpen").html(priceT2);
				$("#pointHigh").html(priceT2);
				$("#pointLow").html(priceT2);
				$("#pointClose").html(priceT2);
			}else{
				$("#pointOpen").html(priceT4);
				$("#pointHigh").html(priceT4);
				$("#pointLow").html(priceT4);
				$("#pointClose").html(priceT4);
			}
		}
	}
}
LastTimestamp = 0;
function creatSocket(){//用来建立webSocket,并监听发送过来的报价

	try {
		ws = new WebSocket("ws://114.55.181.153:5000");//连接服务器
		//	ws = new WebSocket("ws://120.55.89.5:80");//连接服务器
		//	ws = new WebSocket("ws://218.244.142.167:9010");//连接服务器
		ws.onopen = function(event){
			//alert("已经与服务器建立了连接\r\n当前连接状态："+this.readyState);
			//ws.send("type=add&ming=client");
		};
		ws.onmessage = function(event)
		{

			if(event.data.length > 0)
			{
				var arr = event.data.split("|");
				price = arr[1];
				symbol = arr[0];
				pTime = arr[2];

				if(Ourproducts.indexOf(symbol)>=0){
					//外汇
					price = toDecimal2(price);

				}

				if(symbol==symbolName)
				{
					if(ohlc[ohlen] == undefined){
						ohlc[ohlen] = {x : parseInt(new Date().getTime()/1000)*1000,y:price}
					}
					if((Date.parse(new Date())-LastTimestamp)> 1000){
						draw(chart,price,ohlc);
						LastTimestamp = Date.parse(new Date());
					}

				}
				if(price >$("."+symbol).html())
				{
					$("."+symbol).css('color','red');
				}
				else
				{
					$("."+symbol).css('color','green');
				}
				$("."+symbol).html(price);
				//	$("#priceCur").html($("."+$("#symbolID").attr("sname")).html());

				if($("#priceCur").attr("data-name") == symbol){
					//$("#priceCur").html($("."+$("#priceCur").attr("data-name")).html());
					$("#priceCur").html(price);
				}

				if(price>$("#"+symbol).children(".price").html())
				{
					$("#"+symbol).children(".price").css('background-color','#B40003');
				}
				else
				{
					$("#"+symbol).children(".price").css('background-color','#218F00');
				}



				$("#"+symbol).children(".price").html(price);
				$("#"+symbol).children(".time").html(pTime);
				//$("."+symbol+'time').html(pTime.substr(11,8));
			}
		};

	} catch (ex) {
		alert(ex.message);
	}
	ws.onerror = function(event){creatSocket();};
}


function chartDraw ()//用来获取新的K线数据，并画出新的K线
{
	if(symbolName==undefined){symbolName = $("#symbolID").attr("sname");}
	$("#loading").show();
	chartUnit = $(".trend_on").attr('data-unit');

	//获取历史数据
	$.ajax({
		url:'/?m=admin&c=index&a=getData&unit='+chartUnit+'&symbol='+symbolName,
		//url:'/view.php?unit='+chartUnit+'&symbol='+symbolName,
		dataType:"json",
		//	async:false,
		success: function(data){
			$("#loading").hide();


			ohlc1 = data;
			ohlcMa = data.concat();

			for(var i = 0; i < 20; i += 1){

				ohlc1.shift();

			}
			ohlc = ohlc1;
			ohlen = ohlc.length-1;


			if(Ourproducts.indexOf(symbolName)>=0){

				point(ohlc,ohlen,'arr',2);

			}else{

				point(ohlc,ohlen,'arr',0);

			}

			var nowPrice = $("#hiddenClass ."+symbolName).text();
			//	$("."+symbolName).html(data[data.length-1][4]);
			$("."+symbolName).html(nowPrice);
			if(setFlag==1){

				draw(chart,nowPrice,ohlc);

			}


			if(chartType=='line')
			{
				chart.series[0].setData(ohlc);
				draw(chart,nowPrice,ohlc);
				chart.redraw();
				return false;
			}
			var    volume = [],
					avg5 = [],
					avg10 = [],
					avg20 = [],
					dataLength = ohlc.length;



			// set the allowed units for data grouping
			groupingUnits = [[
				'minute',            // unit name
				[1]     // allowed multiples
			]];
			for (var i = 20; i < ohlcMa.length; i += 1) {


				//5日均线
				var temp5 = (parseFloat(ohlcMa[i][4]) + parseFloat(ohlcMa[i - 1][4]) + parseFloat(ohlcMa[i - 2][4]) + parseFloat(ohlcMa[i - 3][4]) + parseFloat(ohlcMa[i - 4][4])) / 5;
				avg5.push([ohlcMa[i][0], temp5]);
				//10日均线
				var temp10 = (parseFloat(ohlcMa[i][4]) + parseFloat(ohlcMa[i - 1][4]) + parseFloat(ohlcMa[i - 2][4]) + parseFloat(ohlcMa[i - 3][4]) + parseFloat(ohlcMa[i - 4][4]) + parseFloat(ohlcMa[i - 5][4]) + parseFloat(ohlcMa[i - 6][4]) + parseFloat(ohlcMa[i - 7][4]) + parseFloat(ohlcMa[i - 8][4]) + parseFloat(ohlcMa[i - 9][4])) / 10;
				avg10.push([ohlcMa[i][0], temp10]);
				//20日均线
				var temp20 = (parseFloat(ohlcMa[i][4]) + parseFloat(ohlcMa[i - 1][4]) + parseFloat(ohlcMa[i - 2][4]) + parseFloat(ohlcMa[i - 3][4]) + parseFloat(ohlcMa[i - 4][4]) + parseFloat(ohlcMa[i - 5][4]) + parseFloat(ohlcMa[i - 6][4]) + parseFloat(ohlcMa[i - 7][4]) + parseFloat(ohlcMa[i - 8][4]) + parseFloat(ohlcMa[i - 9][4]) + parseFloat(ohlcMa[i - 10][4]) + parseFloat(ohlcMa[i - 11][4]) + parseFloat(ohlcMa[i - 12][4]) + parseFloat(ohlcMa[i - 13][4]) + parseFloat(ohlcMa[i - 14][4]) + parseFloat(ohlcMa[i - 15][4]) + parseFloat(ohlcMa[i - 16][4]) + parseFloat(ohlcMa[i - 17][4]) + parseFloat(ohlcMa[i - 18][4]) + parseFloat(ohlcMa[i - 19][4])) / 20;
				avg20.push([ohlcMa[i][0], temp20]);

			}

			// create the chart
			$('#container').highcharts('StockChart', {
				chart:{
					backgroundColor:'',
					marginRight:40,
					marginLeft:0,
					events: {
						click: function(e) {

						}
					}
				},
				exporting:{
					enabled:false
				},
				rangeSelector: {
					enabled:false,
					inputEnabled:false,
					allButtonsEnabled:true,
					buttonSpacing:10,
					buttons: [{
						type: 'minute',
						count: 45,
						text: '1分'
					}],
					selected:0
				},

				yAxis: [{
					opposite: true,
					labels: {
						align: 'left',
						x:2
					},
					lineWidth:1
				}],

				xAxis:[{
					dateTimeLabelFormats:{
						millisecond: '%H:%M:%S.%L',
						second: '%H:%M:%S',
						minute: '%H:%M',
						hour: '%H:%M',
						day: '%b%e日',
						week: '%b%e日',
						month: '%Y年%b',
						year: '%Y年'
					}
				}],

				series: [{
					type: 'candlestick',
					name: 'AAPL',
					data:ohlc1,
					dataGrouping:{
						units: groupingUnits
					}
				},
					{
						name: 'MA5',
						data: avg5,
						type: 'spline',
						threshold: null,
						color:'#fdfdfd',
						lineWidth:1.2,
						tooltip: {
							valueDecimals: 2
						}
					},
					{
						name: 'MA10',
						data: avg10,
						type: 'spline',
						color:'#ffff00',
						lineWidth:1.2,
						threshold: null,
						tooltip: {
							valueDecimals: 2
						}
					},
					{
						name: 'MA20',
						data: avg20,
						type: 'spline',
						color:'#ff00ff',
						lineWidth:1.2,
						threshold: null,
						tooltip: {
							valueDecimals: 2
						}
					}],
				plotOptions:{
					//修改蜡烛颜色
					candlestick: {
						color: '#17DBD2',
						upColor: '#FF0000',
						lineColor: '#17DBD2',
						upLineColor: '#FF0000',
						maker:{
							states:{
								hover:{
									enabled:false
								}
							}
						}
					},
					series:{
						events:{
							click:function(event){
								$("#pointOpen").html(event.point.open);
								$("#pointHigh").html(event.point.high);
								$("#pointLow").html(event.point.low);
								$("#pointClose").html(event.point.close);
							}
						},animation: false
					}
				},
				navigator:{
					enabled:false
				},
				scrollbar:[{
					enabled:false
				}],
				tooltip: {
					enabled:false,
					shadow:false,
					formatter: function() {

						return '<b>开：</b>'+
								this.points[0]['point']['open']+'<br/>'+'<b>高：</b>'+this.points[0]['point']['high']+'<br/>'
								+'<b>低：</b>'+this.points[0]['point']['low']+'<br/>'
								+'<b>收：</b>'+this.points[0]['point']['close']+'<br/>'
								+'<b style="color:#fdfdfd">MA5：</b>'+''+toDecimal2(this.points[1]['y'])+'<br/>'
								+'<b style="color:#ffff00">MA10：</b>'+toDecimal2(this.points[2]['y'])+'<br/>'
								+'<b style="color:#ff00ff">MA20：</b>'+toDecimal2(this.points[3]['y'])+'<br/>'
					},
					dateTimeLabelFormats:{
						millisecond:"%A, %b %e, %H:%M:%S.%L",
						second:"%A, %b %e, %H:%M:%S",
						minute:"%A, %b %e, %H:%M",
						hour:"%A, %b %e, %H:%M",
						day:"%Y年%b%e日 %A",
						week:"%Y年%b%e日 %A",
						month:"%B %Y",
						year:"%Y"
					}
				},
				legend:{
					activeColor:'#fff',
				},
				credits:{
					enabled:false
				}
			});
			chart = $('#container').highcharts();


		}
	});

}

function draw(chart,price,ohlc)//此方法是用来实现即时报价的跳动效果，chart是k线对象，price是当前的价格，ohlc是整个k线数据对象
{
	chart.series[0].setData(ohlc);
	setFlag = 1;
	price = parseFloat(price);


	if(ohlc[ohlen] == undefined){
		console.log('false前draw-----'+price);
		return false;
	}

	if(ohlc[ohlen].x)
	{
		if(chartType=='kline')
		{
			ohlc[ohlen].close = price;
			if(price > ohlc[ohlen].high) ohlc[ohlen].high = price;
			if(price < ohlc[ohlen].low) ohlc[ohlen].low = price;
		}
		else
		{
			ohlc[ohlen].y = price;
		}

		if(Ourproducts.indexOf(symbolName)>=0){

			point(ohlc,ohlen,'json',2);

		}else{

			point(ohlc,ohlen,'json',0);

		}

	}
	else
	{
		if(chartType=='kline')
		{
			ohlc[ohlen][4] = price;
			if(price > ohlc[ohlen][2]) ohlc[ohlen][2] = price;
			if(price < ohlc[ohlen][3]) ohlc[ohlen][3] = price;
		}
		else
		{
			ohlc[ohlen][1] = price;
		}


		if(Ourproducts.indexOf(symbolName)>=0){

			point(ohlc,ohlen,'arr',2);

		}else{

			point(ohlc,ohlen,'arr',0);

		}

	}
	//console.log(ohlc[ohlen]);
	chart.series[0].setData(ohlc);
	chart.redraw();

	if(Ourproducts.indexOf(symbolName)>=0){
		//外汇
		price1 = toDecimal2(price);

	}else{
		//非外汇
		price1 = price;

	}
	$("text:last").text(price1);


}

function freshChart()//此方法每秒触发一次，用来检测现在的时间，如果是00秒的话，则刷新K线图数据，以实现K线图加上最新的一根柱子
{
	myDate = new Date();
	if(myDate.getSeconds()=='00')
	{
		chartDraw();
	}
}
