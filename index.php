<?php 

session_start();


if(isset($_GET['reset'])){
    $_SESSION['table']=null;
}
$error="";

$box=!empty($_GET['box'])?$_GET['box']:"";

$error.=fncWinLoseDraw("human");

if($error==""){
    $error.=fncWinLoseDraw("computer");
}

if($error==""){
        
    if($box!="" && empty($_SESSION['table'][$box])){
        $_SESSION['table'][$box]="human";
        $error.=fncWinLoseDraw("human");
        
    }elseif(isset($_SESSION['table'][$box])){
        $error.="そのマス目はすでに選択されています。";
    }
}
if($error==""){
    if(isset($_SESSION['table']) && count($_SESSION['table'])>0){
        $_SESSION['table'][fncCompCell()]="computer";
    }
    $error.=fncWinLoseDraw("computer");
}





/*------------------------
以下関数
---------------------------*/


function fncPicShow($cell){
    if(empty($_SESSION['table'][$cell])){
        return "";        
    }else{
        return $_SESSION['table'][$cell];
    }
}//関数末端

function fncCompCell(){
    $aryEmp=array();
    for($i=1;$i<4;$i++){
        for($j=1;$j<4;$j++){
            if(empty($_SESSION['table'][$i.$j])){
                $aryEmp[]=$i.$j;
            }
        }
    }
    shuffle($aryEmp);
    return $aryEmp[0];
}//関数末端


function fncWinLoseDraw($player){
    for($i=1;$i<4;$i++){
        $sum=@$_SESSION['table'][$i."1"].@$_SESSION['table'][$i."2"].@$_SESSION['table'][$i."3"];
        if($sum==$player.$player.$player){
            return $player."が勝利です。";
        }
        $sum=@$_SESSION['table']["1".$i].@$_SESSION['table']["2".$i].@$_SESSION['table']["3".$i];
        if($sum==$player.$player.$player){
            return $player."が勝利です。";
        }
    }
    
    $sum=@$_SESSION['table'][11].@$_SESSION['table'][22].@$_SESSION['table'][33];
    if($sum==$player.$player.$player){
        return $player."が勝利です。";
    }
    
    $sum=@$_SESSION['table'][13].@$_SESSION['table'][22].@$_SESSION['table'][31];
    if($sum==$player.$player.$player){
        return $player."が勝利です。";
    }
    
    $cellcnt=0;
    for($i=1;$i<4;$i++){
        for($j=1;$j<4;$j++){
            if(!empty(@$_SESSION['table'][$i.$j])){
                $cellcnt=$cellcnt+1;
            }
        }
    }
    if($cellcnt==9){
        return "引き分けです。";
    }
    
    return "";
}


?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>三目並べ</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
<pre>
<?=$error." " ?>
<?php //print_r($_SESSION); ?>
</pre>
<table>

    <tr class="odd">
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=11'?>"><div class="box <?=fncPicShow("11")?>"></div></a></td>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=12'?>"><div class="box <?=fncPicShow("12")?>"></div></a></td>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=13'?>"><div class="box <?=fncPicShow("13")?>"></div></a></td>
    </tr>
    <tr class="even">
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=21'?>"><div class="box <?=fncPicShow("21")?>"></div></a></td>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=22'?>"><div class="box <?=fncPicShow("22")?>"></div></a></td>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=23'?>"><div class="box <?=fncPicShow("23")?>"></div></a></td>
    </tr>
    <tr>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=31'?>"><div class="box <?=fncPicShow("31")?>"></div></a></td>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=32'?>"><div class="box <?=fncPicShow("32")?>"></div></a></td>
      <td><a href="<?=$_SERVER['PHP_SELF'].'?box=33'?>"><div class="box <?=fncPicShow("33")?>"></div></a></td>
    </tr>

</table>

<a href="<?=$_SERVER['PHP_SELF'].'?reset=true'?>">リセット</a>



</body>
</html>