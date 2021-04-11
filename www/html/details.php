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
$order_id = get_post('order_id');
$token =get_csrf_token();

// 購入履歴画面と同様に、管理者と一般ユーザとでデータの取得方法が異なってくる
 if (is_admin($user) === false) {
   $histories = get_details_history($db, $order_id,$user['user_id']);
   $details = get_details_detail($db,$order_id, $user['user_id']);
 }else {
   $histories = get_admin_details_history($db,$order_id);//内容に、order_idを条件に追加した関数
   $details = get_detail($db, $order_id);
 }

// $historyは「注文番号」「購入日時」「合計金額」が格納された1件の連想配列
// $detailsはorder_idに該当する明細が格納された配列

include_once VIEW_PATH . 'details_view.php';
