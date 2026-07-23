<?php
    include "common.php";

    $uid = $_GET["uid"]; // get 방식으로 uid 받기

    $sql = "select * from member where id = '$uid'"; // 중복되는 id가 있는지 확인
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    if($row = mysqli_fetch_assoc($result)) {
        
    }

?>