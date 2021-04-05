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
    redirect_to(LOGIN_URL);     // このコントーラは管理者、一般ユーザに関わらず見れるようにする必要があるので、一般ユーザをリダイレクトしてはダメです。
  }

$histories = history($db, $user['user_id']);

// is_admin()を使って見てくださいと言ったのは、管理者と一般ユーザとで取得する情報が異なるからです。以下のような構成で、もう一度考えてみてください
//  if(is_admin($user) === false) {
//    $histories = ログイン中のユーザの履歴データを取得する関数
//  } else {
//    $histories = 全ユーザの履歴データを取得する関数
//  }

$order_id = get_post('order_id');   // このコントーラにorder_idのリクエストは飛んでこないと思うので不要だと思います。
$token =get_csrf_token();

$quantity = sum_purchase($carts,$purchase_price); // これも不要でしょう。

include_once VIEW_PATH . 'history_view.php';
