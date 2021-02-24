<?php

namespace app\controllers;

class EntityClient extends \vendor\core\Controller {
  public function creditAction() {
    $model = new \app\models\EntityClient;
    $arr = [];
    $surname = mb_convert_case(mb_strtolower(trim($_POST['surname'])), MB_CASE_TITLE);
    $client_name = mb_convert_case(mb_strtolower(trim($_POST['client_name'])), MB_CASE_TITLE);
    $patronymic = mb_convert_case(mb_strtolower(trim($_POST['patronymic'])), MB_CASE_TITLE);
    $company_name = mb_convert_case(mb_strtolower(trim($_POST['company_name'])), MB_CASE_TITLE);
    $region = mb_convert_case(mb_strtolower(trim($_POST['region'])), MB_CASE_TITLE);
    $city = mb_convert_case(mb_strtolower(trim($_POST['city'])), MB_CASE_TITLE);
    $street = mb_convert_case(mb_strtolower(trim($_POST['street'])), MB_CASE_TITLE);
    $house_number = trim($_POST['house_number']);
    $registration_number = $_POST['registration_number'];
    $tax_number = $_POST['tax_number'];
    $record_code = $_POST['record_code'];
    $credit_sum = $_POST['credit_sum'];
    $credit_term = $_POST['credit_term']; 
    $credit_rate = 8; 
    $credit_date = $_POST['credit_date'];
    $client_data = [
      'surname' => $surname,
      'client_name' => $client_name,
      'patronymic' => $patronymic,
      'company_name' => $company_name,
      'region' => $region,
      'city' => $city,
      'street' => $street,
      'house_number' => $house_number,
      'registration_number' => $registration_number,
      'tax_number' => $tax_number,
      'record_code' => $record_code,
      'credit_sum' => $credit_sum
    ];
    $credit_data = [
      'credit_sum' => $credit_sum,
      'credit_term' => $credit_term,
      'credit_date' => $credit_date
    ];
    if($model->validPostEntity($client_data, $arr) === true && $model->validEntityCredit($credit_data, $arr) === true) {
      $p = $credit_rate/100/12;
      $payment = $credit_sum * ($p + ($p/((pow(1+$p, $credit_term)) - 1)));
      $date = new \DateTime($credit_date);
      $date = $date->format('Y-m-d');
      $application_number = random_int(1, 1000000);
      $file = WWW . '/data/entity/credit/' . $application_number . '_' . $tax_number . '_credit.xml';
      while(file_exists($file) === true) {
          $application_number = random_int(1, 1000000);
          $file = WWW . '/data/entity/credit/' . $application_number . '_' . $tax_number . '_credit.xml';
      }
      while($credit_sum > 0) {
        $percentage = $credit_sum*$p;
        $debt = $payment - $percentage;
        if($payment > $credit_sum) {
          $payment = $credit_sum;
          $percentage = 0;
          $debt = $payment;
        }
        $credit_sum = $credit_sum - $debt;
        $date = new \DateTime($date);
        $date = $date->format('Y-m-d');
        $credit_data = [
          'date' => round($date, 0, PHP_ROUND_HALF_UP), 
          'payment' => round($payment, 0, PHP_ROUND_HALF_UP), 
          'percentage' => round($percentage, 0, PHP_ROUND_HALF_UP), 
          'debt' => round($debt, 0, PHP_ROUND_HALF_UP),  
          'sum' => round($credit_sum, 0, PHP_ROUND_HALF_UP) 
        ];
        if(file_exists($file)){
          $xml = simplexml_load_file($file);
          $credit = $xml->addChild('creditdata');
          foreach($credit_data as $k => $v) {
            $credit->addChild($k, $v);
          }
          $xml->asXML($file);
          }else{
            $xml = new \SimpleXMLElement('<client/>');
            $client = $xml->addChild('clientdata');
            foreach($client_data as $k => $v) {
              $client->addChild($k, $v);
            }
            $credit = $xml->addChild('creditdata');
            foreach($credit_data as $k => $v) {
              $credit->addChild($k, $v);
            }
            $xml->asXML($file);  
          }
          $date = new \DateTime($date);
          $date->modify('+1 month');
          $date = $date->format('Y-m-d');
        }
       
      if($model->findOne('tax_number', $tax_number) !== []) {
        $stmt = $model->findOne('tax_number', $tax_number);
        $res = $model->query("INSERT INTO entity_credits (credit_file, client_id)
          VALUES (?,?)", [$file, $stmt[0]['id']]);  
      } else {
        $client_data = [$surname, $client_name,  $patronymic, $company_name, $region, $city, $street, $house_number, $registration_number, $tax_number, $record_code];
        $res = $model->query("INSERT INTO entity_clients (surname, client_name,  patronymic,  company_name,  region, city, street, house_number, registration_number, tax_number, record_code)
        VALUES ({$model->countPlaceHolders($client_data)})", $client_data);
      }
      if($res !== false && $model->findOne('tax_number', $tax_number) !== []) {
        $stmt = $model->findOne('tax_number', $tax_number);
        $res = $model->query("INSERT INTO entity_credits (credit_file, client_id)
          VALUES (?,?)", [$file, $stmt[0]['id']]);  
      }
      if($res !== []) {
        $_SESSION['success'] = 'Ваша заявка принята';
        header('Location: /main');
        die;
      }
    }
    $this->setView(compact(
      'surname', 
      'client_name', 
      'patronymic', 
      'company_name', 
      'region',
      'city',
      'street',
      'house_number',
      'registration_number',
      'tax_number',
      'record_code',
      'credit_sum', 
      'credit_term', 
      'credit_date', 
      'credit_rate',
      'arr'
    ));
  }

  public function depositAction() {
    $model = new \app\models\EntityClient;
    $arr = [];
    $surname = mb_convert_case(mb_strtolower(trim($_POST['surname'])), MB_CASE_TITLE);
    $client_name = mb_convert_case(mb_strtolower(trim($_POST['client_name'])), MB_CASE_TITLE);
    $patronymic = mb_convert_case(mb_strtolower(trim($_POST['patronymic'])), MB_CASE_TITLE);
    $company_name = trim($_POST['company_name']);
    $region = mb_convert_case(mb_strtolower(trim($_POST['region'])), MB_CASE_TITLE);
    $city = mb_convert_case(mb_strtolower(trim($_POST['city'])), MB_CASE_TITLE);
    $street = mb_convert_case(mb_strtolower(trim($_POST['street'])), MB_CASE_TITLE);
    $house_number = trim($_POST['house_number']);
    $registration_number = $_POST['registration_number'];
    $tax_number = $_POST['tax_number'];
    $record_code = $_POST['record_code'];
    $deposit_sum = $_POST['deposit_sum'];
    $deposit_term = $_POST['deposit_term'] ?? 6; 
    $deposit_rate = 6; 
    $deposit_date = $_POST['deposit_open'] ?? date('Y-m-d'); 
    $deposit_open = new \DateTime($deposit_date);
    $deposit_close = new \DateTime($deposit_date);
    $deposit_close->modify('+' . $deposit_term . 'month');
    $t = ($deposit_close->diff($deposit_open))->days;
    $capitalization = round($deposit_sum * $deposit_rate/100 * $t/365, 0, PHP_ROUND_HALF_UP);
    $client_data = [
      'surname' => $surname,
      'client_name' => $client_name,
      'patronymic' => $patronymic,
      'company_name' => $company_name,
      'region' => $region,
      'city' => $city,
      'street' => $street,
      'house_number' => $house_number,
      'registration_number' => $registration_number,
      'tax_number' => $tax_number,
      'record_code' => $record_code,
      'deposit_sum' => $deposit_sum
    ];
    $deposit_data = [
      'deposit_sum' => $deposit_sum,
      'deposit_term' => $deposit_term,
      'deposit_date' => $deposit_date
    ];
    
    if($model->validPostEntity($client_data, $arr) === true && $model->validEntityDeposit($deposit_data, $arr)) {
      $application_number = random_int(1, 1000000);
      $file = WWW . '/data/entity/deposit/' . $application_number . '_' . $tax_number . '_credit.xml';
      while(file_exists($file) === true) {
          $application_number = random_int(1, 1000000);
          $file = WWW . '/data/entity/deposit/' . $application_number . '_' . $tax_number . '_credit.xml';
      }
      $deposit_data = [
        'deposit_open' => $deposit_open->format('Y-m-d'), 
        'deposit_close' => $deposit_close->format('Y-m-d'),
        'deposit_term' => round($t/31, 0, PHP_ROUND_HALF_UP),
        'deposit_rate' => $deposit_rate,  
        'capitalization' => $capitalization 
      ];
      if(file_exists($file)){
        $xml = simplexml_load_file($file);
        $deposit = $xml->addChild('depositdata');
        foreach($deposit_data as $k => $v) {
          $deposit->addChild($k, $v);
        }
        $xml->asXML($file);
      }else{
        $xml = new \SimpleXMLElement('<client/>');
        $client = $xml->addChild('clientdata');
        foreach($client_data as $k => $v) {
          $client->addChild($k, $v);
        }
        $deposit = $xml->addChild('depositdata');
        foreach($deposit_data as $k => $v) {
          $deposit->addChild($k, $v);
        }
        $xml->asXML($file);  
      }

      if($model->findOne('tax_number', $tax_number) !== []) {
          $stmt = $model->findOne('tax_number', $tax_number);
          $data = [$deposit_data['deposit_open'], $deposit_data['deposit_close'], $deposit_data['deposit_term'], $deposit_rate, $deposit_sum, $deposit_data['capitalization'], $stmt[0]['id'], $file];
          $res = $model->query("INSERT INTO entity_deposits (deposit_open, deposit_close, deposit_term, deposit_rate, deposit_sum, capitalization, client_id, deposit_file)
            VALUES ({$model->countPlaceHolders($data)})", $data);
      } else {
        $client_data = [$surname, $client_name,  $patronymic, $company_name, $region, $city, $street, $house_number, $registration_number, $tax_number, $record_code];
        $res = $model->query("INSERT INTO entity_clients (surname,  client_name, patronymic,company_name,  region, city,  street,  house_number,  registration_number, tax_number, record_code)
          VALUES ({$model->countPlaceHolders($client_data)})", $client_data);
      }
      if($res !== false && $model->findOne('tax_number', $tax_number) !== []) {
        $stmt = $model->findOne('tax_number', $tax_number);
        $data = [$deposit_data['deposit_open'], $deposit_data['deposit_close'], $deposit_data['deposit_term'], $deposit_rate, $deposit_sum, $deposit_data['capitalization'], $stmt[0]['id'], $file];
        $res = $model->query("INSERT INTO entity_deposits (deposit_open, deposit_close, deposit_term,  deposit_rate, deposit_sum, capitalization, client_id, deposit_file)
          VALUES ({$model->countPlaceHolders($data)})", $data);
      }
      if($res !== []) {
        $_SESSION['success'] = 'Ваша заявка принята';
        header('Location: /main');
        die;
      }
    }
      $this->setView(compact(
        'surname', 
        'client_name', 
        'patronymic', 
        'company_name', 
        'region',
        'city',
        'street',
        'house_number',
        'registration_number',
        'tax_number',
        'record_code',
        'deposit_sum', 
        'deposit_term', 
        'deposit_open', 
        'deposit_rate',
        'capitalization',
        'arr'
      ));
  }
}

