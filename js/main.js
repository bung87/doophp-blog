/*function getCurrentStyle(node) {
    var style = null;
    
    if(window.getComputedStyle) {
        style = window.getComputedStyle(node, null);
    }else{
        style = node.currentStyle;
    }
    
    return style;
}*/
function bindScale(){
	
	$('.btn_scale').toggle(
			function(){$("#cover").fadeIn('normal')},
			function(){$("#cover").fadeOut('normal')}).click(function(){
		
		$('article').toggleClass("descale",$('article').hasClass('scale'));
		
		$('article').toggleClass("scale");
			
	});
}
function bindReplyClick(){
	var dl,cover;
$("#comments").delegate(".reply","click",function(event){

	var html=['<form id="replyform" action="http://fan16.net/comment" method="post">',
'<div class="c">',
'<textarea name="comment" cols="56" rows="2" tabindex="-1" class="l br"></textarea>',
'<input type="submit" class="btn mls" name="replysubmit" value="回复" />',
'</div></form>'].join('');
  dl=$(this).closest('dl');
  dl.after(html);
  if(!$.cookie('userinfo')){
		var ta,w,h,l,t;
		ta=dl.next().find('textarea');
		w=ta[0].clientWidth;
		h=ta[0].clientHeight;
		l=ta.offset().left;
		t=ta.offset().top;
		cover=$('<div class="cover br">尚未完善个人信息您可以使用<a href="javascript:;" id="snslogin">社会化登陆</a>或者<a href="javascript:;">完善个人信息</a></div>');
		cover.css({width:w,height:h,left:l,top:t});
		ta.after(cover);
		cover.find('#snslogin').click(function(){
			$(".dl_handle_2").click();
		});
		cover.fadeTo("fast", 0);cover.fadeTo("fast", 1);
	}
});

$('#comments').delegate('form','submit',function(){
	if(!$.cookie('userinfo')){
		cover.fadeTo("fast", 0);cover.fadeTo("fast", 1);
		return false;
	}
	var pid,par,text;
	pid=$('input[name=comment_post_ID]').val();
	par=dl.attr('data-commentid');
	text=$('#replyform textarea').val();
	$.ajax({
		type:'POST',
		url:$('#replyform').attr('action'),
		data:{formhidden:0,comment_post_ID:pid,comment_parent:par,comment:text},
		success:function (data){
			//console.log(data);
		}
	});
	return false;
});
}
function logout(){
	$('#commentbox').delegate('#logout','click',function (){
		$.cookie('userinfo',null);
		window.location.reload();
	});
	
}
function bindCommentPost(){
	var f=$('#commentform'),s,a=f.attr('action'),h;
	$('#commentform').submit(function(){
	s=f.serialize();
	$.ajax({
   type: "POST",
   url: a,
   data: s,
   success: function(data){
   	h=$(data);
     $('#comments').append(h);
   }
});
return false;
});

}
$(function(){
	(function($, window, undefined) {

  // Add pretty print to all pre and code tags.
  $('pre, code').addClass("prettyprint");

  // Remove prettify from code tags inside pre tags.
  $('pre code').removeClass("prettyprint");

  // Activate pretty presentation.
  prettyPrint();
})(jQuery, this);
$('#language select').bind('change',function(){
$.cookie('lang',$(this).val());
window.location.reload();
});
	if(!$.cookie('userinfo',null)){}
	bindScale();
	bindReplyClick();
	bindCommentPost();
	    if(!$('#tagCloud').tagcanvas({
          textColour: '#66d9ef',
          outlineColour: '#0095c3',
          outlineThickness:1,
          reverse: true,
          depth: 0.8,
          maxSpeed: 0.05
        },'tags')) {
          // something went wrong, hide the canvas container
          $('#tagCloudcontainer').hide();
        }
	if(typeof chrome=='object'){
	firstNotification=new Notifier('http://fan16.net/favicon.ico', "您已接受来自番石榴的通知！","有新消息时将会通知您。");
	$('#applynotifier').click(function(){firstNotification.init();});
}
	var c=$('#commentbox'),st=$('#sidebar').offset().top,sl=$('#sidebar').offset().left;
	
	if(c[0]){
	
	var w=window.screen.availHeight,
		d=document.body.clientHeight,
		diff=w-d;
	if(d<=w){
		c.show();
		$('input[name=formhidden]').val('0');
	}else{
			
		$(window).scroll(function(){
			var s=document.body.scrollTop;
			if(s>=diff+20){
		c.fadeIn('slow');
		$('input[name=formhidden]').val('0');
	}});
	}
	}

$(window).scroll(function(){
			var s=document.body.scrollTop;
			if(s>=st){$('#sidebar').css({position:'fixed',top:0,left:sl});}else{$('#sidebar').attr('style','')}
		});

});