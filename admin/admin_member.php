<?php
    include "../common.php";

    $text = $_POST["text"] ?? "";

    if($text) {
        $tmp = "where id like '%$text%'";
    } else {
        $tmp = "";
    }

    $page_line = 10; //페이지당 회원 10명만 표시(페이지네이션)

    $args = "text=$text";
    $sql = "select member_id, id, name, tel, email, birthday, juso1, juso2, juso3, bank_name from member $tmp";
    $result = mypagination($sql, $args, $count, $pagebar);
    if(!$result) exit("에러 : $sql");
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="container-fluid mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold">관리자-회원관리</h2>
    <ul class="nav nav-pills">
    <li class="nav-item">
    <a class="nav-link active bg-dark" aria-current="page" href="admin_report.html">신고관리</a>
  </li>
</ui>
</div>
</div>

<form class="d-flex mt-3" action="admin_member.php" role="search" style="max-width: 300px;" method="post" name="form2">
    <input class="form-control me-2" type="search" placeholder="아이디" aria-label="Search" name="text" value="<?php echo $text;?>">
    <button class="btn btn-dark text-nowrap" type="submit">검색</button>
</form>



<div class="table">
    <table class="table table-hover table-bordered text-center align-middle">
        <thead>
            <tr class="table-dark">
                <th scope="col">회원번호</th>
                <th scope="col">아이디</th>
                <th scope="col">이름</th>
                <th scope="col">휴대폰</th>
                <th scope="col">이메일</th>
                <th scope="col">생년월일</th>
                <th scope="col">주소</th>
                <th scope="col">은행</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while($row = mysqli_fetch_assoc($result)) {

            // 전화번호 형식 지정
            $tel1 = substr($row["tel"], 0, 3);
            $tel2 = substr($row["tel"], 3, 4);
            $tel3 = substr($row["tel"], 7, 4);
            $tel = $tel1."-".$tel2."-".$tel3;

            $member_id = $row["member_id"];

        ?>
            <tr>
                <th scope="row"><?php echo $row["member_id"];?></th>
                <td><?php echo $row["id"];?></td>
                <td><?php echo $row["name"];?></td>
                <td><?php echo $tel;?></td>
                <td><?php echo $row["email"];?></td>
                <td><?php echo $row["birthday"];?></td>
                <td><?php echo $row["juso1"]." ".$row["juso2"]." ".$row["juso3"];?></td>
                <td><?php echo $row["bank_name"]."은행";?></td>
                <td>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary" 
                        onclick="location.href='member_edit.php?member_id=<?php echo $member_id;?>'">수정</button>
                        <button type="button" class="btn btn-sm btn-outline-danger"
                        onclick="location.href='member_delete.php?member_id=<?php echo $member_id;?>'">삭제</button>
                    </div>
                </td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
</div>

<?php echo $pagebar; ?>