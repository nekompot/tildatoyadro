<?php
//Загрузка данных в amoCRM (by INTROVERT)

$intr_key = 'b1a9969e';
$introvertUrl = 'https://api.yadrocrm.ru/integration/site?key='. $intr_key;

$cookieData = json_decode($_COOKIE['introvert_cookie'], true) ?: array(); // данные сохраняемые js скриптом
$postArr = array_merge($cookieData, $_POST); // $_POST данные отправленной формы
// объединяем данные и отправляем

$postArr['page_url_source'] = 'другое';
if (!(stristr($postArr['page_url'], 'opt50.ru/yc1') === FALSE)) $postArr['page_url_source'] = 'context__LP-07__opt50.ru/yc1';
if (!(stristr($postArr['page_url'], 'kmb5.ru/y/') === FALSE)) $postArr['page_url_source'] = 'context__LP-08__kmb5.ru/y/';
if (!(stristr($postArr['page_url'], 'kmb5.ru/ortrgt/') === FALSE)) $postArr['page_url_source'] = 'context__RETARG__kmb5.ru/ortrgt/';
if (!(stristr($postArr['page_url'], 'kimberlit.ru') === FALSE)) $postArr['page_url_source'] = 'SEO__site__kimberlit.ru';
if (!(stristr($postArr['page_url'], 'kamen.pro') === FALSE)) $postArr['page_url_source'] = 'SEO__site__kamen.pro';
if (!(stristr($postArr['utm_source'], 'facebook') === FALSE)) $postArr['page_url_source'] = 'SMM__facebook.com';
if (!(stristr($postArr['utm_source'], 'instagram') === FALSE)) $postArr['page_url_source'] = 'SMM__instagram.com';
if (!(stristr($postArr['utm_source'], 'youtube') === FALSE)) $postArr['page_url_source'] = 'SMM__youtube.ru';
$postArr['channel'] = 'Интернет';
$postArr['connect'] = 'Заполнил форму на сайте';

if (function_exists('curl_init')) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $introvertUrl);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postArr));
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Yadro-Site-Integration-client/1.0');
    $result = curl_exec($curl);
    curl_close($curl);
} else {
    if ((boolean) ini_get('allow_url_fopen')) {
        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($postArr),
                'timeout' => 2,
            )
        );

        try {
            file_get_contents($introvertUrl, false, stream_context_create($opts));
        } catch (Exception $e) {
            return;
        }
    }
}
