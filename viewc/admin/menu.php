<header id="header">
<nav class="navbar navbar-static">
              <div class="navbar-inner">
                <div class="container" style="width: auto;">
                  <a class="brand" href="#"></a>
                  <ul class="nav" role="navigation">
                    <li class="dropdown">
                      <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                        <li><a tabindex="-1" href="admin/write/post">Write</a></li>
                        <li><a tabindex="-1" href="admin/posts">管理</a></li>
                        <li><a tabindex="-1" href="admin/drafts">草稿</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="admin/trashes">回收站</a></li>
                      </ul>
                    </li>
                      <li>
                      <a id="drop2" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown" href="admin/pages" role="button">页面</a>
                       <ul class="dropdown-menu" role="menu" aria-labelledby="drop2">
                        <li><a tabindex="-1" href="admin/write/page">Write</a></li>
                      </ul>
                    </li>
                     <li>
                      <a href="admin/categories" role="button">分类</a>
                    </li>
                    
                    <li>
                      <a href="admin/tags" role="button">标签</a>
                    </li>
                   <li>
                      <a href="admin/links" role="button">链接</a>
                    </li>
                      <li id="fat-menu" class="dropdown">
                      <a href="#" id="drop2" role="button" class="dropdown-toggle" data-toggle="dropdown">评论 <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        <li><a tabindex="-1" href="admin/comments/all">所有评论</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="admin/comments/unapproved">未通过</a></li>
                      </ul>
                    </li>
                  </ul>
                  <ul class="nav pull-right">
                    <li id="fat-menu" class="dropdown">
                      <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user" style="background-color:#fff;margin-right:5px;"></i><?php echo $data['user']['username']; ?> <b class="caret"></b></a>
                      <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
                        <li><a tabindex="-1" href="admin/comments/all">档案</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="admin/logout">退出</a></li>
                      </ul>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
	
</header>