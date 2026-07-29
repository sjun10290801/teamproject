<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>채팅방</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">

                <h2 class="text-center mb-4">
                    채팅
                </h2>
                <div class="card">

                    <!-- 채팅방 상단 -->
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="chat_list.html" class="btn btn-sm btn-outline-secondary">
                                목록
                            </a>

                            <strong>허유정</strong>

                            <span style="width: 12px;"></span>
                        </div>
                    </div>
                    <div class="border-bottom p-3">
                        <div class="d-flex align-items-center">
                            <img src="images/default_profile.jpg" alt="상품 이미지" class="rounded object-fit-cover me-3"
                                style="width: 60px; height: 60px;">

                            <div>
                                <p class="mb-1 fw-semibold">로지텍 G903 무선 게이밍 마우스 LIGHTSPEED</p>
                                <p class="mb-0">179,000원</p>
                            </div>
                        </div>
                    </div>
                    <!-- 메시지가 보이는 부분 -->
                    <div class="card-body" style="min-height: 300px;">

                        <!-- 상대방 메시지 -->
                        <div class="d-flex justify-content-start align-items-center mb-3">
                            <div class="border rounded p-2">
                                안녕하세요!
                            </div>

                            <small class="text-secondary ms-2">
                                오후 3:20
                            </small>
                        </div>

                        <!-- 내 메시지 -->
                        <div class="d-flex justify-content-end align-items-center">
                            <small class="text-secondary me-2">
                                오후 3:20
                            </small>

                            <div class="border rounded p-2 bg-secondary text-white">
                                네 반갑습니다.
                            </div>
                        </div>

                    </div>

                    <!-- 메시지 입력 -->
                    <div class="card-footer">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="메시지를 입력해주세요." aria-label="메시지 입력">

                            <button class="btn btn-outline-secondary" type="button">
                                전송
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>