<?php
/** @var modX $modx */
/** @var array $sources */

$settings = array();

$tmp = array(
    'payment_form_url' => array(
        'xtype' => 'textfield',
        'value' => 'http://demo.paykeeper.ru/order/inline/',
        'area' => 'general',
    ),
	'secret_seed' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'general',
    ),
	'snippet_page_id' => array(
        'xtype' => 'textfield',
        'value' => '',
        'area' => 'general',
    ),
);

foreach ($tmp as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge(
        array(
            'key' => 'msppaykeeper_' . $k,
            'namespace' => PKG_NAME_LOWER,
        ), $v
    ), '', true, true);

    $settings[] = $setting;
}
unset($tmp);

return $settings;
