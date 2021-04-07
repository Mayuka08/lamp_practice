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
$histories = get_history($db, $user['user_id']);  // ここでは不要です。
$order_id = get_post('order_id');
$token =get_csrf_token();

// 購入履歴画面と同様に、管理者と一般ユーザとでデータの取得方法が異なってくると思います。
//  if (is_admin($user) === false) {
//    $history = get_history()の内容に、order_idを条件に追加した関数
//    $details = get_detail()の内容に、user_idを条件に追加した関数
//  else {
//    $history = get_admin_history()の内容に、order_idを条件に追加した関数
$details = get_detail($db, $user['user_id']);   // 引数には$user['user_id']ではなく$order_idだと思います
//  }

// $historyは「注文番号」「購入日時」「合計金額」が格納された1件の連想配列
// $detailsはorder_idに該当する明細が格納された配列

$quantity = sum_purchase($histories);   // これは不要です。

include_once VIEW_PATH . 'details_view.php';
