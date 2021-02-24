<template id="tmpl">
  <table id="table">
    <tr>
      <td>Дата платежа</td>
      <td>Ежемесячный платеж</td>
      <td>Процентная часть</td>
      <td>Долговая часть</td>
      <td>Остаток долга</td>
    </tr>
    <tbody id="tbody">
    </tbody>
  </table>
</template>
<div id="container">
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
    <h3>Данные кредита</h3>
      <label for="creditSum" class="form-label">Сумма кредита, руб:</label>
      <input type="text" class="form-control" id="creditSum" name="credit_sum" value="<?= $credit_sum ?? 50000 ?>">
      <label for="creditSumRange" class="form-label"></label>
      <input type="range" class="form-range" id="creditSumRange" 
              min="50000" max="2000000" step="1000" value="<?= $credit_sum ?? 50000 ?>">
    </div>
    <div class="col-12">
      <label for="creditTerm" class="form-label">Срок кредита, мес:</label>
      <input type="text" class="form-control" id="creditTerm" name="credit_term" value="<?= $credit_term ?? 6?>">
      <label for="creditTermRange" class="form-label"></label>
      <input type="range" class="form-range" id="creditTermRange"
              min="6" max="360" step="1" value="<?= $credit_term ?? 6?>">
    </div>
    <div class="col-12">
      <label for="creditDate" class="form-label">Дата первого платежа:</label>
      <input type="date" class="form-control" id="creditDate" name="credit_date" 
      value="<?= $credit_date ?? date('Y-m-d') ?>">
    </div>
      <input type="hidden" name="credit_rate" value="<?= $credit_rate ?>" id="creditRate">
    <div class="d-grid gap-2">
    <?php foreach($arr as $k => $v): ?>
      <input type="hidden"  name="err[<?=$k?>]" value="<?= $v ?>">
    <?php endforeach ?>
      <button type="submit" name="submit" class="btn btn-primary">Оформить заявку</button>
    </div>
  </form>
  <div class="info">
    <h2 id="rate">Ставка: <?= $credit_rate ?>%</h2>
    <h2 id="payment">Ежемесячный платеж: 0 руб.</h2>
  </div>
  <div class="d-grid gap-2">
    <button type="button" class="btn btn-primary" id="paymentSchedule">Посмотреть график</button>
  </div>
</div>
<script src="../public/js/credit.js"></script>
