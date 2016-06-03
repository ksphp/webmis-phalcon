$(function(){
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Search */
	$('#ico-search').click(function(){
		if(!IsMobile){moWidth = 420;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:320});
		// Content
		var url = $('#getUrl').text();
		$.get($base_url+'ClassWeb/sea'+url,function(data){
			$.webmis.win('load',data);
			$('#seaSub').webmis('SubClass');
		});
		return false;
	});
/* Add */
	$('#ico-add').click(function(){
		if(!IsMobile){moWidth = 640; moHeight= 500;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
		// Content
		$.get($base_url+'ClassWeb/add',function(data){
			$.webmis.win('load',data);
			newsClass();
			classForm();
			
		});
		return false;
	});
/* Edit */
	$('#ico-edit').click(function(){
		var id = $('#listBG').webmis('GetInputID');
		if(id){
			if(!IsMobile){moWidth = 640; moHeight= 500;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
			// Content
			$.post($base_url+'ClassWeb/edit',{'id':id},function(data){
				$.webmis.win('load',data);
				newsClass();
				classForm();
			});
		}else{noSelect();}
		return false;
	});
/* Del */
	$('#ico-del').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'ClassWeb/del',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				classForm();
			});
		}else{noSelect();}
		return false;
	});
/* Audit */
	$('#ico-audit').click(function(){
		var id = $('#listBG').webmis('GetInputID',{type:'json'});
		if(id){
			$.webmis.win('open',{title:$(this).text(),width:280,height:160});
			$.post($base_url+'ClassWeb/audit',{'id':id},function(data){
				$.webmis.win('load',data);
				$('#Sub').webmis('SubClass');
				$('#DelID').val(id);
				classForm();
			});
		}else{noSelect();}
		return false;
	});
});

/* Form validation */
function classForm(){
	$('#Sub').webmis('SubClass');
	formValidSub();
}

/* Menus */
function newsClass(){
	$('#newsClass').webmis('AutoSelect',{
		url:$base_url+'ClassWeb/getMenu',
		num:2,
		data:'0',
		type:'post',
		getVal:'#menus_fid'
	});
}