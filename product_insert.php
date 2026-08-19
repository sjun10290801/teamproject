<?php
 error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "common.php";
    $category = trim($_POST["category"]);
    $name = trim($_POST["name"]);
    $price = trim($_POST["price"]);
    $text = addslashes(trim($_POST["text"]));
    $juso3 = trim($_POST["juso3"]);
    $juso = trim($_POST["juso"]);

    if(!$category || !$name || !$price || !$text || !$juso3 || !$juso) {
        echo("<script>alert('올바른 정보를 입력해주세요');</script>");
        echo("<script>location.href='admin_login.html'</script>");
        exit();
    }

    if(!is_numeric($price)) {
        echo("<script>alert('가격은 숫자로 입력해주세요');</script>");
        echo("<script>location.href='admin_login.html'</script>");
        exit();
    }

    if($category > $n_category - 1 || $category < 0) {
        echo("<script>alert('올바른 카테고리 정보를 입력해주세요');</script>");
        echo("<script>location.href='admin_login.html'</script>");
        exit();
    }

    [$juso1, $juso2] = explode(" ", $juso, 2);

    $cookie_id = $_COOKIE["cookie_id"];  //로그인 기능 구현 후 추가

    // 이미지 확장자 검사
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
    

    
        // 파일 이름 중복 방지 -> "product" + 제품id
        $sql = "select * from product order by product_id desc"; // 제품 id 내림차순 정렬
        $result = mysqli_query($db, $sql);
        if(!$result) exit("에러 : $sql");

        if($row = mysqli_fetch_assoc($result)) { // 제품이 없다면 제품 id는 1. 제품이 있다면 마지막 제품id + 1
            $product_id = $row["product_id"] + 1;
        } else {
            $product_id = 1;
        }

        $fname = "image".$product_id.".".$tmp;
        if($_FILES["image"]["error"] == 0)
        {
            if(!move_uploaded_file($_FILES["image"]["tmp_name"],"product/$fname")) // 업로드
                exit("업로드 실패");
        }
    }


    $sql = "select * from member where id = '$cookie_id'"; // id에 해당하는 회원번호 찾기
     $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);
    $member_id = $row["member_id"];

    // db 데이터 삽입
    $sql = "insert into product(member_id, image, price, memo, category, view, reg_date, state, juso1, juso2, juso3, name) 
    values($member_id, '$fname', $price, '$text', $category, 0, sysdate(), 0, '$juso1', '$juso2', '$juso3', '$name')";

    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    header("Location:product_create.php");
    exit();
?>