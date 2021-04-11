<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入明細</h1>
  <div class="container">
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

      <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($histories as $history){ ?>
          <tr>
            <td><?php print($history['order_id']);?></td>
            <td><?php print($history['order_datetime']); ?></td>
            <td><?php print(number_format(h($history['quantity']))); ?></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    <!-- 購入明細 -->
    <table class="table table-bordered">
      <thead class="thead-light">
        <tr>
            <th>商品名</th>
            <th>購入時の商品価格</th>
            <th>購入数</th>
            <th>小計</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($details as $detail){ ?>
        <tr>
          <td><?php print(h($detail['name'])); ?></td>
          <td><?php print(h($detail['purchase_price'])); ?></td>
          <td><?php print(h($detail['amount'])); ?></td>
          <td><?php print(h($detail['purchase_price']) * h($detail['amount'])); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>