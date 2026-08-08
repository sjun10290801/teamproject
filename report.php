<?php
include "common.php";
include "main_top.php";
?>

<div class="container py-5">
    <h2 class="text-center mb-4">신고하기</h2>

    <form name="form2" method="post" action="" enctype="multipart/form-data">
        <div class="card border-danger mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header bg-transparent border-danger fw-bold">신고 정보 작성</div>

            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="target_member" class="form-label fw-bold">신고 대상</label>
                    <input type="text" name="target_member" id="target_member" class="form-control" placeholder="신고할 회원 아이디" required>
                </div>
                <div class="mb-3">
                    <label for="report_reason" class="form-label fw-bold">신고 사유</label>
                    <select name="reason" id="report_reason" class="form-select" required>
                        <option  value="" selected>신고 사유</option>
                            <option value="1">사기</option>
                            <option value="2">욕설·위협</option>
                            <option value="3">거래 약속 불이행</option>
                            <option value="4">반복적인 광고·도배</option>
                            <option value="5">타인 사칭</option>
                            <option value="6">개인정보 침해</option>
                            <option value="7">부적절한 프로필·게시물</option>
                            <option value="8">기타</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="report_detail" class="form-label fw-bold">상세 내용</label>
                    <textarea name="detail" id="report_detail" class="form-control" rows="5" placeholder="신고 내용을 자세히 입력해주세요." required></textarea>
                </div>

                <div>
                    <label for="report_image" class="form-label fw-bold">증거 이미지</label>
                    <input type="file" name="report_image" id="report_image" class="form-control" accept="image/png, image/jpeg">
                    <div class="form-text">증거 이미지가 있다면 첨부해주세요.</div>
                </div>
            </div>

            <div class="card-footer bg-transparent border-danger">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="history.back()">취소</button>
                    <button type="submit" class="btn btn-danger flex-fill fw-bold">신고 접수</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include "main_bottom.php";
?>