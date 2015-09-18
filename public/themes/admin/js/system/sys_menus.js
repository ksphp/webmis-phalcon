$(function (){
	$.webmis.inc({files:[$webmis_plugin+'form/Validform.min.js']});
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
/* Add */
	$('#ico-add').click(function(){
		if(!IsMobile){moWidth = 720; moHeight= 540;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
		// Content
		$.get($base_url+'SysMenus/add',function(data){
			$.webmis.win('load',data);
			menusClass();
			menusForm();
		});
		return false;
	});
});

/* Form validation */
function menusForm(){
	$('#Sub').webmis('SubClass');
	//  Validation
	$("#Form").Validform({ajaxPost:false,tiptype:2,
		beforeCheck:function(data){
			var perm=0;
			$('input[name=permVal]:checked').each(function(){
				perm += parseInt($(this).val());
			});
			$('#menus_perm').val(perm);
		},
		callback:function(data){
			$.Hidemsg();
			if(data.status=="y"){
				var url = $('#getUrl').text();
				$.webmis.win('close','SysMenus.html'+url);
			}else{
				$.webmis.win('close');
				$.webmis.win('open',{title:data.title,content:'<b class="red">'+data.msg+'</b>',AutoClose:3,AutoCloseText:data.text});
			}
		}
	});
}

/* Menus */
function menusClass(){
	$('#menusClass').webmis('AutoSelect',{
		url:$base_url+'SysMenus/getMenu',
		num:2,
		data:'0',
		type:'post',
		getVal:'#menus_fid'
	});
}