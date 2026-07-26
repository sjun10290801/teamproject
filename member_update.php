<?php

    include "common.php";

    // 이전 파일에서 보낸 정보 받기
    $id = $_COOKIE["cookie_id"];
    $pwd = $_POST["pwd"];
    $name = trim($_POST["name"]);

    $tel1 = trim($_POST["tel1"]);
    $tel2 = trim($_POST["tel2"]);
    $tel3 = trim($_POST["tel3"]);
    $tel = $tel1.$tel2.$tel3;

    $email = trim($_POST["email"]);
    $birthday = $_POST["birthday"];
    $juso = trim($_POST["juso"]);
    [$juso1, $juso2] = explode(" ", $juso, 2);

    $juso3 = trim($_POST["juso3"]);

    $bank_value = $_POST["bank_name"];
    $bank_name = $a_bank[$bank_value];
    $bank_num = trim($_POST["bank_num"]);


    // 업데이트 sql 구문
    if(!$pwd) {
        $sql = "update member set name = '$name', tel = '$tel', email = '$email', birthday = '$birthday', juso1 = '$juso1'
                , juso2 = '$juso2', juso3 = '$juso3', bank_name = '$bank_name', bank_num = '$bank_num' where id = '$id'";
    } else {
        $sql = "update member set password = '$pwd', name = '$name', tel = '$tel', email = '$email', birthday = '$birthday', juso1 = '$juso1'
                , juso2 = '$juso2', juso3 = '$juso3', bank_name = '$bank_name', bank_num = '$bank_num' where id = '$id'";
    }
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('수정이 완료되었습니다.');</script>");
    echo("<script>location.href='member_edit.php'</script>");
?>