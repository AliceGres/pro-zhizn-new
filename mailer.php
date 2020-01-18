<?php
/**
 * Created by PhpStorm.
 * User: gulidoveg
 * Date: 08.02.18
 * Time: 18:12
 */
if (!empty($_POST))
{
    $result = array('ok' => false);
    $settings = parse_ini_file('settings.ini');
    if (!empty($settings['post_fields']))
    {
        $arr = explode(',', $settings['post_fields']);
        $message = '';
        foreach ($arr as $f)
        {
            if (!empty($_POST[$f]))
            {
                $message .= strip_tags($_POST[$f]) . "\r\n";
            }
        }
        $headers = null;
        if (!empty($settings['address_from']))
        {
            $headers = 'From: ' . $settings['address_from'] . "\r\n";
        }
        if (!empty($settings['target_address']) && !empty($settings['target_subject']))
        {
            if (mail($settings['target_address'], $settings['target_subject'], $message, $headers))
            {
                $result['ok'] = true;
            }
        }

    }
    echo json_encode($result);
}