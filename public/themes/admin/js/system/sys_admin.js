$(function (){
/* Index */
	$('#listBG').webmis('TableOddColor');
/* Search */
	$('#ico-search').click(function(){
		if(!IsMobile){moWidth = 520; moHeight= 400;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
		// Content
		var url = $('#getUrl').text();
		$.get($base_url+'SysAdmin/sea'+url,function(data){
			$.webmis.win('load',data);
			$('#seaSub').webmis('SubClass');
		});
		return false;
	});
/* Add */
	$('#ico-add').click(function(){
		if(!IsMobile){moWidth = 620; moHeight= 520;}
		$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
		// Content
		$.get($base_url+'SysAdmin/add',function(data){
			$.webmis.win('load',data);
			menusForm();
		});
		return false;
	});
/* Edit */
	$('#ico-edit').click(function(){
		var id = $('#listBG').webmis('GetInputID');
		if(id){
			if(!IsMobile){moWidth = 620; moHeight= 460;}
			$.webmis.win('open',{title:$(this).text(),width:moWidth,height:moHeight,overflow:true});
			// Content
			$.post($base_url+'SysAdmin/edit',{'id':id},function(data){
				$.webmis.win('load',data);
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
			$.post($base_url+'SysAdmin/del',{'id':id},function(data){
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
	// Email
	$.validator.addMethod("email", function(value, element){
		var email =  /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		return this.optional(element) || email.test(value);
	}, "<em></em>请输入正确邮箱");
}

/* Edit Perm */
function editPerm(id,title){
	var perm = $('#editPerm'+id).attr('title');
	if(!IsMobile){moWidth = 820; moHeight= 540;}
	$.webmis.win('open',{title:title,width:moWidth,height:moHeight,overflow:true});
	// Content
	$.post($base_url+'SysAdmin/perm',{'perm':perm},function(data){
		$.webmis.win('load',data);
		$('#editPerm').webmis('SubClass');
		//提交
		$('#editPerm').click(function(){
			var permval = getPerm();
			permData(id,permval)
		});
	});
	// Sub Perm
	var permData = function (id,perm){
		$.post($base_url+'SysAdmin/Data/perm',{'id':id,'perm':perm},function(data){
			if(data.status=='y'){
				var url = $('#getUrl').text();
				$.webmis.win('close',data.url+url);
			}else{
				$.webmis.win('close');
				$.webmis.win('open',{title:data.title,content:'<b class="red">'+data.msg+'</b>',AutoClose:3,AutoCloseText:data.text});
			}
		},'json');
	}
	// Get Perm
	var getPerm = function (){
		var perm = '';
		// One
		$('#oneMenuPerm input:checked').each(function(){
			perm += $(this).val()+':0 ';
		});
		// Two
		$('#twoMenuPerm input:checked').each(function(){
			perm += $(this).val()+':0 ';
		});
		// Three
		$('#threeMenuPerm input[name=threeMenuPerm]:checked').each(function(){
			var id = $(this).val();
			var act = getAction(id);
			perm += id+':'+act+' ';
		});
		if(perm){perm = perm.substr(0, perm.length-1);}
		return perm;
	}
	// Get Perm Menu
	var getAction = function (id){
		var perm=0;
		$('#actionPerm_'+id+' input:checked').each(function(){
			perm += parseInt($(this).val());
		});
		return perm;
	}
}