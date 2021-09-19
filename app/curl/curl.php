<?php




/*$str = "http://www.solonin.org/live_ryadom-s-molodoy-gvardiey";
    //$str ="http://php.net/manual/ru/function.mb-convert-encoding.php";
     $str ='https://www.opennet.ru/';
//$str = "https://github.com/diversen/get-meta-tags";
//$str = "https://www.facebook.com/permalink.php?story_fbid=1506790069414839&id=734265936667260";
//$str = "https://habrahabr.ru/post/338880/";
//https://ain.ua/2017/11/09/tenevye-profili
 $str = "https://phpclub.ru/detail/article/curl";
$str = 'https://m.youtube.com/watch?v=jLgb3CVVTRw';
$str = getHTML($str);
echo getCharset($str);*/
//$link = titleAsLink($str);
//echo $link;
//if (strlen($link)) echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'.$link; else echo "Title is not exist";
/*
 * СЌС‚РѕС‚ РїР°РєРµС‚ С„СѓРЅРєС†РёР№ РїСЂРµРґРЅР°Р·РЅР°С‡РµРЅ РґР»СЏ РІС‹Р±РѕСЂРєРё
 */

function getUrlFromStr($str){
    $startUrl= stripos($str, "http");
    if($startUrl === FALSE) 
        $startUrl= stripos($str, "https");
    $strUrl = '';
    $pos =$startUrl;
    if ( $startUrl !== FALSE){
        for($pos = $startUrl; $pos < strlen($str); $pos++){

            if( strchr (' ><;'."\r"."\n", $str[$pos])){
                $strUrl.= 'class=" hover:text-red-500"';
                
                break;
            }
            else{
                $strUrl.=$str[$pos];
            }
        }
    }
    return $strUrl;    
}

/*
 * РџРѕР»СѓС‡Р°РµС‚ html-РєРѕРґ СЃС‚СЂР°РЅРёС†С‹ РїРѕ РµРµ url
 */
function getHTML($strURL){
    
    $ch = curl_init($strURL);
    
    
    curl_setopt ($ch, CURLOPT_URL, $strURL);    
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "Gal_sergey@ukr.net:student");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIESESSION, false);        
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);//СЃ СЌС‚РѕР№ СЃС‚СЂРѕС‡РєРѕР№ Р·Р°СЂР°Р±РѕС‚Р°Р» С„РµР№СЃР±СѓРє.

    $response_data = curl_exec($ch);
    
    if (curl_errno($ch) > 0) {
       echo 'Error curl: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response_data;

}
/*
 * РџРѕР»СѓС‡Р°РµС‚ Р·Р°РіРѕР»РѕРІРѕРє СЃС‚СЂР°РЅРёС† РёР· РєРѕРґР° СЃС‚СЂР°РЅРёС†С‹
 */
function  getTitle ($htmlPage){
    $title ='';
    if (strlen($htmlPage)){
        //РЅР°С…РѕРґРёРј РІС…РѕР¶РґРµРЅРёРµ СЃС‚СЂРѕРєРё <title>
        $pos = stripos($htmlPage, "<title");
        //РЅР°С…РѕРґРёРј РїРѕР·РёС†РёСЋ > РѕС‚ С‚РµРєСѓС‰РµР№
        $startTitle  = stripos($htmlPage, ">",$pos)+1;
        //РЅР°С…РѕРґРёРј РїРѕР·РёС†РёСЋ < РѕС‚ С‚РµРєСѓС‰РµР№
        $endTitle =  stripos($htmlPage, "<",$startTitle);
        $title = substr($htmlPage, $startTitle,$endTitle-$startTitle);
        $charset = getCharset($htmlPage);
        
        $title_after_convert = @iconv($charset,"utf-8", $title);
        if($title_after_convert) $title = $title_after_convert;
    }

    return $title;
}
/*
 * РџРѕР»СѓС‡Р°РµС‚ Р·Р°РіРѕР»РѕРІРѕРє СЃС‚СЂР°РЅРёС†С‹ РїРѕ РµРµ url Рё РїСЂРµРѕР±СЂР°Р·СѓРµС‚ РµРіРѕ РІ СЃСЃС‹Р»РєСѓ
 */
function titleAsLink($strUrl){
    $title = getTitle(getHTML($strUrl));
    return "<a href = '$strUrl' class='hover:text-blue-800'>$title</a>";
}

function getCharset($htmlPage){
    $charset ='ASCII';//РєРѕРґРёСЂРѕРІРєР° РїРѕ СѓРјРѕР»С‡Р°РЅРёСЋ
    
    if (strlen($htmlPage)){
        
        //РЅР°С…РѕРґРёРј РІС…РѕР¶РґРµРЅРёРµ СЃС‚СЂРѕРєРё charset
        if(stripos($htmlPage, 'charset')){
            $pos = stripos($htmlPage, 'charset') + strlen('charset') + 1;
            if($pos){
                $charset = '';
                do{

                    if ($htmlPage[$pos] == '"' || $htmlPage[$pos] == "'"){

                    }else{
                        $charset.= $htmlPage[$pos];

                    }
                    $pos++;
                }
                while(!strchr("'".'"'.';,', $htmlPage[$pos]));
                }
            }
        
    }
    return $charset;
}

