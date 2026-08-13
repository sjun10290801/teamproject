<?php
    include "../common.php";

    adminCheck();

    $text = $_POST["text"] ?? "";
    $sel = $_POST["sel"] ?? 1;

    if($sel == 1) {
        $tmp = "where from_member_id like '%$text%'";
    } else {
        $tmp = "where to_member_id like '%$text%'";;
    }
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<div class="container-fluid mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold">관리자-신고관리</h2>
    <ul class="nav nav-pills">
    <li class="nav-item">
    <a class="nav-link active bg-danger" aria-current="page" href="admin_member.php">회원관리</a>
  </li>
</ul>
</div>
</div>

<form class="d-flex mt-3" action="admin_report.php" role="search" style="max-width: 300px;" method="post" name="form2">
<div class="d-flex align-items-center gap-2">
<select class="form-select w-auto" aria-label="Default select example" name="sel">
    <?php
        if($sel == 1) {
    ?>
    <option value="1" selected>신고자</option>
    <option value="2">피신고자</option>
    <?php } else { ?>
    <option value="1">신고자</option>
    <option value="2" selected>피신고자</option>
    <?php } ?>
  </select>
  
    <input class="form-control me-2" type="search" placeholder="아이디" aria-label="Search" name="text" value="<?php echo $text;?>">
    <button class="btn btn-danger text-nowrap" type="submit">검색</button>
</form>
</div>
</div>


<div class="table">
    <table class="table table-hover table-bordered text-center align-middle">
        <thead>
            <tr class="table-danger">
                <th scope="col">신고번호</th>
                <th scope="col">신고자 아이디</th>
                <th scope="col">피신고자 아이디</th>
                <th scope="col">신고사유</th>
                <th scope="col">관련사진</th>
                <th scope="col">관리</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $page_line = 10; //페이지당 회원 10명만 표시(페이지네이션)
        $args = "text=$text&sel=$sel";

        $sql = "select m1.id as target, m2.id as id, r.report_id, r.to_member_id, r.reason, r.image, m1.status from report r inner join member m1 on
                r.to_member_id = m1.member_id inner join member m2 on r.from_member_id = m2.member_id $tmp and m1.status = 0";
        $result = mypagination($sql, $args, $count, $pagebar);
        if(!$result) exit("에러 : $sql");

        while($row = mysqli_fetch_assoc($result)) {
            $image = $row["image"] ?: "default.jpg"
        ?>
            <tr>
                <th scope="row"><?php echo $row["report_id"];?></th>
                <td><?php echo $row["id"];?></td>
                <td><?php echo $row["target"];?></td>
                <td><?php echo $a_report[$row["reason"]];?></td>
                <td>
                <img src="report/<?php echo $image;?>" alt="사진" class="img-thumbnail object-fit-cover" style="width: 50px; height: 50px;" data-bs-toggle="modal" data-bs-target="#imageModal">
                </td>
                <td>
                    <div class="btn-group" role="group">
                        <a href="report_delete.php?id=<?php echo $row["report_id"];?>&<?php echo $args;?>" class="btn btn-sm btn-dark text-white myfont">반려</a>
                        <a href="report_insert.php?id=<?php echo $row["to_member_id"];?>&<?php echo $args;?>&reason=<?php echo $row["reason"];?>" class="btn btn-sm btn-danger text-white myfont">제재</a>
                    </div>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php echo $pagebar;?>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">관련사진 상세보기</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImageTarget" src="" class="img-fluid" alt="확대 사진">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const imageModal = document.getElementById('imageModal');
    if (imageModal) {
        imageModal.addEventListener('show.bs.modal', function (event) {
            const triggerImg = event.relatedTarget;
            const src = triggerImg.getAttribute('src');
            const modalImg = imageModal.querySelector('#modalImageTarget');
            modalImg.setAttribute('src', src);
        });
    }
</script>