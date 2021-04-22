<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  
  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    <div class="order_sort">
      <form action="./index.php" method="get">
        <select name="sort">
            <option value="new" <?php if ($sort === 'new') print 'selected'; ?>>新着順</option>
            <option value="cost_up" <?php if ($sort === 'cost_up') print 'selected'; ?>>価格の安い順</option>
            <option value="cost_down" <?php if ($sort === 'cost_down') print 'selected'; ?>>価格の高い順</option>
        </select>
        <input type = "submit" name  = "sort_button" value = "並び替え">
      </form>
    </div>
    <div class="card-deck">
      <div class="row">
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . h($item['image'])); ?>">
              <figcaption>
                <?php print(number_format(h($item['price']))); ?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                    <input type="hidden" name="token" value="<?php print $token;?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
    <h1>人気ランキング</h1>
    <div class="card-header">
    <?php $rank = 1; ?>
      <?php foreach($rows as $row) { ?>
    <tr>
        <td>
        <span class="rank"><?php print "第{$rank}位 "; ?></span>
        <?php print(h($row['name'])); ?>
        </td>
        <td><img class="card-img" src="<?php print(IMAGE_PATH . h($row['image'])); ?>"></td>
    <tr>
    <?php $rank++; ?>
    <?php } ?>
    </div>
  </div>
  
</body>
</html>