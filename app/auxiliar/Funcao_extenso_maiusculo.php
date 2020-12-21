<?
/*Não tem você tem que usar essa função acima mas vc pode usar o para formatar as funções:*/
strtoupper() - //Converte uma string para maiúsculas
ucfirst() - //Converte para maiúscula o primeiro caractere de uma string
ucwords() - //Converte para maiúsculas o primeiro caractere de cada palavra
//mb_strtolower() - Make a string lowercase 

function extenso($valor = 0, $maiusculas = false) {
if(!$maiusculas){
$singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
$plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
$u = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
}else{
$singular = ["CENTAVO", "REAL", "MIL", "MILHÃO", "BILHÃO", "TRILHÃO", "QUADRILHÃO"];
$plural = ["CENTAVOS", "REAIS", "MIL", "MILHÕES", "BILHÕES", "TRILHÕES", "QUADRILHÕES"];
$u = ["", "um", "dois", "TRÊS", "quatro", "cinco", "seis", "sete", "oito", "nove"];
}

$c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
$d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
$d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];

$z = 0;
$rt = "";

$valor = number_format($valor, 2, ".", ".");
$inteiro = explode(".", $valor);
for($i=0;$i 0 ? 1 : 2);
for ($i=0;$i 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd &&
$ru) ? " e " : "").$ru;
$t = count($inteiro)-1-$i;
$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
if ($valor == "000")$z++; elseif ($z > 0) $z--;
if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
}

if(!$maiusculas){
$return = $rt ? $rt : "zero";
} else {
if ($rt) $rt = ereg_replace(" E "," e ",ucwords($rt));
$return = ($rt) ? ($rt) : "Zero" ;
}

if(!$maiusculas){
return ereg_replace(" E "," e ",ucwords($return));
}else{
return strtoupper($return);
}
}

$valor = 405.63;
$dim = extenso($valor);

$valor = number_format($valor, 2, ",", ".");

echo "R$ ".$valor." = ".$dim;
?>