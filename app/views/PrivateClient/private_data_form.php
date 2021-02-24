<h3>Данные клиента</h3>
<div class="col-12">
  <label for="surname" class="form-label">Фамилия:</label>
  <input type="text" class="form-control" id="surname" name="surname" placeholder="Иванов" value="<?= $surname ?? ''?>">
</div>
<div class="col-12">
  <label for="client_name" class="form-label">Имя:</label>
  <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Иван" value="<?= $client_name ?? ''?>">
</div>
<div class="col-12">
  <label for="patronymic" class="form-label">Отчество:</label>
  <input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Иванович" value="<?= $patronymic ?? ''?>">
</div>
<div class="col-12">
  <label for="tax_number" class="form-label">ИНН:</label>
  <input type="text" class="form-control" id="tax_number" name="tax_number" placeholder="999999999999" value="<?= $tax_number ?? ''?>">
</div>
<div class="col-12">
  <label for="date_of_birth" class="form-label">Дата рождения:</label>
  <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= $date_of_birth ?? ''?>">
</div>
<div class="col-12">
  <h3>Паспортные данные</h3>
  <label for="passport_series" >Серия:</label>
  <input type="text" class="form-control" id="passport_series" name="passport_series" placeholder="9999" value="<?= $passport_series ?? ''?>">
</div>
<div class="col-12">
<label for="passport_number" >Номер:</label>
  <input type="text" class="form-control" id="passport_number" name="passport_number" placeholder="999999" value="<?= $passport_number ?? ''?>">
</div>
<div class="col-12">
<label for="passport_date" >Дата выдачи:</label>
  <input type="date" class="form-control" id="passport_date" name="passport_date" value="<?= $passport_date ?? ''?>">
</div>

  