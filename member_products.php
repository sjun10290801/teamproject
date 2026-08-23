<?php
include "main_top.php";
?>

<main class="container py-5">
    <div class="mx-auto" style="max-width: 1000px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">판매 중인 상품</h2>
                <p class="text-secondary mb-0">내가 등록한 상품을 확인할 수 있습니다.</p>
            </div>

            <a href="member_mypage.php" class="btn text-white rounded-pill px-3"
                style="background-color: #18766d;">
                마이페이지
            </a>
        </div>

        <!-- 백엔드 연결 시 아래 상품 카드를 반복 출력 -->
        <div class="row g-4">
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <img src="product/default.jpg" class="card-img-top object-fit-cover"
                            style="height: 190px;" alt="상품 이미지">

                        <div class="card-body">
                            <span class="badge rounded-pill mb-2" style="background-color: #18766d;">판매 중</span>
                            <h5 class="card-title fw-semibold">테스트 상품</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text fw-bold mb-0" style="color: #18766d;">30,000원</p>
                                <a href="#" class="btn btn-sm rounded-pill px-3"
                                    style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">상품 수정</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <img src="product/default.jpg" class="card-img-top object-fit-cover"
                            style="height: 190px;" alt="상품 이미지">

                        <div class="card-body">
                            <span class="badge rounded-pill mb-2" style="background-color: #18766d;">판매 중</span>
                            <h5 class="card-title fw-semibold">테스트 상품 2</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text fw-bold mb-0" style="color: #18766d;">50,000원</p>
                                <a href="#" class="btn btn-sm rounded-pill px-3"
                                    style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">상품 수정</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="text-dark">
                    <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                        <img src="product/default.jpg" class="card-img-top object-fit-cover"
                            style="height: 190px;" alt="상품 이미지">

                        <div class="card-body">
                            <span class="badge rounded-pill mb-2" style="background-color: #18766d;">판매 중</span>
                            <h5 class="card-title fw-semibold">테스트 상품 3</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text fw-bold mb-0" style="color: #18766d;">20,000원</p>
                                <a href="#" class="btn btn-sm rounded-pill px-3"
                                    style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">상품 수정</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
include "main_bottom.php";
?>
