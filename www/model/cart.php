<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
  ";
  return fetch_all_query($db, $sql,[$user_id]);
}

function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
    AND
      items.item_id = ?
  ";

  return fetch_query($db, $sql,[$user_id,$item_id]);

}

function add_cart($db, $user_id, $item_id ) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}

function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES(?,?,?)
  ";

  return execute_query($db, $sql,[$item_id,$user_id,$amount]);
}
// $quantity　コントローラーで呼び出す
function sum_purchase($carts,$purchase_price){
  $quantity = 0;
  foreach($carts as $cart){
    $quantity += $purchase_price * $cart['amount'];
  }
  return $quantity;
}

function insert_history($db,$user_id,$quantity){
    $sql = "
      INSERT INTO
        purchase_history(
          user_id,
          order_datetime,
          quantity
        )
      VALUES(?,now(),?)
    ";
    return execute_query($db,$sql,[$user_id,$quantity]);
}
function insert_details($db,$order_id,$item_id,$amount,$purchase_price){
  $sql = "
    INSERT INTO
      purchase_details(
        order_id,
        item_id,
        amount,
        purchase_price
      )
    VALUES(?,?,?,?)
  ";
  return execute_query($db,$sql,[$order_id,$item_id,$amount,$purchase_price]);
}

function update_cart_amount($db, $cart_id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = ?
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  return execute_query($db, $sql,[$amount,$cart_id]);
}

function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  return execute_query($db, $sql,[$cart_id]);
}
//購入後カートの中身削除、在庫変動、履歴＆明細にデータいれる
function purchase_carts($db, $carts){
  if(validate_cart_purchase($carts) === false){
    return false;
  }
  $db->beginTransaction();
  if(insert_history($db,$carts[0]['user_id'], sum_carts($carts)) === false) {
    set_error('購入履歴の作成に失敗しました。');
    return false;
  }
  $oder_id = $db->lastInsertId();

  foreach($carts as $cart){
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
    if(insert_details(
        $db,
        $oder_id,
        $cart['item_id'],
        $cart['amount'],
        $cart['price']) === false){
          set_error($cart['name'].'の購入明細の作成に失敗しました。');
    }
  }
  delete_user_carts($db, $carts[0]['user_id']);

  if(has_error() === true){
    $db -> rollback();
    return false;
  }else {
    $db -> commit();
    return true;
  }
}

function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = ?
  ";

  execute_query($db, $sql,[$user_id]);
}


function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

function validate_cart_purchase($carts){
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach($carts as $cart){
    if(is_open($cart) === false){
      set_error($cart['name'] . 'は現在購入できません。');
    }
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  if(has_error() === true){
    return false;
  }
  return true;
}

