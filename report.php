<?php
include_once "common.php";
include "main_top.php";

    loginCheck();

    $target = $_GET["member_id"];

    $sql = "select id from member where member_id = $target";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    $target_name = $row["id"];
?>

<script>
    function Submit() {
        if(report_form.reason.value == 0) {
            alert("사유를 입력해주세요.");
            report_form.reason.focus();
            return;
        }

        report_form.submit();
    }
</script>
<div class="container py-5">
    <h2 class="text-center mb-4">신고하기</h2>

    <form name="report_form" method="post" action="report_insert.php" enctype="multipart/form-data">
        <div class="card border-danger mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header bg-transparent border-danger fw-bold">신고 정보 작성</div>

            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="target_member" class="form-label fw-bold">신고 대상</label>
                    <input type="hidden" name="target" value="<?php echo $target;?>">
                    <a><?php echo $target_name;?></a>
                </div>
                <div class="mb-3">
                    <label for="report_reason" class="form-label fw-bold">신고 사유</label>
                    <select name="reason" id="report_reason" class="form-select" required>
                        <option  value="0" selected>신고 사유</option>
                        <?php for($i = 1; $i < $n_report; $i++) { ?>
                                <option value="<?php echo $i;?>"><?php echo $a_report[$i];;?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="report_detail" class="form-label fw-bold">상세 내용</label>
                    <textarea name="detail" id="report_detail" class="form-control" rows="5" placeholder="신고 내용을 자세히 입력해주세요." required></textarea>
                </div>

                <div>
                    <label for="report_image" class="form-label fw-bold">증거 이미지</label>
                    <input type="file" name="image" id="report_image" class="form-control" accept="image/png, image/jpeg">
                    <div class="form-text">증거 이미지가 있다면 첨부해주세요.</div>
                </div>
            </div>

            <div class="card-footer bg-transparent border-danger">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="history.back()">취소</button>
                    <button onclick="javascript:Submit();" class="btn btn-danger flex-fill fw-bold">신고 접수</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include "main_bottom.php";
?>