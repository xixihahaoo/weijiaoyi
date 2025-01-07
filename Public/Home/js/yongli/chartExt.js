//highstock K线图
var highStockChart = function(divID,result,crrentData){
	var $reporting = $("#report");
	//开盘价^最高价^最低价^收盘价^成交量^成交额^涨跌幅^换手率^五日均线^十日均线^20日均线^30日均线^昨日收盘价 ^当前点离左边的相对距离
	var  open,high,low,close,y,zde,zdf,hsl,MA5,MA10,MA20,MA30,zs,relativeWidth; 
	//定义数组
	var ohlcArray = [],volumeArray = [],MA5Array = [],MA10Array=[],MA20Array=[],MA30Array=[],zdfArray=[],zdeArray=[],hslArray=[],data=[],dailyData = [],data =[];	
	/*
	 * 这个方法用来控制K线上的flags的显示情况，当afterSetExtremes时触发该方法,通过flags显示当前时间区间最高价和最低价
	 * minTime  当前k线图上最小的时间点
	 * maxTime  当前k线图上最大的时间点
	 * chart  当前的highstock对象
	 */
	var showTips = 	function (minTime,maxTime,chart){

		//chart.showLoading();
		//定义当前时间区间中最低价的最小值，最高价的最大值 以及对应的时间
		var lowestPrice,highestPrice,array=[],highestArray=[],lowestArray=[],highestTime,lowestTime,flagsMaxData_1=[],flagsMaxData_2=[],flagsMinData_1,flagsMinData_2; 

		for(var i=0;i<ohlcArray.length-1;i++){
			if(ohlcArray[i][0]>=minTime && ohlcArray[i][0]<=maxTime){
				array.push([
				            ohlcArray[i][0],
				            ohlcArray[i][2], //最高价
				            ohlcArray[i][3] //最低价
				            ])
			}
		}
		if(!array.length>0){
			return;
		}
		highestArray = array.sort(function(x, y){  return y[1] - x[1];})[0];// 根据最高价降序排列
		highestTime =highestArray[0];
		highestPrice =highestArray[1].toFixed(2);
		lowestArray = array.sort(function(x, y){  return x[2] - y[2];})[0]; //根据最低价升序排列
		lowestTime =lowestArray[0];
		lowestPrice =lowestArray[2].toFixed(2); 
		var formatDate1 = Highcharts.dateFormat('%Y-%m-%d',highestTime)
		var formatDate2 = Highcharts.dateFormat('%Y-%m-%d',lowestTime)
		flagsMaxData_1 = [
		               			{
		               			 x : highestTime,
		               			title : highestPrice+"("+formatDate1+")"
		               			}
		               		];
		
		flagsMaxData_2 = [
					               {
					                x : highestTime,
					                title : highestPrice
					               }
		               ];
		flagsMinData_1 = [
		                  {
		                	  x : lowestTime,
		                	  title : lowestPrice+"("+formatDate2+")"
		                  }
		                  ];
		
		flagsMinData_2 = [
		               {
		            	   x : lowestTime,
		            	   title : lowestPrice
		               }
		               ];
		var min =  parseFloat(flagsMinData_2[0].title) - parseFloat(flagsMinData_2[0].title)*0.05;
		var max =  parseFloat(flagsMaxData_2[0].title)+parseFloat(flagsMaxData_2[0].title)*0.05;
		var tickInterval = (( max-min)/5).toFixed(1)*1;
		var oneMonth = 1000*3600*24*30;
		var oneYear = 1000*3600*24*365;
		var tickIntervalTime,dataFormat='%Y-%m';
		if(maxTime-minTime>oneYear*2){
			tickIntervalTime = oneYear*2
			dataFormat = '%Y';
		}else if(maxTime-minTime>oneYear){
			tickIntervalTime = oneMonth*6
		}else if(maxTime-minTime>oneMonth*6){
			tickIntervalTime = oneMonth*3
		}else{
			tickIntervalTime = oneMonth
			dataFormat = '%m-%d'
		}
			
		//Y轴坐标自适应
		 chart.yAxis[0].update({
	    	   	min : min,
	    	   	max : max,
	    	   	tickInterval: tickInterval
	       });

//chart.yAxis[0].removePlotLine('aa'); //把id为plot-line-1的标示线删除

		//X轴坐标自适应
		 chart.xAxis[0].update({
			 min : minTime,
			 max : maxTime,
			 tickInterval: tickIntervalTime,
			 labels: {
				   	y:-50,//调节y偏移
	             formatter: function(e) {
	             		 return Highcharts.dateFormat(dataFormat, this.value);
	             }
	         }
		 });
	 //动态update flags(最高价)
       chart.series[5].update({
    	   //data : flagsMaxData_2,
            point:{
         	   events:{
         		  click:function(){
	         			 chart.series[5].update({
	         					data : flagsMaxData_1,
	         					width : 100
	         			 });
	         			 chart.series[6].update({
	         					data : flagsMinData_1,
	         					width : 100
	         			 });
                    }
                }
         },
         events:{
             mouseOut:function(){
		             	 chart.series[5].update({
		   					data :flagsMaxData_2,
		   					width : 25
		             	 });
		             	 chart.series[6].update({
			   					data :flagsMinData_2,
			   					width : 25
			   			 });
             	}
         	},
		});
       
       //动态update flags(最低价)
       chart.series[6].update({
    		//data : flagsMinData_2,
    		   point:{
             	   events:{
             		  click:function(){
             			 chart.series[6].update({
	         					data : flagsMinData_1,
	         					width : 100
	         			 });
    	         			 chart.series[5].update({
    	         					data : flagsMaxData_1,
    	         					width : 100
    	         			 });
                        }
                    }
             },
             events:{
                 mouseOut:function(){
		                	 chart.series[6].update({
				   					data :flagsMinData_2,
				   					width : 25
				   			 });
    		             	 chart.series[5].update({
    		   					data :flagsMaxData_2,
    		   					width : 25
    		             	 });
                 	}
             	}
		});
   	chart.hideLoading();
	}
	
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
		            var color = (candlePoint.open < candlePoint.close) ? '#F85654' : '#4DD9DB';
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

	//常量本地化
	Highcharts.setOptions({
		global : {
			useUTC : false
		},

		chart: {
                marginLeft: 0,
                marginRight: 0,
                backgroundColor: 'rgba(0,0,0,0)'  //设置背景颜色
        },
	});
	//格式化数据，准备绘图
	dailyData = result.vl.split("~");
	//dailyData = result;
	for(i=0;i<dailyData.length-1;i++){
	  data[i] = dailyData[i].split("^");
	 // data[i] = dailyData[i];
	}

	//把当前最新K线数据加载进来
	var length = data.length-1;
	var time = parseFloat(data[length][0]);
	var crrentTime = crrentData[0];
		
	for (i = 0; i < data.length; i++) {
		ohlcArray.push([
			parseInt(data[i][0]), // the date
			parseFloat(data[i][1]), // open
			parseFloat(data[i][3]), // high
			parseFloat(data[i][4]), // low
			parseFloat(data[i][2]) // close
		]);

		MA5Array.push([
	         parseInt(data[i][0]), // the date
	         parseFloat(data[i][11])
         ]);

		MA10Array.push([
	    	parseInt(data[i][0]),
	    	parseFloat(data[i][12]),
	     ]);
		MA20Array.push([
            parseInt(data[i][0]),
            parseFloat(data[i][13]),             
		                ])
		MA30Array.push([
	             	parseInt(data[i][0]),
	                parseFloat(data[i][14])
	        ]);
		  volumeArray.push([
				parseInt(data[i][0]), // the date
				parseInt(data[i][5]) // 成交量
			]);
	}

	//开始绘图
	return new Highcharts.StockChart( {
		chart:{
			renderTo : divID,
		//	margin: [30, 30,30, 30],
			plotBorderColor: '#3C94C4',
			plotBorderWidth: 0, //边框粗细
			events:{
				load:function(){
					var length = ohlcArray.length-1;
					showTips(ohlcArray[0][0],ohlcArray[length][0],this);
				}
			},
			    panning: false, //禁用放大
                pinchType: '', //禁用手势操作
		},
		loading: {
	    	labelStyle: {
                position: 'relative',
	            top: '10em',
	            zindex:1000
	    	}
	    },
		 credits:{
	            enabled:false
	        },
	    rangeSelector: {
			enabled:false,
	        inputDateFormat: '%Y-%m-%d'  //设置右上角的日期格式
	    },
	    plotOptions: {
	    	//修改蜡烛颜色
	    	candlestick: {
	    		color: 'rgba(0,0,0,0)',
	    		upColor: 'rgba(0,0,0,0)',
	    		lineColor: '#4DD9DB',	    		
	    		upLineColor: '#F85654', 
	    		maker:{
	    			states:{
	    				hover:{
	    					enabled:false,
	    				}
	    			}
	    		}
	    	},
	    	//去掉曲线和蜡烛上的hover事件
            series: {
            	states: {
                    hover: {
                        enabled: false
                    }
                },
            line: {
                marker: {
                    enabled: false
                }
            }
            }
	    },
	    //格式化悬浮框
	    tooltip: {
	       enabled: false,  //是否显示
		   formatter: function() {
			   if(this.y == undefined){
				   return;
			   }
			   for(var i =0;i<data.length;i++){
				   if(this.x == data[i][0]){
					   zdf = parseFloat(data[i][7]).toFixed(2);
					   zde = parseFloat(data[i][8]).toFixed(2);
				//	   hsl = parseFloat(data[i][9]).toFixed(2);
					   zs = parseFloat(data[i][10]).toFixed(2);
				   }
			   }
			   open = this.points[0].point.open.toFixed(2);
			   high = this.points[0].point.high.toFixed(2);
			   low = this.points[0].point.low.toFixed(2);
			   close = this.points[0].point.close.toFixed(2);
			   y = (this.points[1].point.y*0.0001).toFixed(2);
			   MA5 =this.points[2].y.toFixed(2);
			   MA10 =this.points[3].y.toFixed(2);
			   MA30 =this.points[4].y.toFixed(2);
			   relativeWidth = this.points[0].point.shapeArgs.x;
			   var stockName = this.points[0].series.name;
		      var tip= '<b>'+ Highcharts.dateFormat('%Y-%m-%d  %A', this.x) +'</b><br/>';
		      // tip +=stockName+"<br/>";
		      if(open>zs){
    			  tip += '开盘价：<span style="color: #DD2200;">'+open+' </span><br/>';
    		  }else{
    			  tip += '开盘价：<span style="color: #33AA11;">'+open+' </span><br/>';
    		  } 
    		  if(high>zs){
    			  tip += '最高价：<span style="color: #DD2200;">'+high+' </span><br/>';
    		  }else{
    			  tip += '最高价：<span style="color: #33AA11;">'+high+' </span><br/>';
    		  } 
    		  if(low>zs){
    			  tip += '最低价：<span style="color: #DD2200;">'+low+' </span><br/>';
    		  }else{
    			  tip += '最低价：<span style="color: #33AA11;">'+low+' </span><br/>';
    		  }
    		  if(close>zs){
    			  tip += '收盘价：<span style="color: #DD2200;">'+close+' </span><br/>';
    		  }else{
    			  tip += '收盘价：<span style="color: #33AA11;">'+close+' </span><br/>';
    		  }
    		  if(zde>0){
    			  tip += '涨跌额：<span style="color: #DD2200;">'+zde+' </span><br/>';
    		  }else{
    			  tip += '涨跌额：<span style="color: #33AA11;">'+zde+' </span><br/>';
    		  }
    		  if(zdf>0){
    			  tip += '涨跌幅：<span style="color: #DD2200;">'+zdf+' </span><br/>';
    		  }else{
    			  tip += '涨跌幅：<span style="color: #33AA11;">'+zdf+' </span><br/>';
    		  }
    		  if(y>10000){
    			  tip += "成交量："+(y*0.0001).toFixed(2)+"(亿股)<br/>";
    		  }else{
    			  tip += "成交量："+y+"(万股)<br/>";
    		  }
    		 /* tip += "换手率："+hsl+"<br/>";*/
    		  $reporting.html(
    				  '  <span style="font-weight:bold">'+stockName+'</span>'
    				+ '  <span>开盘:</span>'+ open
    				+'  <span>收盘:</span>'+close
              		+'  <span>最高:</span>'+ high
              		+'  <span>最低:</span>'+ low
              		+'  <span style="padding-left:25px;"> </span>'+	Highcharts.dateFormat('%Y-%m-%d',this.x)
              		+'	<br/><b style="color:#1aadce;padding-left:25px">MA5</b> '+ MA5
              		+'  <b style="color: #8bbc21;padding-left:150px">MA10 </b> '+ MA10
              		+'  <b style="color:#910000;padding-left:150px">MA30</b> '+ MA30
              		);
    		  return tip;
		   },
		 //crosshairs:	[true, true],//双线
		   crosshairs: {
   				dashStyle: 'dash',

		   },
   			borderColor:	'white',
	    	positioner: function () { //设置tips显示的相对位置
	    		var halfWidth = this.chart.chartWidth/2;//chart宽度
	    		var width = this.chart.chartWidth-155;
	    		var height = this.chart.chartHeight/5-8;//chart高度
	    		if(relativeWidth<halfWidth){
	    			return { x: width, y:height };
	    		}else{
	    			return { x: 30, y: height };
	    		}
	    	},
	    	shadow: false
		},


	    title: {
	        enabled:false
	    },
	    exporting: { 
            enabled: false  //设置导出按钮不可用
        }, 
		scrollbar: {
			barBackgroundColor: 'gray',
			barBorderRadius: 7,
			barBorderWidth: 0,
			buttonBackgroundColor: 'gray',
			buttonBorderWidth: 0,
			buttonArrowColor: 'yellow',
			buttonBorderRadius: 7,
			rifleColor: 'yellow',
			trackBackgroundColor: 'white',
			trackBorderWidth: 1,
			trackBorderColor: 'silver',
			trackBorderRadius: 7,
			enabled: false,   //是否显示 滚动条
			liveRedraw: false //设置scrollbar在移动过程中，chart不会重绘
		},
		 navigator: {
		     enabled:false,  //滚动条
			 adaptToUpdatedData: false,
			 xAxis: {
				 labels: {
		             formatter: function(e) {
		             		 return Highcharts.dateFormat('%m-%d', this.value);
		             }
		         } 
			 },
			 handles: {
		    		backgroundColor: '#808080',
		    	//	borderColor: '#268FC9'
		    	},
		     margin:-10
		 },
	    xAxis: {
        	type: 'datetime',
        	 tickLength: 0,//X轴下标长度
        	 lineWidth:0,//X轴边缘线条粗细
        	// minRange: 3600 * 1000*24*30, // one month
        	 events: {
        		 afterSetExtremes: function(e) {
 	    			var minTime = Highcharts.dateFormat("%Y-%m-%d", e.min);
 	    			var maxTime = Highcharts.dateFormat("%Y-%m-%d", e.max);
 	    			var chart = this.chart;
 	    			showTips(e.min,e.max,chart);
 	    		}
        	 }
    	},
	    yAxis: [{
	        title: {
	           enable:false
	        },

		    plotLines:[{
		        color:'red',           //线的颜色，定义为红色
		        dashStyle:'longdashdot',     //默认值，这里定义为实线
		        value:6.5,               //定义在那个值上显示标示线，这里是在x轴上刻度为3的值处垂直化一条线
		        width:0.5,                //标示线的宽度，2px
		        id:'plot-line',
		        label:{
			        text:'6.5',     //标签的内容
			        align:'right',                //标签的水平位置，水平居左,默认是水平居中center
			        x:-10,                         //标签相对于被定位的位置水平偏移的像素，重新定位，水平居左10px
			        y: -15,
			        style: {
                           color: 'white',
                           backgroundColor: 'blue'
                        }
			    }
		    }],

	        height: '70%',
	        lineWidth:0,//Y轴边缘线条粗细
            gridLineColor: '#346691',
            gridLineWidth:0,
            opposite:true
	    },{
	        title: {
	           enable:false
	        },
	        top: '55%',
	        height: '30%',
	        labels:{
	        	//x:-15
	        },
	        gridLineColor: '#346691',
            gridLineWidth:0,
	        lineWidth: 0,
	    }],
	    series: [
	    {
	    	type: 'candlestick',
	    	id:"candlestick",
	        name: result.cname,
	        data: ohlcArray,
	        dataGrouping: {
				enabled: false
			},

	    }
	    ,{
	        type: 'column',//2
	        name: '成交量',
	        data: volumeArray,
	        yAxis: 1,
	        dataGrouping: {
				enabled: false
			}
	    } ,{
	        type: 'spline',
	        name: 'MA5',
	        color:'#1aadce',
	        data: MA5Array,
	        lineWidth:1,
	        dataGrouping: {
				enabled: false
			}
	    },{
	        type: 'spline',
	        name: 'MA10',
	        data: MA10Array,
	        color:'#8bbc21',
	        threshold: null, 
	        lineWidth:1,
	        dataGrouping: {
				enabled: false
			}
	    },{
	        type: 'spline',
	        name: 'MA30',
	        data: MA30Array,
	        color:'#910000',
	        threshold: null, 
	        lineWidth:1,
	        dataGrouping: {
				enabled: false
			}
	    },{
	    	 type : 'flags',
	           cursor:'pointer',
	           style:{
	        	   fontSize: '11px',
	               fontWeight: 'normal',
	               textAlign: 'center'
	           },
	           lineWidth:0.5,
	           onSeries : 'candlestick',
	           width : 25,
	           shape: 'squarepin'
	    },{
	    	 type : 'flags',
	         cursor:'pointer',
	         y: 33,
	         style:{
	        	   fontSize: '11px',
	               fontWeight: 'normal',
	               textAlign: 'center'
	           },
	           lineWidth:0.5,
	           onSeries : 'candlestick',
	           width : 25,
	           shape: 'squarepin'
	    }
	    ]
	});
}

