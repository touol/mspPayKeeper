<?php

define('MODX_API_MODE', true);
require dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/index.php';

$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget('FILE');

/** @var minishop2 $miniShop2 */
$miniShop2 = $modx->getService('minishop2');
$miniShop2->loadCustomClasses('payment');

if (!class_exists('PayKeeper')) {
	exit('Error: could not load payment class "PayKeeper".');
}

$handler = new PayKeeper($modx->newObject('msOrder'));
  $secret_seed = $handler->modx->getOption('msppaykeeper_secret_seed');
  
  $id = $_POST['id'];
  $sum = $_POST['sum'];
  $clientid = $_POST['clientid'];
  $orderid = $_POST['orderid'];
  $key = $_POST['key'];
 
  if ($key != md5 ($id . sprintf ("%.2lf", $sum).
                                 $clientid.$orderid.$secret_seed))
  {
      echo "Error! Hash mismatch";
      exit;
  }
 
  if ($orderid == "")
  {
      echo "Error! orderid empty.";
      exit;
  }
  else
  {
	  //$modx->log(1,'order_num '.$_POST['orderid']);
	  if(!$order = $modx->getObject('msOrder', array('num'=>$_POST['orderid']))){
	      echo "Error! order not found.";
	      exit;
	  }
      $miniShop2->changeOrderStatus($order->id, 2);
	  echo "OK ".md5($id.$secret_seed);
  }