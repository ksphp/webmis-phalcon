$(function (){
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Search */
	$('#ico-search').click(function(){
		if(!IsMobile){moWidth = 420;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:320});
		// Content
		var url = $('#getUrl').text();
		$.get($base_url+'SysMenus/sea'+url,function(data){
			$.webmis.win('load',data);
			$('#seaSub').webmis('SubClass');
		});
		return false;
	});
});