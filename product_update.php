<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "common.php";

    $product_id = $_POST["product_id"];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $juso = $_POST["juso"];
    [$juso1, $juso2] = explode(" ", $juso, 2);
    $juso3 = $_POST["juso3"];
    $memo = addslashes($_POST["text"]);


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
                exit();
        }
    


        
        if($_FILES["image"]["error"] == 0)
        {
            $newname = "image".$product_id.".".$tmp;
            if(!move_uploaded_file($_FILES["image"]["tmp_name"],"product/$newname")) // 업로드
                exit("업로드 실패");
            if(file_exists("product/".$fname)) {
                unlink("product/".$fname); // 파일 삭제
            }

            $new_image = $newname;
        }
    }

    else if($fname && $_POST["check"] == 1) { // 원래파일이 존재 하며 파일삭제 체크박스 체크 시
        if(file_exists("product/".$fname))
        unlink("product/".$fname); // 파일 삭제
        $new_image = NULL;
    } else {
        $new_image = $fname;
    }

    $sql = "update product set category = $category, name = '$name', 
    price = $price, juso1 = '$juso1', juso2 = '$juso2', juso3 = '$juso3', memo = '$memo', image = '$new_image' where product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>alert('수정이 완료되었습니다.');</script>");
    echo("<script>location.href='product_edit.php?id=$product_id'</script>");
    
?>