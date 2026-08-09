<?php

    include "../common.php";
    adminCheck();

    // 이전 파일에서 보낸 정보 받기
    $member_id = $_POST["member_id"];
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


    // 업데이트 sql 구문
    $sql = "update member set name = '$name', tel = '$tel', email = '$email', birthday = '$birthday', juso1 = '$juso1'
            , juso2 = '$juso2', juso3 = '$juso3', bank_name = '$bank_name' where member_id = '$member_id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('수정이 완료되었습니다.');</script>");
    echo("<script>location.href='admin_member.php'</script>");
?>