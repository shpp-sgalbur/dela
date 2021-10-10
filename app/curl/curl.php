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
 * этот пакет функций предназначен для выборки
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
 * Получает html-код страницы по ее url
 */
function getHTML($strURL){
    
    $ch = curl_init($strURL);
    
    
    curl_setopt ($ch, CURLOPT_URL, $strURL);   
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 1);  
    curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "Gal_sergey@ukr.net:student");
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIESESSION, false);        
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);//с этой строчкой заработал фейсбук.

    $response_data = curl_exec($ch);
    
    if (curl_errno($ch) > 0) {
       echo 'Error curl: ' . curl_error($ch);
    }
    curl_close($ch);
    return $response_data;

}
/*
 * Получает заголовок страниц из кода страницы
 */
function  getTitle ($htmlPage){
    $title ='';
    if (strlen($htmlPage)){
        //находим вхождение строки <title>
        $pos = stripos($htmlPage, "<title");
        //находим позицию > от текущей
        $startTitle  = stripos($htmlPage, ">",$pos)+1;
        //находим позицию < от текущей
        $endTitle =  stripos($htmlPage, "<",$startTitle);
        $title = substr($htmlPage, $startTitle,$endTitle-$startTitle);
        
        //dump($title);
        //echo '-------';
      
        //dump(mb_detect_encoding($title));
        
         
        //echo '======';
        
        $charset = checkCharset($title);
        //dump($charset);
        
        //echo '======';
       // dump(mb_convert_encoding($title,"UTF-8"));
        //dump(mb_convert_encoding(mb_convert_encoding($title,"utf-8","KOI8-R"),"KOI8-R","UTF-8"));
        if($charset != "UTF-8"){
            
            $title = @mb_convert_encoding($title,"utf-8",$charset);
        }
         
        if($title == false) $title = '';
        //dd($title);
            
    }
    
    return $title;
}
function checkCharset($string){
    $charSetArr = [
        "UTF-8",
        "Windows-1251",
        "Windows-1252",
        "KOI8-R",
        //"ISO 8859-1",
        //"ISO 8859-5",
        //"CP 866",
        
        "UTF-16",
        "ASCII"
    ];
    
//    try{
//        dump(mb_convert_variables("UTF-8", $charSetArr, $string));
//    } catch (Exception $ex) {
//        dump("string befor= ".$string);
//        dump("Error");
//        @dump(mb_convert_variables(mb_internal_encoding(), "Windows-1251", $string));
//        dump("string after = ".$string);
//    }
//    
//    dump($string);
    foreach ($charSetArr as $charSet){
        if (checkEncoding($string, $charSet)){
            return $charSet;
        }
    
    }
    return false;
    
}


function checkEncoding ( $string, $string_encoding )
{
    $str = $string;
    if($string_encoding != 'UTF-8' && $string_encoding != 'UTF-32'){        
        
        $str1 = mb_convert_encoding ( $str,'UTF-8',$string_encoding );//$string_encoding->utf8
        
        $str2 = mb_convert_encoding ( $str, 'UTF-32', $string_encoding );//$string_encoding->utf32
        //dump(iconv($fs, "UTF-8"."//IGNORE", $string));
        
        
        $str3 = mb_convert_encoding ( $str2, 'UTF-8','UTF-32');//utf32->utf8
        
        //$str2 = mb_convert_encoding ( $str, 'UTF-8', $fs );
        //dump($str);
        return $str1 === $str3;
    }
    return $string === mb_convert_encoding ( mb_convert_encoding ( $string, 'UTF-32', 'UTF-8' ), 'UTF-8', 'UTF-32' );
}

function detectEncoding($string)
{
    $arr_encodings = [
        'CP1251',
        'UCS-2LE',
        'UCS-2BE',
        'UTF-8',
        'UTF-16',
        'UTF-16BE',
        'UTF-16LE',
        'CP866',
    ];
    
    $res = false;
    foreach($arr_encodings as $encoding){
        if (checkEncoding($string, $encoding)){
            return $res=$encoding;
        }
        
    }
   
    return $res;
}

/*
 * Получает заголовок страницы по ее url и преобразует его в ссылку
 */
function titleAsLink($strUrl){
    $title = getTitle(getHTML($strUrl));
    if($title == '') $title = $strUrl;
    return "<a href = '$strUrl' class='hover:text-blue-800'>$title</a>";
}

function getCharset($htmlPage){
    $charset = false;
    
    if (strlen($htmlPage)){
        
        //находим вхождение строки charset
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

