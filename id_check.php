<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <script>
        function Submit(v) {
            opener.form2.check.value = v;
            self.close();
        }
    </script>
    <?php
    include "common.php";

    $uid = $_GET["uid"]; // get 방식으로 uid 받기

    $sql = "select * from member where id = '$uid'"; // 중복되는 id가 있는지 확인
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    if($row = mysqli_fetch_assoc($result)) {
        echo("$uid 는 이미 사용중입니다."."<br>");
        echo("<a href='javascript:Submit(0)' class='btn btn-sm btn-dark text-white myfont'>확인</a>");
    } else {
        echo("$uid 는 사용가능한 아이디입니다."."<br>");
        echo("<a href='javascript:Submit(1)' class='btn btn-sm btn-dark text-white myfont'>확인</a>"); 
    }

?>
</body>
</html>



<body>