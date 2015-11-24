$(function(){
	$.webmis.inc({files:[$webmis_plugin+'chart/Chart.min.js']});
	$.post($base_url+'Desktop/chart',function(data){
		// 创建图表
		var ctx = $("#myChart").get(0).getContext("2d");
		var myNewChart = new Chart(ctx).Line(data);
	},'json');
});
