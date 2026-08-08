<?php
include "common.php";
include "main_top.php";
?>

<div class="container py-5">
    <h2 class="text-center mb-4">거래 평가</h2>

    <form name="form2" method="post" action="">
        <div class="card mx-auto shadow-sm" style="max-width: 600px;">
            <div class="card-header bg-transparent fw-bold">별점 등록</div>

            <div class="card-body p-4">
                <!-- 평가 대상 -->
                <div class="mb-3">
                    <label for="target_member" class="form-label fw-bold">평가 대상</label>
                    <input type="text" name="target_member" id="target_member" class="form-control" value="test111" readonly>
                </div>

                <!-- 거래 상품 -->
                <div class="mb-4">
                    <label for="product_name" class="form-label fw-bold">거래 상품</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="테스트 상품" readonly>
                </div>

                <!-- 별점 -->
                <div class="mb-4">
                    <label class="form-label fw-bold">별점</label>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating5" value="5" class="form-check-input" required>
                        <label for="rating5" class="form-check-label text-warning">★★★★★ <span class="text-dark">5점</span></label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating4" value="4" class="form-check-input">
                        <label for="rating4" class="form-check-label text-warning">★★★★☆ <span class="text-dark">4점</span></label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating3" value="3" class="form-check-input">
                        <label for="rating3" class="form-check-label text-warning">★★★☆☆ <span class="text-dark">3점</span></label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="radio" name="rating" id="rating2" value="2" class="form-check-input">
                        <label for="rating2" class="form-check-label text-warning">★★☆☆☆ <span class="text-dark">2점</span></label>
                    </div>

                    <div class="form-check">
                        <input type="radio" name="rating" id="rating1" value="1" class="form-check-input">
                        <label for="rating1" class="form-check-label text-warning">★☆☆☆☆ <span class="text-dark">1점</span></label>
                    </div>
                </div>

                <!-- 거래 후기 -->
                <div>
                    <label for="rating_detail" class="form-label fw-bold">거래 후기</label>
                    <textarea name="detail" id="rating_detail" class="form-control" rows="4" placeholder="거래 후기를 입력해주세요."></textarea>
                </div>
            </div>

            <div class="card-footer bg-transparent">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-fill" onclick="history.back()">취소</button>
                    <button type="submit" class="btn btn-dark flex-fill">평가 등록</button>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
include "main_bottom.php";
?>