<?php

    include "common.php";

    // 이전 파일에서 보낸 정보 받기
    $id = $_COOKIE["cookie_id"];
    $member_id = $_POST["member_id"];
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

    // 데이터 입력 검증
    if(!$name || !$tel1 || !$tel2 || !$tel3 || !$email || !$birthday || !$juso || !$juso3 || !$bank_name ||!$bank_num) {
        echo("<script>alert('올바른 정보를 입력해주세요');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    // 비밀번호 일치 확인
    if(($pwd )&& ($pwd != $_POST["pwd1"])) {
        echo("<script>alert('비밀번호가 일치하지 않습니다.');</script>");
        echo("<script>history.back();</script>");
        exit();
    }

    mysqli_begin_transaction($db);

    // 이미지 수정
    $fname=$_POST["image_name"];
    
    // 상품 등록의 이미지 저장 구대로 구현
    $filename = $_FILES["image"]["name"]; // 이미지 이름
    if($filename) {
        $tmp = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // strtolower => 영어 소문자로 변경하는 함수
        // pathinfo(경로, PATHINFO_EXTENSION) => 파일의 확장자만 추출하기 위한 함수

        switch($tmp) { // 확장자가 이미지가 아니면 종료
            case "png": case "jpg": case "jpeg":
                break;
            default:
                echo("이미지(png, jpg, jpeg) 파일만 업로드 가능합니다.");
                mysqli_rollback($db);
                exit();
        }
    


        
        if($_FILES["image"]["error"] == 0)
        {
            $newname = "member".$member_id.".".$tmp;
            if(!move_uploaded_file($_FILES["image"]["tmp_name"],"images/$newname")) { // 업로드
                mysqli_rollback($db);
                echo("<script>alert('오류가 발생했습니다.');</script>");
                echo("<script>window.history.back();</script>");
                exit();
            }
            if($fname != $newname && file_exists("images/".$fname)) {
                unlink("images/".$fname); // 파일 삭제
            }

            $new_image = $newname;
        }
    }

    else if($fname && $_POST["check"] == 1) { // 원래파일이 존재 하며 파일삭제 체크박스 체크 시
        if(file_exists("images/".$fname))
        unlink("images/".$fname); // 파일 삭제
        $new_image = NULL;
    } else {
        $new_image = $fname;
    }

    // 업데이트 sql 구문
    if(!$pwd) {
        $sql = "update member set name = '$name', tel = '$tel', email = '$email', birthday = '$birthday', juso1 = '$juso1'
                , juso2 = '$juso2', juso3 = '$juso3', bank_name = '$bank_name', bank_num = '$bank_num', image = '$new_image' where id = '$id'";
    } else {
        $password = password_hash($pwd, PASSWORD_DEFAULT);
        $sql = "update member set password = '$password', name = '$name', tel = '$tel', email = '$email', birthday = '$birthday', juso1 = '$juso1'
                , juso2 = '$juso2', juso3 = '$juso3', bank_name = '$bank_name', bank_num = '$bank_num', image = '$new_image' where id = '$id'";
    }
    $result = mysqli_query($db, $sql);
    if(!$result) {
        mysqli_rollback($db);
        echo("<script>alert('오류가 발생했습니다.');</script>");
        echo("<script>window.history.back();</script>");
        exit();
    }

    mysqli_commit($db);

    echo("<script>alert('수정이 완료되었습니다.');</script>");
    echo("<script>location.href='member_edit.php'</script>");
?>