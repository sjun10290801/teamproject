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

    if(!$name || !$tel1 || !$tel2 || !$tel3 || !$email || !$birthday || !$juso || !$juso2 || !$bank_name ||!$bank_num) {
        echo("<script>alert('올바른 정보를 입력해주세요');</script>");
        echo("<script>history.back();</script>");
        exit();
    }



    [$juso1, $juso2] = explode(" ", $juso, 2); // 주소를 시/도,  시/군/구 나누어서 저장

    $tel = sprintf("%-3s%-4s%-4s", $tel1, $tel2, $tel3); // 전화번호 01012345678형식으로 합치기

    //프로필 사진 업로드
    $filename = $_FILES["image"]["name"]; // 이미지 이름
    if($filename) {
        $tmp = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // strtolower => 영어 소문자로 변경하는 함수
        // pathinfo(경로, PATHINFO_EXTENSION) => 파일의 확장자만 추출하기 위한 함수

        switch($tmp) { // 확장자가 이미지가 아니면 종료
            case "png": case "jpg": case "jpeg":
                break;
            default:
                echo("이미지(png, jpg, jpeg) 파일만 업로드 가능합니다.");
                exit();
        }
    

    
        // 파일 이름 중복 방지 -> "member" + 멤버id
        $sql = "select * from member order by member_id desc"; // 멤버 id 내림차순 정렬
        $result = mysqli_query($db, $sql);
        if(!$result) exit("에러 : $sql");

        if($row = mysqli_fetch_assoc($result)) { // 멤버가 없다면 멤버 id는 1. 멤버가 있다면 마지막 멤버id + 1
            $member_id = $row["member_id"] + 1;
        } else {
            $member_id = 1;
        }

        $fname = "member".$member_id.".".$tmp;
        if($_FILES["image"]["error"] == 0)
        {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"],"images/$fname")) // 업로드
                exit("업로드 실패");
        }
    }

    $sql = "insert into member(id, password, tel, bank_name, bank_num, name, birthday, email, juso1, juso2, juso3, image)
    values('$id', '$pwd', '$tel', '$bank_name', '$bank_num', '$name', '$birthday', '$email', '$juso1', '$juso2', '$juso3', '$fname')";
    $result = mysqli_query($db, $sql);
    if(!$result) exit('에러:$sql');

    header("Location:member_joinend.html");
    exit();
?>