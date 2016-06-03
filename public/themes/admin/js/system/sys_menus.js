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
/* Edit */
	$('#ico-edit').click(function(){
		var id = $('#listBG').webmis('GetInputID');
		if(id){
			if(!IsMobile){moWidth = 720; moHeight= 540;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
			// Content
			$.post($base_url+'SysMenus/edit',{'id':id},function(data){
				$.webmis.win('load',data);
				menusClass();
				menusForm();
			});
		}else{noSelect();}
		return false;
	});
/* Del */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'SysMenus/del',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				menusForm();
			});
		}else{noSelect();}
		return false;
	});
});

/* Form validation */
function menusForm(){
	$('#Sub').webmis('SubClass');
	formValidSub();
	// Get Perm
	$('#PermVal .Checkbox').click(function() {
		var perm=0;
		$('#PermVal .Checkbox:checked').each(function(){
			perm += parseInt($(this).val());
		});
		$('#menus_perm').val(perm);
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