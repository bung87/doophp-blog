(function($) {

	  $.fn.extend({
	  	xForm:function(options){
	  		var form=$(this);
	  		var defaults={
	  			target:form.attr('action'),
	  			/*params:{insert:'add',update:'update','delete':'remove'},
	  			tplid:'preload',
	  			selecter:{add:'.icon-plus-sign',del:'.icon-remove',edit:'.icon-edit'}*/

	  		};
	  		
	  		form.find('[data-name]').each(function(){

					$(this).data('val',$(this).html());
					}
				  );//each
	  		var opts = $.extend(defaults, options);
	  		var action=opts.selecter;
	  		var params=opts.params;
	  		var tpl=$('#'+opts.tplid);
	  		var linetag=tpl[0].tagName.toLowerCase();
	  		var fildtag=tpl.children()[0].tagName.toLowerCase();
	  		form.delegate(action.add,'click',function(){
  				var ht=tpl.html();
  				var h=$('<'+linetag+'>'+ht+'</'+linetag+'>');
				tpl.after(h);
				h.delegate('button','click',function(){
				  
				    var k=[],v=[],data={};
				    h.find('input').each(function(i,e){
					    var s=$(this).attr('name'),val=$(this).val();
					    data[s]=val;
				    });
				    data['ac']=params.insert;
				    $.post(opts.target,data,function(r){
				 	if(r.length>6){
				 		h.replaceWith(r);
				 		
				    
					}else{
						alert('名称及网址不能为空');
					}

				    },'html');
				     return false;
			  	});//delegate button

				});//delegate add
				form.delegate(action.del,'click',function(){
				  
				  var p=$(this).parent().parent();
				  var i=p.attr('data-id');
				  var d={ac:params.delete,id:i};
					$.post(opts.target,d,function(r){
					  form.find('[data-id="'+i+'"]').remove();
					} );
				});//delegate
				
				form.delegate('[data-name]','mouseenter',function (){
				  $(this).css({position:'relative'}); 
				    var ht='<a href="javascript:;" class="icon-edit" style="position:absolute;right:5px;margin: 2px;"></a>';
				    $(this).append(ht);
				});
				form.delegate('[data-name]','mouseleave',function (){
				  $(this).css({position:'relative'});
				  $(this).find('.icon-edit').remove();
				});
				form.delegate(action.edit,'click',function (){
				    var td=$(this).parent();
				    var name=td.attr("data-name"),v=td.attr('data-value'),id=td.parent().attr("data-id");
				    var e=$('<input class="span2" type="text" name="'+name+'" value="'+v+'" /><button data-type="submit" class="btn">确定</button><button data-type="cancel" class="btn">取消</button>');
				    td.html(e);
				});
				form.find('[data-name]').delegate('button','click',function (){
				     var t=$(this).attr('data-type'),p=$(this).parent();
				     var v=p.attr('data-value'),n=p.attr('data-name'),i=p.parent().attr('data-id'),dt=p.parent().find('[data-name="link_updated"]'),u=p.find('input[name="'+n+'"]').val();
				     if(t=='submit'){
				      var f=this.form,a=f.action,d=eval('({ac:"update",id:"'+i+'",'+n+':"'+u+'"})');//d={ac:params.update,id:i,n:u};//
				      $.post(a,d,function(r){
				        var s=r.success ? 'alert-success' :'alert-error';
				        var x=r.success ? '' :'<button type="button" class="close" data-dismiss="alert">×</button>';
				        var ht=$('<div class="alert '+s+'">'+x+'<strong>'+r.title+'</strong>'+r.info+'</div>');
				       
				        if(r.success){
				          var dv=p.data('val');
				          dv.replace(v,u);
				          p.data('val',dv);
				          p.html(dv);dt.html(r.datetime);$(f).before(ht);
				          ht.fadeOut('normal');
				        }
				        else{
				          $(f).before(ht);
				        }    
				      },'json');
				      return false;
				      
				     }else{
				      p.html(p.data('val'));
				      return false;
				      
				     }
				});//delegate
	  	}//xForm


	  });//extend
})(window.jQuery);