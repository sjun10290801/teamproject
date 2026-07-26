<?php
    include "common.php";


    // post로 넘겨준 데이터 받기
    $id = $_POST["id"];
    $pwd = $_POST["pwd"];
    $name = trim($_POST["name"]);
    $tel1 = trim($_POST["tel1"]);
    $tel2 = trim($_POST["tel2"]);
    $tel3 = trim($_POST["tel3"]);
    $email = trim($_POST["email"]);
    $birthday = trim($_POST["birthday"]);
    $juso = trim($_POST["juso"]);
    $juso3 = trim($_POST["juso3"]);
    $bank_name = $a_bank[$_POST["bank_name"]];
    $bank_num = trim($_POST["bank_num"]);

    [$juso1, $juso2] = explode(" ", $juso, 2); // 주소를 시/도,  시/군/구 나누어서 저장

    $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3); // 전화번호 01012345678형식으로 합치기

    $sql = "insert into member(id, password, tel, bank_name, bank_num, name, birthday, email, juso1, juso2, juso3)
    values('$id', '$pwd', '$tel', '$bank_name', '$bank_num', '$name', '$birthday', '$email', '$juso1', '$juso2', '$juso3')";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    header("Location:member_joinend.html");
    exit();
?>