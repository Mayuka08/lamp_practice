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
            <td><?php print(number_format($history['quantity'])); ?></td>
            <td>
            <form method="post" action="detail.php">
              <input type="submit" value="購入明細表示">
              <input type="hidden" name="order_id" value="<?php print($history['order_id']); ?>">
            </form>
            </td>
          </tr>
      </tbody>
    </table>
    <!-- 購入明細 -->
    <table>
      <thead>
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
          <td><?php print($detail['name']); ?></td>
          <td><?php print($detail['price']); ?></td>
          <td><?php print($detail['amount']); ?></td>
          <td><?php print($detail['purchase_price']); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>