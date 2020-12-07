<?php
require 'db.php';
//Получаем основную информацию кто щас авторизовался
$photo = $_SESSION['user']->photo;
$name = $_SESSION['user']->first_name;
$last = $_SESSION['user']->last_name;
$idvk = $_SESSION['user']->user_id;
$coin = $_SESSION['user']->coin;

//Получаем информацию из базы данных
//Получаем уровень прав админа
$admlevel = R::findOne('admin', 'user_id = ?', array($idvk));

//Сравниваем user_id для того что бы убедиться что пользователь зашел не случайно
$useradmin = R::findOne('admin', 'user_id = ?', array($idvk));
if($useradmin->user_id != $idvk){
            header('Location: /vk.php');
}

//UPDATE/Переход на главную страницу



//Выполняем функцию если нажали на кнопку
//Получаем профили image+url
//Кнопка "VK Аккануты"
if(isset($_POST['acc-profile'])){
    acc_profile();
}


//Форма для добавления нового админа 
//Кнопка "Добавить админа"
if(isset($_POST['new-adm'])){
    echo '
    <form action="/admin.php" method="POST">
    <labe>USER ID VK<label>
    <input type="number" name="user-id">
    <button name="adm-new">Добавить</button>
    </form>';
}
if(isset($_POST['group_join'])){
    $group_id = $_POST['group_id'];
    joins($group_id);
    
}



//Добавляем нового админа, а так же получаем информацию из VK и проверяем на правильность!
//Кнопка "Добавить" 
if(isset($_POST['adm-new'])){
    $user_id = $_POST['user-id'];
    $request_params = array(

        'user_id' => $_POST['user-id'], 
        'fields' => 'photo_max', 
        'v' => '5.103', 
        'access_token' => '8ecbc5968fafe54e807a0992c73070da2d633174282225e4372c4e076bcfc63a3ac71ae06a23df6cd1f3d' 

    );
    $get_user = http_build_query($request_params); 
    $result = json_decode(file_get_contents('https://api.vk.com/method/users.get?'. $get_user));
    $useadmin = R::findOne('admin', 'user_id = ?', array($user_id));
        if($useadmin->user_id == $user_id){
            echo 'Такой админ уже существует!</br>';
        }
        if($useadmin->user_id != $user_id){
        
        if($result -> response[0] -> first_name == ''){
            echo 'Ошибка возможно такого пользователя не существует!';
        }else{
            echo '<a href="https://vk.com/id'.$user_id.'"><img src="'.$result -> response[0] -> photo_max.'"></a></br>';
            echo $result -> response[0] -> first_name.'</br>';
            echo $result -> response[0] -> last_name.'</br>';
            echo "Добавлен новый админ!</br>";
    
            $admin = R::dispense('admin');
            $admin->level = 0;
            $admin->online = true;
            $admin->user_id = $user_id;
            $admin->first = $result -> response[0] -> first_name;
            $admin->last = $result -> response[0] -> last_name;
            $admin->photo = $result -> response[0] -> photo_max;
            R::store($admin);
            }
        }
}


//Кнопка "Выход"
if(isset($_POST['quit'])){
    quit();
}
//Если пользователь авторизован отображаем весь HTML 
if(isset($_SESSION['user'])):
?>

<!DOCTYPE html5>
<!-- 
Основной вид страницы и его построения
!-->
      <html>
      <head>
              <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no" />
        <meta name="format-detection" content="telephone=no" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="MobileOptimized" content="176" />
        <meta name="HandheldFriendly" content="True" />
        <base id="base">
        
        <meta name="description" content="DEANONE – Поиск информации" />
        <link rel="shortcut icon" href="https://vk.com/photo532832858_457244078"></link>
            <meta name="theme-color" content="#ffffff" />
    <link rel="icon" type="image/png" sizes="32x32" href="https://vk.com/photo532832858_457244078">
    <link rel="apple-touch-icon" href="https://vk.com/photo532832858_457244078">
    <link rel="mask-icon" href="https://vk.com/photo532832858_457244078" color="#5181b8">
    <meta name="msapplication-config" content="hhttps://vk.com/photo532832858_457244078">
    <meta name="apple-mobile-web-app-title" content="DEANONE">
    <meta name="application-name" content="DEANONE">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <script type="text/javascript" src="/js/func.js"></script>
    <link rel="stylesheet" href="css/index.css">
        <title>DEANONE - Админ панель</title>
    <body>
        <button name='update' onclick='showContent("admin.php")'>На главную</button>
<div id='result'></div>
<div id='loading' style='display: none'>Загрузка...</div>
        <div>
            </br>
        <?php
        
        
        //Проверяем хватает ли прав у админа для отображении кнопки
        if($admlevel->level >= 5){
        echo "<form action='/admin.php' method='POST'>
            <button name='new-adm'>Добавить Админа</button>
        </form>";
        }
        

        if($admlevel->level >= 5){
        echo "<form action='/admin.php' method='POST'>
            <input type='text' name='group_id'>
            <button name='group_join'>Накрутить</button>
        </form>";
        }
        
        //Проверяем хватает ли прав у админа для отображении кнопки
        if($admlevel->level >= 5){
            if(isset($_POST['users'])){
                all_user(); 
                
            }
            echo "<form action='/admin.php' method='POST'>
            <button name='users'>Аккаунты</button>
            </form>";
            echo $a;
        }
        
        
        ?>
        
        
        <form action='/admin.php' method='POST'>
            <button name='acc-profile'>VK Аккаунты</button>
        </form>
        <form action='/admin.php' method='POST'>
            <button name='quit'>Выйти</button>
        </form>
        
        </div>

    </body>

<!-- //Если пользователь не авторизован отправляем на авторизацию !-->
  <?php else : header('Location: vk.php');  ?> 
 
<!-- //Конец проверки авторизован или нет! !-->
  <?php endif;  ?> 

    </head>
    </html>