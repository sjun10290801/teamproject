<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include "main_top.php";
include_once "common.php";

loginCheck();

$member_id = $_GET["my_id"];
$target_id = $_GET["target_id"];
$product_id = $_GET["product_id"];

$my_id = getId();

// 타인 접근 방지
if ($my_id != $member_id) {
    echo ("<script>alert('본인만 접근할 수 있습니다.');</script>");
    echo ("<script>location.href='index.html'</script>");
    exit();
}

// 상대방과 자신의 문자열 아이디 조회
$sql = "select member_id, id from member where member_id = $target_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

// 상대방의 문자열 id 조회 -> 채팅방 제목 출력 용
$row = mysqli_fetch_assoc($result);
$target = $row["id"];

// 확인한 채팅의 상태는 1(읽음)으로 표시
$sql = "update chat set state = 1 where (to_member_id = $member_id and from_member_id = $target_id) 
            and product_id = $product_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

// 상품 이름, 사진, 가격 조회
$sql = "select name, image, price from product where product_id = $product_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

$row = mysqli_fetch_assoc($result);

$product_name = $row["name"];
$product_image = $row["image"];
$product_price = $row["price"];

// 채팅 내용을 가져옴
$sql = "select from_member_id, text, reg_date, image, state from chat 
            where ((to_member_id = $member_id and from_member_id = $target_id) or (from_member_id = $member_id and to_member_id = $target_id)) 
            and product_id = $product_id order by reg_date, chat_id";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");
?>
<script>
    function Submit() { // 사진도, 메시지 내용도 없는 경우 입력이 안되도록 함.
        if (!form2.text.value && !form2.image.value) {
            alert("메시지를 입력해 주세요");
            form2.text.focus();
            return;
        }

        form2.submit();
    }

    window.onload = function() { // 창 싨행시 바로 실행되는 함수
        form2.text.focus();
    }
</script>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">

            <h2 class="text-center fw-bold mb-5">
                채팅
            </h2>
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div style="height: 6px; background-color: #18766d;"></div>

                <!-- 채팅방 상단 -->
                <div class="card-header bg-white border-0 px-4 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="chat_list.php" class="btn btn-sm rounded-pill px-3" style="color: #18766d; background-color: #eef8f6; border: 1px solid #b7ddd8;">
                            <i class="bi bi-chevron-left me-1"></i>
                            목록
                        </a>

                        <strong class="fs-5"><?php echo $target; ?></strong>

                        <span style="width: 49px;"></span>
                    </div>
                </div>
                <div class="border-top border-bottom bg-white px-4 py-3">
                    <div class="d-flex align-items-center">
                        <img src="product/<?php echo $product_image ?>" alt="상품 이미지" class="rounded object-fit-cover me-3"
                            style="width: 70px; height: 70px;">

                        <div>
                            <p class="mb-1 fw-bold"><?php echo $product_name ?></p>
                            <p class="mb-0 fw-semibold" style="color: #18766d;"><?php echo number_format($product_price) ?>원</p>
                        </div>
                    </div>
                </div>
                <!-- 메시지가 보이는 부분 -->
                <div class="card-body overflow-auto p-4" style="height: 450px; background-color: #f3f9f8;">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $ampm = date("A", strtotime($row["reg_date"])) == "AM" ? "오전" : "오후";
                        if ($row["from_member_id"] == $target_id) {

                    ?>

                            <!-- 상대방 메시지 -->
                            <div class="d-flex justify-content-start align-items-end mb-3">

                                <div class="d-flex flex-column gap-2">

                                    <?php if ($row["image"]) { // 이미지 있으면 이미지 전송 
                                    ?>
                                        <div class="border-0 rounded-3 bg-white shadow-sm p-2">
                                            <img src="chat/<?php echo $row["image"] ?>" alt="채팅 이미지" class="rounded object-fit-cover"
                                                style="width: 180px; height: 240px;">
                                        </div>
                                    <?php } ?>

                                    <?php if ($row["text"]) { // 문자 내용이 없으면 출력X 
                                    ?>
                                        <div class="border-0 rounded-3 bg-white shadow-sm px-3 py-2" style="max-width: 420px; word-break: break-word;">
                                            <?php echo $row["text"]; ?>
                                        </div>
                                    <?php } ?>

                                </div>

                                <small class="text-secondary ms-2">
                                    <?php echo $ampm . " " . date("h:i", strtotime($row["reg_date"])); // 오후 1:30 형식으로 출력
                                    ?>
                                </small>
                            </div>
                        <?php
                        } else {
                        ?>

                            <!-- 내 메시지 -->
                            <div class="d-flex justify-content-end align-items-end mb-3">
                                <div class="d-flex flex-column align-items-end gap-2 ms-2">

                                    <?php if ($row["image"]) { // 이미지 있으면 이미지 전송 
                                    ?>
                                        <div class="border-0 rounded-3 bg-white shadow-sm p-2">
                                            <img src="chat/<?php echo $row["image"] ?>" alt="채팅 이미지" class="rounded object-fit-cover "
                                                style="width: 180px; height: 240px;">
                                        </div>
                                    <?php } ?>

                                    <div class="d-flex justify-content-end align-items-center gap-1">
                                        <small class="text-secondary me-2">
                                            <?php echo $ampm . " " . date("h:i", strtotime($row["reg_date"])); ?>
                                        </small>

                                        <?php if ($row["state"] == 0) { // 읽지 않은 메시지 1로 표시
                                        ?>
                                            <span class="badge rounded-pill" style="background-color: #18766d;">1</span>
                                        <?php } ?>

                                        <?php if ($row["text"]) { // 문자 내용이 없으면 출력X 
                                        ?>
                                            <div class="border-0 rounded-3 shadow-sm px-3 py-2 text-white" style="max-width: 420px; word-break: break-word; background-color: #18766d;">
                                                <?php echo $row["text"]; ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>


                <form method="post" action="chat_insert.php" enctype="multipart/form-data" name="form2">
                    <!-- 메시지 입력 -->
                    <div class="card-footer bg-white p-3">
                        <div class="d-flex align-items-center gap-2">
                            <input class="form-control" type="file" id="formFileMultiple" multiple name="image" style="max-width: 220px;">

                            <div class="input-group flex-grow-1">
                                <input type="text" class="form-control py-2" placeholder="메시지를 입력해주세요." aria-label="메시지 입력" name="text">
                                <a href="javascript:Submit();" class="btn text-white" style="background-color: #18766d;">전송</a>
                            </div>
                        </div>
                        <input type="hidden" name="to_member_id" value="<?php echo $target_id; ?>">
                        <input type="hidden" name="from_member_id" value="<?php echo $member_id; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    </div>
                </form>
            </div>
            <p class="small text-secondary mt-2 mb-0">※ 이미지(jpg, png, jpeg)만 전송 가능합니다.</p>
        </div>
    </div>
</div>
<?php
include "main_bottom.php"
?>