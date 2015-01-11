<?php
// Skapa en array med de sajter som ska testas.
$url = 'http://www.nitea.se/wp-content/themes/nitea/send.mail.php?p=kontakt';
$formsArr = array();
$formsArr[] = array(
    'url' => $url,
    'fields' => array(
        'kontakt_name' => urlencode('Nitea AB'),
        'kontakt_email' => urlencode('no-reply@nitea.se'),
        'kontakt_phone' => urlencode('08771314'),
        'kontakt_subject' => urlencode('Automatiskt test av formulär'),
        'kontakt_msg' => urlencode('Det här meddelandet skickas via ert formulär på sidan: "'.$url.'"')
    )
);

$htmlOut = '';
foreach($formsArr AS $form){
    $fields_string = '';
    foreach($form['fields'] as $key=>$value) { 
        $fields_string .= $key.'='.$value.'&'; 
    }
    rtrim($fields_string, '&');
    $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $form['url']);
        curl_setopt($ch,CURLOPT_POST, count($form['fields']));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        $result = curl_exec($ch);
    curl_close($ch);
    
    $htmlOut .= ('<tr><th>'.$form['url'].'</th>');
    if($result){
        $htmlOut .= ('<td>Lyckades</td>');
    }else{
        $htmlOut .= ('<td>Misslyckades</td>');
    }
    $htmlOut .= ('</tr>');
}
?>
<!DOCTYPE html>
<html lang="sv-SE">
    <head>
        <title>Kontakta oss</title>
        <style>
            th{text-align: left;}
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Adress:</th>
                    <th>Resultat:</th>
                </tr>
            </thead>
            <tbody>
                <?php echo($htmlOut); ?>
            </tbody>
        </table>
    </body>
</html>