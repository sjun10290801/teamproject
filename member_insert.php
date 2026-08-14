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

    // 아이디 중복확인 검증
    if($_POST["check"] == 0) {
        echo("<script>alert('아이디 중복 확인을 해주세요');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    // 데이터 입력 검증
    if(!$name || !$tel1 || !$tel2 || !$tel3 || !$email || !$birthday || !$juso || !$juso3 || !$bank_name ||!$bank_num || !$id || !$pwd) {
        echo("<script>alert('올바른 정보를 입력해주세요');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    // 비밀번호 일치 확인
    if($pwd != $_POST["pwd1"]) {
        echo("<script>alert('비밀번호가 일치하지 않습니다.');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    [$juso1, $juso2] = explode(" ", $juso, 2); // 주소를 시/도,  시/군/구 나누어서 저장

    $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3); // 전화번호 01012345678형식으로 합치기

    //프로필 사진 업로드
    $filename = $_FILES["image"]["name"]; // 이미지 이름

    mysqli_begin_transaction($db);

    if($filename) {
    $fname = imageUpload("member", "images", "member");
    
    if(!$fname) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    } else {
        $fname = "";
    }

    $sql = "insert into member(id, password, tel, bank_name, bank_num, name, birthday, email, juso1, juso2, juso3, image)
    values('$id', '$pwd', '$tel', '$bank_name', '$bank_num', '$name', '$birthday', '$email', '$juso1', '$juso2', '$juso3', '$fname')";
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    mysqli_commit($db);

    header("Location:member_joinend.html");
    exit();
?>