<!DOCTYPE html>
<html lang="zh-CN">
<!--
<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>LitePress &#8250; ReadMe</title>
	<link rel="stylesheet" href="wp-admin/css/install.css?ver=20100228" type="text/css" />
</head>
-->
<body>
<h1 id="logo">
	<a href="https://litepress.cn/"><img alt="LitePress" src="https://litepress.cn/wp-admin/images/wordpress-logo.png" /></a>
</h1>
<p style="text-align: center">LitePress内容管理系统</p>

<h2>首先请看：</h2>
<p>LitePress是一个非常特别的项目。每个开发人员和贡献者都为之添加了一些独特的东西，我们一起投入了数千个小时来创造她。谢谢你让她成为你世界的一部分。</p>
<p style="text-align: right">&#8212; LitePress团队</p>

<h2>安装：</h2>
<ol>
	<li>在空目录中解压安装包。</li>
	<li>浏览器打开 <span class="file"><a href="wp-admin/install.php">wp-admin/install.php</a></span>，她将会引导你创建数据库连接信息到<code>wp-config.php</code> 
		<ol>
			<li>如果这期间出了什么意外，不用担心，先用文本编辑器打开<code>wp-config-sample.php</code>并手动填好数据库连接信息。</li>
			<li>把文件保存/重命名为<code>wp-config.php</code>。</li>
			<li>浏览器重新打开<span class="file"><a href="wp-admin/install.php">wp-admin/install.php</a></span>。</li>
		</ol>
	</li>
	<li>当这个配置文件创建好了以后，她会自动建立数据表，如果失败了，请检查<code>wp-config.php</code>并再次尝试。如果还是失败，请访问<a href="https://litepress.cn/">LitePress支持论坛</a>寻求帮助。</li>
	<li><strong>如果你没有输入密码，请牢记她给你的默认密码。</strong>如果你没有输入用户名，默认会是<code>admin</code>。</li>
	<li>安装完成后她会带你来到<a href="wp-login.php">登录页面</a>，使用安装时输入的用户名和密码进行登录。</li>
</ol>

<h2>更新：</h2>
<h3>自动更新</h3>
<ol>
	<li>浏览器打开<span class="file"><a href="wp-admin/update-core.php">wp-admin/update-core.php</a></span>并阅读有关说明</li>
</ol>

<h3>手动更新</h3>
<ol>
	<li>在更新前，请先备份好全站数据。</li>
	<li>删除全部LitePress旧版文件，保留你做过修改的部分</li>
	<li>上传LitePress新版文件</li>
	<li>浏览器打开<span class="file"><a href="wp-admin/upgrade.php">/wp-admin/upgrade.php</a>。</span></li>
</ol>

<h2>从其他系统迁移</h2>
<p>LitePress可以<a href="https://wordpress.org/support/article/importing-content/">从很多系统导入</a>。在使用<a href="wp-admin/import.php">导入工具</a>之前，你要先安装好LitePress。</p>

<h2>系统要求</h2>
<ul>
	<li><a href="https://secure.php.net/">PHP</a> 版本 <strong>5.6.20</strong> 或者更高。</li>
	<li><a href="https://www.mysql.com/">MySQL</a> 版本 <strong>5.0</strong> 或者更高。</li>
</ul>

<h3>建议</h3>
<ul>
	<li><a href="https://secure.php.net/">PHP</a> 版本 <strong>7.4</strong> 或者更高。</li>
	<li><a href="https://www.mysql.com/">MySQL</a> 版本 <strong>5.6</strong> 或者更高。</li>
	<li>Apache <a href="https://httpd.apache.org/docs/2.2/mod/mod_rewrite.html">mod_rewrite</a> 模块。</li>
	<li><a href="https://wordpress.org/news/2016/12/moving-toward-ssl/">HTTPS</a> 支持。</li>
	<li>添加一个<a href="https://litepress.cn/">litepress.cn</a>的链接到你的网站。</li>
</ul>

<h2>在线资源</h2>
<p>如果您有本文档中未解决的任何问题，请利用LitePress&#8217;的在线资源:</p>
<dl>
	<dt><a href="https://litepress.cn/">LitePress支持论坛</a></dt>
		<dd>如果您到处寻找但仍然找不到答案，那么请转向支持论坛，我们有一个庞大的社区随时准备提供帮助。为了您能尽快获取帮助，请使用简洁的标题并尽可能详细地描述您的问题。</dd>
	</dl>

<h2>最后提醒</h2>
<ul>
	<li>如果您有任何建议、想法或意见，又或者您发现了一个bug，请在<a href="https://litepress.cn/">支持论坛</a>发帖。</li>
	<li>LitePress拥有强大的插件<abbr>API</abbr>（应用程序编程接口），可以轻松扩展代码。如果您是对此感兴趣的开发人员，请参阅<a href="https://developer.wordpress.org/plugins/">插件开发人员手册</a>，而不应该修改任何核心代码。</li>
</ul>

<h2>分享她</h2>
<p>如果你喜欢LitePress，将其分享给你的朋友们吧！</p>

<h2>License</h2>
<p>LitePress 是免费软件，根据 <abbr>GPL</abbr>（GNU 通用公共许可证）第 2 版或任何更高版本的条款发布。 见<a href="license.txt">license.txt</a>。</p>

</body>
</html>
