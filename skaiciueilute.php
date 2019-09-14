<?php

$numberline = "";
$growingline = "";
$bigestmul = "";
$whichareprime = "";
$result = "";
$newline = "&#13;&#10;";

if (isset($_POST)) {
if (isset($_POST["numberline"])){
if ($_POST["numberline"] > "") {
    
        $numberline = $_POST["numberline"];
        if (isset($_POST["growingline"])) {
            $growingline = "checked";
            $res1 = check_growingline($numberline);
        } else $res1 = "";
        if (isset($_POST["bigestmul"])) {
            $bigestmul = "checked";
            $res2 = check_bigestmul($numberline);
        } else $res2 = "";
        if (isset($_POST["whichareprime"])) {
            $whichareprime = "checked";
            $res3 = check_whichareprime($numberline);
        } else $res3 = "";

        $result = $res1 . $newline . $newline . $res2 . $newline . $newline . $res3;
}}} 
?>

<html>
<head>
  <title>Skaičių eilutė</title>
</head>
<body>
    <h1>Veiksmai su skaičių eilute</h1>
    <form action="skaiciueilute.php" method="POST">
        <label>Įveskite skaičių eilutę:</label>
        <input type="text" name="numberline" value="<?php echo $numberline ?>"></input>
        <br>    
        <input <?php echo $growingline ?> type="checkbox" name="growingline"></input>
        <label>Skaičiai yra didėjančia tvarka</label>
        <br>
        <input <?php echo $bigestmul ?> type="checkbox" name="bigestmul"></input>
        <label>Didžiausia greta esančių kaimynų sandauga</label>
        <br>
        <input <?php echo $whichareprime ?> type="checkbox" name="whichareprime"></input>
        <label>Kurie skaičiai yra pirminiai, kurie sudėtiniai</label>
        <br>
        <input type="submit" name="checkbut" value="Tikrinti" style="width:100pt"></input>
    </form>
    
    <label>Rezultatas:</label>
    <br>
    <textarea style="width: 250pt;height: 250pt" ><?php echo $result ?>
    
    </textarea>
</body>
</html>

<?php
function check_growingline($line){
    $linearr = explode(",",$line);
    $earl = null;
    $earlearl = null;
    $firstnotgrowing = null;
    $result = "Eilutė yra didėjanti";
    
    foreach($linearr as $dig){
        if ($earl == null){
            $earl = $dig;
            continue;
        }
        if ($earl < $dig ){
            $earlearl = $earl;
            $earl = $dig;
            continue;        
        } else if($earl > $dig && $firstnotgrowing == null) {
            $firstnotgrowing = 1;
            if ($earlearl < $dig){
                $result = "Eilutė yra didėjanti, reikia išmesti $earl";
            } else $result = "Eilutė yra didėjanti, reikia išmesti $dig";
            $earlearl = $earl;
            $earl = $dig;
        } else {
            $result = "Eilutė nėra didėjanti";
            break;
         }    
    }
    return $result;
}

function check_bigestmul($line){
    $linearr = explode(",",$line);
    $earl = null;
    $biggestmul = 0;
    $biggestmulfirst = 0;
    $biggestmulsecond = 0;
    
    foreach($linearr as $dig){
        if ($earl == null){
            $earl = $dig;
            continue;
        }
        if ($earl * $dig > $biggestmul) {
            $biggestmulfirst = $earl;
            $biggestmulsecond = $dig;
            $biggestmul = $earl * $dig;             
        }    
        $earl = $dig;
    }
    $result = "Didžiausia sandauga: $biggestmulfirst x $biggestmulsecond = $biggestmul";
    return $result;
}

function check_whichareprime($line){
    $linearr = explode(",",$line);
    $primes = "";
    $adds = "";
    foreach($linearr as $dig){
        if ($dig == 0) continue;
        if (is_prime($dig) > 0)
            $primes = trim($primes.",".$dig,",");
        else $adds = trim($adds.",".$dig,","); 
    }
      
    $result = "Pirminiai: ".$primes."&#13;&#10;"."Sudėtiniai: ".$adds;
    return $result;
}

function is_prime($number){ 
    if ($number == 0) 
    return 0; 

    if ($number == 1) 
    return 1; 
      
    for ($i = 2; $i <= sqrt($number); $i++){ 
        if ($number % $i == 0) 
            return 0; 
    } 
    return 1; 
} 

?>