anchorlen = $('#contentleft').getElementsByTagName('a').length;
anchors = $('#contentleft').getElementsByTagName('a');
for (i=0;i<=anchorlen;i++) {
var Main_anchor=anchors[i];
var anchortitle=Main_anchor.getAttribute('title') ;
var anchortar=Main_anchor.getAttribute('target') ;
	if(anchortitle!= "" ){
			var span=document.createElement("span");
			anchortar=='_blank' ? windowlocal='[新窗口]' : windowlocal='';
			span.innerHTML='链接至：'+anchortitle+windowlocal;
			
			Main_anchor.appendChild(span);
			Main_anchor.setAttribute('title','');
	}
}