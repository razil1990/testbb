<h3>Данные клиента:</h3>
<div class="col-12">
<label for="surname" class="form-label">Данные руководителя организации:</label>
  <input type="text" class="form-control" id="surname" name="surname" placeholder="Фамилия" value="<?= $surname ?? ''?>">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="client_name" name="client_name" placeholder="Имя" value="<?= $client_name ?? ''?>">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="patronymic" name="patronymic" placeholder="Отчество" value="<?= $patronymic ?? ''?>">
</div>
<div class="col-12">
  <label for="company_name" class="form-label">Данные организации:</label>
  <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Наименование" value="<?= $company_name ?? ''?>">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="registration_number" name="registration_number" placeholder="ОГРН" value="<?= $registration_number ?? ''?>">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="tax_number" name="tax_number" placeholder="ИНН" value="<?= $tax_number ?? ''?>">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="record_code" name="record_code" placeholder="КПП" value="<?= $record_code ?? ''?>">
</div>
<div class="col-12">
<label for="region" class="form-label">Адрес организации:</label>
  <input type="text" class="form-control" id="region" name="region" placeholder="Край/область/республика" value="<?= $region ?? ''?>">
  </div>
  <div class="col-12">
  <input type="text" class="form-control" id="city" name="city" placeholder="Населенный пункт" value="<?= $city ?? ''?>">
</div> 
<div class="col-12">
  <input type="text" class="form-control" id="street" name="street" placeholder="Улица" value="<?= $street ?? ''?>">
</div>
<div class="col-12">
  <input type="text" class="form-control" id="house_number" name="house_number" placeholder="Номер дома" value="<?= $house_number ?? ''?>">
</div>