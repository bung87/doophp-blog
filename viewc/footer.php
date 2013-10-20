</div><!--end #content-->
<footer id="footer">
<div class="br w c">
	<nav class="c">
	<ul class="l">
	<li class="l"><a href="./profile" rel="author">关于我</a></li>
	<?php foreach($data['pages'] as $k1=>$v1): ?>
	<li class="l"><a href="./p/<?php echo $v1->post_name; ?>"><?php echo $v1->post_title; ?></a></li>
	<?php endforeach; ?>

	</ul>
</nav>
<p class="c"><br /><a class="l" rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh"><img alt="知识共享许可协议" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png" /></a>&nbsp;采用<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/deed.zh">知识共享署名-非商业性使用-相同方式共享 3.0 Unported许可协议</a>进行许可。</p>
<p>© 2012 fan16.net <?php echo $data['powerby']; ?> 采用html5及CSS3标准，建议使用Chrome浏览。</p>
<!--<?php echo $data['queries']; ?> queries executed Generated in <?php echo $data['benchmark']; ?> seconds-->
</div>
</footer><!--end #footerbar-->
</canvas><!--end #wrap-->
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;mini=1&amp;uid=332903" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
</script>

<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fdb198bdf5bbc21c8ddf2eabef0a60866' type='text/javascript'%3E%3C/script%3E"));
</script>

</body>

<!--script src="<?php echo $data['rootUrl']; ?>js/syntaxhighlighter_3.0.83/shAutoloaderSet.js" type="text/javascript"></script-->
</html>

