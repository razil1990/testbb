<?php

namespace vendor\core;

trait TValidation {

  public function validPostPrivate($data, &$arr) {
    extract($data);
    $err = [];
    $this->validStr($surname, $err, 'Фамилия');
    $this->validStr($client_name, $err, 'Имя');
    $this->validStr($patronymic, $err, 'Отчество');
    $this->validNum($tax_number, $err, 12, 'ИНН');
    $this->validDate($date_of_birth, $err, 'Дата рождения'); 
    $this->validNum($passport_series, $err, 4, 'Серия паспорта');
    $this->validNum($passport_number, $err, 6, 'Номер паспорта');
    $this->validDate($passport_date, $err, 'Дата выдачи паспорта'); 
    if(count($err) === 0) {
      return true;
    }
    $arr = $err;
    return false;
  }

  public function validPrivateDeposit($data, &$arr) {
    extract($data);
    $err = [];
    $this->validRangeNum($deposit_sum, $err, 'Сумма вклада', 50000, 2000000, 'руб.');
    $this->validRangeNum($deposit_term, $err, 'Срок вклада', 6, 60, 'мес.'); 
    $this->validDate($deposit_date, $err, 'Дата открытия вклада'); 
    if(count($err) === 0) {
      return true;
    }
    $arr = $err;
    return false;
  }

  public function validPrivateCredit($data, &$arr) {
    extract($data);
    $err = [];
    $this->validRangeNum($credit_sum, $err, 'Сумма кредита', 50000, 2000000, 'руб.');
    $this->validRangeNum($credit_term, $err, 'Срок кредита', 6, 360, 'мес.');
    $this->validDate($credit_date, $err, 'Дата открытия'); 
    if(count($err) === 0) {
      return true;
    }
    $arr = $err;
    return false;
  }

  public function validPostEntity($data, &$arr) {
    extract($data);
    $err = [];
    $this->validStr($surname, $err, 'Фамилия');
    $this->validStr($client_name, $err, 'Имя');
    $this->validStr($patronymic, $err, 'Отчество');
    $this->validFirmName($company_name, $err, 'Наименование организации');
    $this->validNum($registration_number, $err, 13, 'ОГРН');
    $this->validNum($tax_number, $err, 10, 'ИНН');
    $this->validNum($record_code, $err, 9, 'КПП');
    $this->validStr($region, $err, 'Регион');
    $this->validStr($city, $err, 'Населенный пункт');
    $this->validStr($street, $err, 'Улица');
    $this->validStrNum($house_number, $err, 'Номер дома', 5);
    if(count($err) === 0) {
      return true;
    }
    $arr = $err;
    return false;
}
  public function validEntityDeposit($data, &$arr) {
    extract($data);
    $err = [];
    $this->validRangeNum($deposit_sum, $err, 'Сумма вклада', 50000, 2000000, 'руб.');
    $this->validRangeNum($deposit_term, $err, 'Срок вклада', 6, 60, 'мес.'); 
    $this->validDate($deposit_date, $err, 'Дата открытия вклада'); 
    if(count($err) === 0) {
      return true;
    }
    $arr = $err;
    return false;
  }

  public function validEntityCredit($data, &$arr) {
    extract($data);
    $err = [];
    $this->validRangeNum($credit_sum, $err, 'Сумма кредита', 50000, 2000000, 'руб.');
    $this->validRangeNum($credit_term, $err, 'Срок кредита', 6, 360, 'мес.'); 
    if(count($err) === 0) {
      return true;
    }
    $arr = $err;
    return false;
  }

  public function checkStr($data) {
    if(preg_match("#^[а-я]+$#ui", $data, $matches)){
      return true;
    }
    return false;
  }

  public function validFirmName($data, &$err, $name = '') {
    if(empty($data)) {
      $err[] = 'Поле ' . $name . ' не должно быть пустым!';
      return;
    }
    if(!preg_match("#^[а-яА-Яa-zA-Z0-9 ]+$#u", $data, $matches)) {
      $err[] = 'Поле ' . $name . ' заполнено некорректно!';
      return;
    }
    if(mb_strlen($matches[0]) > 128) {
      $err[] = 'Поле ' . $name . ' не должно превышать 128 символов!';
      return;
    }     
  }

  public function validStr($str, &$err, $name = '') {
    if(empty($str)) {
      $err[] = 'Поле ' . $name . ' не должно быть пустым!';
      return;
    }
    if(mb_strlen($str) > 12) {
      $err[] = 'Поле ' . $name . ' не должно превышать 12 букв!';
      return;
    }
    if($this->checkStr($str) === false) {
      $err[] = 'Поле ' . $name . ' заполнено некорректно!';
    }
  }

  public function validStrNum($str, &$err, $name = '', $max_length = '') {
    if(empty($str)) {
      $err[] = 'Поле ' . $name . ' не должно быть пустым!';
      return;
    }
    if(mb_strlen($str) < 1 || mb_strlen($str) > $max_length) {
      $err[] = 'Некорректно заполнено поле ' . $name . '!';
    }
    if(!preg_match("#^[0-9]+([а-я])?$#ui", $str, $matches)) {
      $err[] = 'Поле ' . $name . ' заполнено некорректно!';
      return;
    }
  }

  public function validNum($num, &$err, $length, $name = '') {
    if(empty($num)) {
      $err[] = 'Поле ' . $name . ' не должно быть пустым!';
      return;
    }
    if(!preg_match("#^[0-9]+$#", $num, $matches)) {
      $err[] = 'Поле ' . $name . ' заполнено некорректно!';
      return;
    }
    if(mb_strlen($num) !== $length) {
      $err[] = 'Поле ' . $name . ' должно состоять из ' . $length . ' цифр!';
      return;
    }
  }

  public function validRangeNum($num, &$err, $name = '', $min_size = '', $max_size = '', $par = '') {
    if(empty($num)) {
      $err[] = 'Поле ' . $name . ' не должно быть пустым!';
      return;
    }
    if($num < $min_size) {
      $err[] = $name . ' не должно быть менее ' . $min_size . ' ' . $par . '!';
      return;
    } elseif($num > $max_size) {
      $err[] = $name . ' не может превышать ' . $max_size . ' ' . $par . '!';
      return;
    }
  }

  public function validDate($date, &$err, $name = '') {
    if(empty($date)) {
      $err[] = 'Поле ' . $name . ' не должно быть пустым!';
      return;
    }
    $pattern = "#^[0-9]{4}-\d{2}-\d{2}$#";
    if(!preg_match($pattern, $date, $matches)) {
      $err[] = 'Некорректная дата в поле ' . $name . '!';  
      return;
    }
  }
}