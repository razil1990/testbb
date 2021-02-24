<?php if($arr !== [] && isset($_POST['submit'])): ?>
<ul class="errors">
  <?php foreach($arr as $k): ?>
  <li><?= $k ?> </li>
  <?php endforeach ?>
</ul>
<?php endif ?>
<form class="row g-3" action="" method="POST">
<?php require 'private_data_form.php' ?>
  <div class="col-12">
    <label for="depositSum" class="form-label">Сумма вклада, руб:</label>
    <input type="text" class="form-control" id="depositSum" name="deposit_sum" value="<?= $deposit_sum ?? 50000 ?>">
    <label for="depositSumRange" class="form-label"></label>
    <input type="range" class="form-range" id="depositSumRange"  min="50000" max="2000000" step="1000" value="<?= $deposit_sum ?? 50000 ?>">
  </div>
  <div class="col-12">
    <label for="depositTerm" class="form-label">Срок вклада, мес:</label>
    <input type="text" class="form-control" id="depositTerm" name="deposit_term" value="<?= $deposit_term ?? 6?>">
    <label for="depositTermRange" class="form-label"></label>
    <input type="range" class="form-range" id="depositTermRange" min="6" max="60" step="1" value="<?= $deposit_term ?? 6?>">
  </div>
  <div class="col-12">
    <label for="depositDate" class="form-label">Дата открытия вклада:</label>
    <input type="date" class="form-control" id="depositDate" name="deposit_date" 
    value="<?= $deposit_date ?? date('Y-m-d') ?>">
  </div>
    <input type="hidden" name="deposit_rate" value="<?= $deposit_rate ?? 6 ?>" id="depositRate">
    <input type="hidden" name="capitalization" value="<?= $capitalization ?>" id="capitalization">
  <div class="d-grid gap-2">
    <?php foreach($arr as $k => $v): ?>
      <input type="hidden"  name="err[<?=$k?>]" value="<?= $v ?>">
    <?php endforeach ?>
      <button type="submit" name="submit" class="btn btn-primary">Оформить заявку</button>
  </div>
</form>
<div class="info">
<h2 id="depositRateShow">Ставка: <?= $deposit_rate ?>%</h2>
<h2 id="capitalizationShow">Выплата по вкладу: <?= $capitalization ?></h2>
</div>
<script src="../public/js/deposit.js"></script>