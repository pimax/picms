<?php 
Yii::app()->getClientScript()->registerCoreScript('jquery');
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
    <link rel="alternate" type="application/rss+xml" title="<?php echo Yii::app()->getSite()->name?> &raquo; Лента" href="http://<?php echo $_SERVER['HTTP_HOST']?>/wave/feed" />
    
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/style.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/style_color.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/css/style_user.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/static/js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />	
	
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/jquery.tools.min.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/prettyPhoto/js/jquery.prettyPhoto.js"></script>		
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/custom.js"></script>
	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/fdb.js"></script>
    
    <script type="text/javascript" src="http://userapi.com/js/api/openapi.js?34"></script>
	
	<!--[if IE 6]>
        <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/dd_belated_png.js"></script>
        <script>DD_belatedPNG.fix('.ie6fix');</script>
        <style>.box ul a {zoom:1;}</style>
	<![endif]-->
	
	<!--[if lt IE 9]> 
	 	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/js/html5.js"></script> 
	<![endif]-->

</head>
<body>
    <?php $this->widget('ext.fancybox.EFancyBox', array(
        'target'=>'a[rel=fancybox]',
        'config'=>array(),
        )
    );?>
	<header id="headwrap">
		<div id="head">
		
			<h2 class="logo ie6fix"><a href="/" title=""><?php echo CHtml::encode(Yii::app()->params['title']); ?></a></h2>
			
			<nav class="nav_wrapper">
				<ul class="nav">
					<li><a href="/">Главная</a></li>
					<li><a href="/about">О проекте</a></li>
					<li><a href="/wave/fashiondb">Новости</a></li>
					<li><a href="/wave">Публикации</a></li>
					<li><a href="/users">Пользователи</a></li>
					<li><a href="/advertising">Реклама</a></li>
					<?php /* <li><a href="/help">Помощь</a></li> */ ?>
					<li><a href="/contacts">Контакты</a></li>
					
				</ul><!-- end nav-->
			</nav><!-- end nav_wrapper --> 
			
			
			<nav class="catnav_wrapper">
                <?php $this->widget('application.modules.main.components.TopMenu'); ?>				
			</nav>
			
			<div id="headextras" class="rounded">
			
				<form action="/search" id="searchform" method="post">
					<div>
                        <input type="submit" id="searchsubmit" class="button ie6fix"/>
                        <input type="text" class="rounded" id="s" name="s" value=""/>
					</div>
				</form><!-- end searchform-->
				
				<ul class="social_bookmarks">
                    <li class="vkontakte"><a class="ie6fix" target="_blank" href="http://vkontakte.ru/fashiondb">Вконтакте</a></li>
					<li class="facebook"><a class="ie6fix" target="_blank" href="http://facebook.com/fashiondb">Facebook</a></li>
					<li class="twitter"><a class="ie6fix" target="_blank" href="http://twitter.com/fashiondb">Twitter</a></li>
                    <li class="rss"><a class="ie6fix" target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST']?>/wave/feed">RSS</a></li>
				</ul><!-- end social_bookmarks-->
			
			<!-- end headextras: --> 
			</div>
            
            
            <div class="user_box">
                <?php if (Yii::app()->user->isGuest):?>
                    <div style="float:right; margin-top:15px;">
                        <table cellspacing="0" cellpadding="0" style="position: relative; width: auto; cursor: pointer; border: 0px;" onmouseup="FDB.UTILS.vkButtonChange(1);" onmousedown="FDB.UTILS.vkButtonChange(2);" onmouseout="FDB.UTILS.vkButtonChange(0);" onmouseover="FDB.UTILS.vkButtonChange(1);" id="vkshare0">
                            <tr style="line-height: normal;">
                                <td style="vertical-align: middle;">
                                    <a style="text-decoration:none;" href="/user/login/vkontakte">
                                        <div style="background: url(https://vk.com/images/btns.png) 0px -42px no-repeat; cursor:pointer; width:21px; height: 21px"></div>
                                    </a>
                                </td>
                                <td id="vk-text-td" class="auth-service vkontakte" style="vertical-align: middle;">
                                    <a style="text-decoration:none;" onclick="" onmouseup="" href="/user/login/vkontakte">
                                        <div style="border: 1px solid #3b6798; cursor:pointer; border-left: 0px;">
                                            <div style="border-width: 1px 1px 1px 0px; border-style: solid solid solid none; border-right: 1px solid rgb(92, 130, 171); border-color: rgb(126, 156, 188) rgb(92, 130, 171) rgb(92, 130, 171); -moz-border-top-colors: none; -moz-border-right-colors: none; -moz-border-bottom-colors: none; -moz-border-left-colors: none; -moz-border-image: none; background-color: rgb(109, 143, 179); color: rgb(255, 255, 255); text-shadow: 0px 1px rgb(69, 104, 142); height: 15px; padding: 2px 4px 0px 6px; font-family: tahoma,arial; font-size: 10px;">Войти</div>
                                        </div>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="margin-right: 45px;float:right;margin-top:15px;">
                        <div class="auth-service facebook">
                          <a class="fb_button fb_button_medium" href="/user/login/facebook"><span class="fb_button_text" style="font-weight: normal;">Войти</span></a>
                        </div> 
                        <div id="fb-root" class=" fb_reset">
                           <div style="position: absolute; top: -10000px; height: 0pt; width: 0pt;"></div>
                        </div>            
                    </div>
                    <br class="clearboth" />
                    <div class="login-top-links">
                        <a id="login_ajax_link" href="/user/login" class="ajax_link">Войти</a>
                        <a href="/user/registration">Зарегистрироваться</a>
                    </div>
                    <div style="display:none">
                        <div id="loginbox">
                             <div class="form">
                                 <h3 class="light">Вход на сайт</h3>
                                <form class="light_form" method="post" action="/user/login">

                                    <div class="row clearboth">
                                        <label class="required" for="iUserLogin_username">Логин <span class="required">*</span></label>
                                        <input tabindex="1" type="text" id="iUserLogin_username" name="UserLogin[username]" class="text_input">
                                        <div style="width: 160px; margin-left: 20px; float: right;">
                                            <input type="hidden" name="UserLogin[rememberMe]" value="0" id="iytUserLogin_rememberMe">
                                            <input type="checkbox" value="1" id="iUserLogin_rememberMe" name="UserLogin[rememberMe]" tabindex="3" class="check_box">
                                            <label class="label-inline" for="iUserLogin_rememberMe">Запомнить меня</label>
                                        </div>
                                    </div>

                                    <div class="row clearboth">
                                        <label class="required" for="iUserLogin_password">Пароль <span class="required">*</span></label>		
                                        <input tabindex="2" type="password" id="iUserLogin_password" name="UserLogin[password]" class="text_input">	
                                        <div class="link-box"><a tabindex="5" href="/user/recovery/recovery">Забыли пароль?</a></div>
                                    </div>

                                    <div class="row clearboth submit">
                                        <input tabindex="4" type="submit" value="Войти" name="yt0" id="submit" class="button">	
                                    </div>

                                </form>
                                 <h3 class="light">Войти, как пользователь</h3>
                                 <div class="social-auth-box">
                                     <div class="social-buttons"><?php Yii::app()->eauth->renderWidget(); ?></div>
                                     <div class="social-description">
                                         Используйте свой аккаунт в социальной сети Facebook или ВКонтакте, чтобы создать профиль на Fashion DB
                                     </div>
                                     <div class="clearboth"></div>
                                 </div>
                             </div>
                        </div>
                    </div>
                <?php else:?>
                    <?php if (UserModule::user()->profile->avatar):?>
                        <a href="/user/profile"><img class="avatar avatar-60 rounded photo" src="<?php echo Pi::getThumbUrl('/'.UserModule::user()->profile->avatar, 48, true)?>" /></a>
                    <?php else:?>
                        <a href="/user/profile"><img class="avatar avatar-60 rounded photo" src="<?php echo Yii::app()->params['uploadsImagesUrl']?>/dot.png" style="height: 48px; width: 48px; border: 1px solid #222222;" /></a>
                    <?php endif;?>
                    <a href="/user/profile"><strong><?php echo UserModule::user()->username?></strong></a>
                    <a href="/user/logout">Выйти</a>
                <?php endif; ?>
            </div>                     
			
		</div><!-- end head -->
		
	</header><!-- end headwrap -->
		
		

	<div id="contentwrap">

        <?php if (Yii::app()->getPage()->id == 1):?>
            <?php $this->widget('application.modules.publications.components.FeaturedPosts'); ?>
        <?php endif;?>
			
		<div id="main">
            
                <?php echo $content; ?>
			
		</div><!-- end main -->
	
	</div><!-- end contentwrap --> 
	
			
	<!-- Footer -->
	<footer id="footerwrap">
		<div id="footer">
            <section class="column column1">
                <?php if (Yii::app()->user->isGuest):?>
                    <h3>&nbsp;</h3>
                    <ul>
                        <li><a title="" href="/user/login">Войти</a></li>
                        <li><a title="" href="/user/registration">Зарегистрироваться</a></li>
                    </ul>
                <?php else:?>
                    <h3><a href="/users/<?php echo UserModule::user()->username?>"><?php echo UserModule::user()->username?></a></h3>
                    <ul>
                        <li><a title="" href="/user/profile">Мой профиль</a></li>
                        <li><a title="" href="/user/profile/edit">Настройки</a></li>
                        <li><a title="" href="/user/logout">Выход</a></li>
                    </ul>
                <?php endif;?>
            </section>

            <nav class="column column2">
                <?php $this->widget('application.modules.main.components.BottomMenu'); ?>
            </nav>

            <nav class="column column3">
                <h3><a href="/about">О проекте</a></h3>
                <ul>
                    <li><a title="" href="/wave/fashiondb">Новости</a></li>
                    <li><a title="" href="/advertising">Реклама</a></li>
                    <?php /* <li><a title="" href="/terms-of-use">Правила сайта</a></li> 
                    <li><a title="" href="/help">Помощь</a></li> */ ?>
                    <li><a title="" href="/contacts">Контакты</a></li>
                    <li><a title="" href="/map">Карта сайта</a></li>
                </ul>
            </nav>

            <div class="footer_text">
                <p>Copyright &copy; 2009–<?php echo date('Y'); ?> Fashion DB</p>
                <p>Использование материалов сайта разрешено только при наличии активной ссылки на источник.</p>
                <p>Все права на картинки и тексты принадлежат их авторам.</p>
                <p>
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t26.10;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+";"+Math.random()+
"' alt='' title='LiveInternet: показано число посетителей за"+
" сегодня' "+
"border='0' width='88' height='15'><\/a>")
//--></script><!--/LiveInternet-->

                </p>
            </div>
            <div class="footer_logo">
                <div class="pi-logo">
                    <a target="_blank" href="http://pimaxmedia.ru">
                        <img src="<?php echo Yii::app()->request->baseUrl; ?>/static/images/skin1/pi_logo.png" alt="pimax media" title="pimax media" />
                    </a>
                </div>
                <div class="footer-p">
                    <p><a target="_blank" href="http://pimaxmedia.ru">проект компании</a></p>
                    <p><a target="_blank" href="http://pimaxmedia.ru">pimaxmedia</a></p>
                </div>
                <br class="clearboth" />
            </div>
            <br class="clearboth" />

		</div><!-- end footer --> 
	</footer><!-- end footerwrap --> 
	
    <!-- Reformal -->
    <script type="text/javascript">
        reformal_wdg_domain    = "fashiondb";
        reformal_wdg_mode    = 0;
        reformal_wdg_title   = "Fashion DB";
        reformal_wdg_ltitle  = "Оставьте свой отзыв";
        reformal_wdg_lfont   = "";
        reformal_wdg_lsize   = "";
        reformal_wdg_color   = "#7E9CBC";
        reformal_wdg_bcolor  = "#516683";
        reformal_wdg_tcolor  = "#FFFFFF";
        reformal_wdg_align   = "left";
        reformal_wdg_charset = "utf-8";
        reformal_wdg_waction = 0;
        reformal_wdg_vcolor  = "#9FCE54";
        reformal_wdg_cmline  = "#E0E0E0";
        reformal_wdg_glcolor  = "#105895";
        reformal_wdg_tbcolor  = "#FFFFFF";

        reformal_wdg_bimage = "7688f5685f7701e97daa5497d3d9c745.png";

    </script>

    <script type="text/javascript" language="JavaScript" src="http://reformal.ru/tab6.js?charset=utf-8"></script><noscript><a href="http://fashiondb.reformal.ru">Fashion DB feedback </a> <a href="http://reformal.ru"><img src="http://reformal.ru/i/logo.gif" /></a></noscript>
    <!-- end of: Reformal -->
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">{lang: 'ru'}</script>
    
    <?php echo Yii::app()->getSite()->counters?>
</body>
</html>