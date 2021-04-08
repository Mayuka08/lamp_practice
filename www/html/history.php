<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}
$db = get_db_connect();
$user = get_login_user($db);

if(is_admin($user) === false){
    $histories = get_history($db, $user['user_id']);     //ログイン中のデータ閲覧
  }else {
    $histories = get_admin_history($db);   //管理者による全データ閲覧
  }
  
$token =get_csrf_token();


include_once VIEW_PATH . 'history_view.php';
