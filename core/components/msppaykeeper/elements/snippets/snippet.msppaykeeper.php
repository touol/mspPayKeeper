<?php
/** @var modX $modx */
/** @var array $scriptProperties */

  # предполагаются заранее известными значения переменных
  # $client_login, $order_id, $order_sum и $optional_phone
 /** @var minishop2 $miniShop2 */
$miniShop2 = $modx->getService('minishop2');
if(!$order = $modx->getObject('msOrder', array('num'=>$_GET['order_num']))) return "Не найден заказ!";
$sum = number_format($order->get('cost'), 2, '.', '');

$msppk_payment_form_url = $modx->getOption('msppaykeeper_payment_form_url');

  $payment_parameters = http_build_query(array(
                "clientid"=>$modx->user->get("id"),
                "orderid"=>$_GET['order_num'],
                "sum"=>$sum));
  $options = array("http"=>array(
                "method"=>"POST",
                "header"=>
                "Content-type: application/x-www-form-urlencoded",
                "content"=>$payment_parameters
                   ));
  $context = stream_context_create($options);
 
  echo file_get_contents($msppk_payment_form_url, FALSE, $context);