<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include "main_top.php";
    include "common.php";

    if(!isset($_COOKIE["cookie_id"])) {
            echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
            echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
            exit();
        }

    $member_id = $_GET["my_id"];
    $target_id = $_GET["target_id"];
    $product_id = $_GET["product_id"];

    // 상대방과 자신의 문자열 아이디 조회
    $sql = "select member_id, id from member where member_id = $member_id or member_id = $target_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    while($row = mysqli_fetch_assoc($result)) {
        if($row["member_id"] == $member_id) $my_id = $row["id"];
        else $target = $row["id"];
    }
    
    $cookie_id = $_COOKIE["cookie_id"];


    // 다른 사람의 채팅방 접근 방지
    if($cookie_id != $my_id) {
        echo("<script>alert('본인만 접근할 수 있습니다.');</script>");
        echo("<script>location.href='index.html'</script>");
    }

    // 확인한 채팅의 상태는 1(읽음)으로 표시
    $sql = "update chat set state = 1 where (to_member_id = $member_id and from_member_id = $target_id) 
            and product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    // 상품 이름, 사진, 가격 조회
    $sql = "select name, image, price from product where product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    $product_name = $row["name"];
    $product_image = $row["image"];
    $product_price = $row["price"];
    
    // 채팅 내용을 가져옴
    $sql = "select from_member_id, text, reg_date, image, state from chat 
            where ((to_member_id = $member_id and from_member_id = $target_id) or (from_member_id = $member_id and to_member_id = $target_id)) 
            and product_id = $product_id order by reg_date, chat_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    echo("<script>form2.text.focus();</script>"); // 채팅 입력 창으로 이동
?>
<script>
    function Submit() { // 사진도, 메시지 내용도 없는 경우 입력이 안되도록 함.
        if(!form2.text.value && !form2.image.value) {
            alert("메시지를 입력해 주세요");
            form2.text.focus();
            return;
        }

        form2.submit();
    }
</script>
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
                            <a href="chat_list.php" class="btn btn-sm btn-outline-secondary">
                                목록
                            </a>

                            <strong><?php echo $target;?></strong>

                            <span style="width: 12px;"></span>
                        </div>
                    </div>
                    <div class="border-bottom p-3">
                        <div class="d-flex align-items-center">
                            <img src="product/<?php echo $product_image?>" alt="상품 이미지" class="rounded object-fit-cover me-3"
                                style="width: 60px; height: 60px;">

                            <div>
                                <p class="mb-1 fw-semibold"><?php echo $product_name?></p>
                                <p class="mb-0"><?php echo number_format($product_price)?>원</p>
                            </div>
                        </div>
                    </div>
                    <!-- 메시지가 보이는 부분 -->
                    <div class="card-body" style="min-height: 300px;">
                    <?php
                        while($row = mysqli_fetch_assoc($result)) {
                            $ampm = date("A", strtotime($row["reg_date"])) == "AM" ? "오전" : "오후";
                            if($row["from_member_id"] == $target_id) {
                                
                    ?>
                                <!-- 상대방 메시지 -->
                                <div class="d-flex justify-content-start align-items-center mb-3">
                                
                                <?php if($row["image"]) { // 이미지 있으면 이미지 전송 ?>
                                        <div class="border rounded p-2">
                                            <img src="chat/<?php echo $row["image"]?>" alt="채팅 이미지" class="rounded object-fit-cover me-3"
                                            style="width: 180px; height: 240px;">
                                        </div>
                                <?php } ?>

                                <?php if($row["text"]) { // 문자 내용이 없으면 출력X ?>
                                        <div class="border rounded p-2">
                                            <?php echo $row["text"];?>
                                        </div>
                                <?php } ?>

                                    <small class="text-secondary ms-2">
                                        <?php echo $ampm." ".date("h:i", strtotime($row["reg_date"])); // 오후 1:30 형식으로 출력?>
                                    </small>
                                </div>
                            <?php
                            } else {
                            ?>

                                <!-- 내 메시지 -->
                                <div class="d-flex justify-content-end align-items-center">
                                    <small class="text-secondary me-2">
                                        <?php echo $ampm." ".date("h:i", strtotime($row["reg_date"]));?>
                                    </small>

                                    <?php if($row["state"] == 0) { // 읽지 않은 메시지 1로 표시?>
                                        <span class="badge text-bg-primary rounded-pill">1</span>
                                    <?php } ?>

                                    <?php if($row["image"]) { // 이미지 있으면 이미지 전송 ?>
                                            <div class="border rounded p-2">
                                                <img src="chat/<?php echo $row["image"]?>" alt="채팅 이미지" class="rounded object-fit-cover me-3"
                                                style="width: 180px; height: 240px;">
                                            </div>
                                    <?php } ?>

                                    <?php if($row["text"]) { // 문자 내용이 없으면 출력X ?>
                                    <div class="border rounded p-2 bg-secondary text-white">
                                        <?php echo $row["text"];?>
                                    </div>
                                    <?php } ?>

                                </div>
                        <?php } ?>
                    <?php } ?>
                    </div>
                    
                    <form method="post" action="chat_insert.php" enctype="multipart/form-data" name="form2">
                        <!-- 메시지 입력 -->
                        <div class="card-footer">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="메시지를 입력해주세요." aria-label="메시지 입력" name="text">
                                <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
                                <a href="javascript:Submit();" class="btn btn-sm btn-dark text-white myfont">전송</a>
                            </div>
                            <input type="hidden" name="to_member_id" value="<?php echo $target_id;?>">
                            <input type="hidden" name="from_member_id" value="<?php echo $member_id;?>">
                            <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                        </div>
                    </form>
                </div>
                <a>※ 이미지(jpg, png, jpeg)만 전송 가능합니다.</a>
            </div>
        </div>
    </div>
<?php
    include "main_bottom.php"
?>