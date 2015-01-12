<?php
// Skapa en array med de sajter som ska testas.
$url = '';
$formsArr = array();
$formsArr[] = array(
    'url' => $url,
    'fields' => array(
        'kontakt_name' => urlencode(''),
        'kontakt_email' => urlencode(''),
        'kontakt_phone' => urlencode(''),
        'kontakt_subject' => urlencode(''),
        'kontakt_msg' => urlencode('')
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
