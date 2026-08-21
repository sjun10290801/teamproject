<?php
include_once "common.php";
loginCheck();

include "main_top.php";



// 본인의 회원 id를 가져오기
$session_id = $_SESSION["id"];
$sql = "select * from member where id = '$session_id'";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

$row = mysqli_fetch_assoc($result);
$member_id = $row["member_id"];

//서브쿼리로 가상의 테이블 제작 ==> 상대방 id, 최근 메시지 시간, 상품id.
// 대상은 같아도 상품별로 채팅을 구성하기 위해 group by target_id, product_id 를 사용
// 서브쿼리를 사용해 마지막 채팅 내용과 안읽은 메시지 수를 가져옴
// 멤버, 상품 테이블을 조인하여 대상의 아이디(이름)와 상품 이름을 가져옴
$sql = "select c.target_id, m.id, c.last_date, p.name, p.product_id, m.image, 
            (select text from chat where ((from_member_id = c.target_id and to_member_id = $member_id) or 
            (to_member_id = c.target_id and from_member_id = $member_id)) and product_id = p.product_id order by reg_date desc, chat_id desc limit 1) as last_text,
            (select count(*) from chat where from_member_id = c.target_id and to_member_id = $member_id
            and product_id = p.product_id) as chat_state
            from (select case when to_member_id = $member_id then from_member_id 
            when from_member_id = $member_id then to_member_id end as target_id, product_id, max(reg_date) as last_date from chat
            group by target_id, product_id) as c inner join member m on c.target_id = m.member_id 
            inner join product p on c.product_id = p.product_id where c.target_id is not null order by c.last_date desc";
$result = mysqli_query($db, $sql);
if (!$result) exit("에러 : $sql");

$count = mysqli_num_rows($result);


?>

<style>


.chat-page {
    background: #f0f6f5;
}


.chat-card {
    background: #ffffff;
    border: 1px solid #e3eeee;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 18px rgba(24, 118, 109, 0.08);
}


.chat-header {
    padding: 24px;
    background: #ffffff;
    border-bottom: 1px solid #edf2f2;
}

.chat-title {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: #222222;
}


.chat-count {
    color: #18766d;
    font-size: 13px;
    font-weight: 600;
}


.chat-item {
    display: block;
    padding: 18px 24px;
    background: #ffffff;
    color: inherit;
    text-decoration: none;
    border-bottom: 1px solid #edf2f2;
    transition: background-color 0.2s ease;
}


.chat-item:last-child {
    border-bottom: none;
}


.chat-item:hover {
    background: #f5fafa;
}


.chat-profile {
    width: 60px;
    height: 60px;
    object-fit: cover;
    flex-shrink: 0;
    border: 2px solid #e3eeee;
}

.chat-name {
    margin: 0;
    color: #222222;
    font-size: 16px;
    font-weight: 700;
}

.chat-item:hover .chat-name {
    color: #18766d;
}

.chat-badge {
    min-width: 22px;
    height: 22px;
    padding: 0 7px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    color: #ffffff;
    background: #18766d;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}


.chat-product {
    margin: 3px 0 4px;
    color: #18766d;
    font-size: 13px;
    font-weight: 600;
}


.chat-message {
    margin: 0;
    color: #777777;
    font-size: 13px;
}


.chat-time {
    color: #999999;
    font-size: 11px;
    white-space: nowrap;
}

</style>


<div class="chat-page">
    <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <section class="chat-card">
                <div class="chat-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="chat-title">채팅방 목록</strong>
                        <span class="chat-count"><?php echo $count; ?>개의 채팅방</span>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $image = $row["image"] ?: "default_profile.jpg";


                        // 시간 차이 계산
                        date_default_timezone_set('Asia/Seoul');
                        $time = $row["last_date"];
                        $diff = (strtotime(date('Y-m-d H:i:s')) - strtotime($time));
                        if ($diff >= 2678400) {
                            $time_text = "1달 이상";
                        } else if ($diff >= 86400) {
                            $time_text = floor($diff / 86400) . "일 전";
                        } else if ($diff >= 3600) {
                            $time_text = floor($diff / 3600) . "시간 전";
                        } else if ($diff >= 60) {
                            $time_text = floor($diff / 60) . "분 전";
                        } else {
                            $time_text = "방금";
                        }

                        // 마지막 메시지가 비어있는 경우, 사진 데이터
                        $last = $row["last_text"] ?: "사진을 보냈습니다.";
                    ?>
                        <a href="chat_room.php?my_id=<?php echo $member_id; ?>&target_id=<?php echo $row['target_id']; ?>&product_id=<?php echo $row['product_id']; ?>"
                            class="chat-item">
                            <div class="d-flex align-items-center gap-3">
                            <!-- 프로필 사진 -->
                            <img src="images/<?php echo $image; ?>" alt="프로필 사진"
                                class="chat-profile rounded-circle">

                            <div class="flex-grow-1" style="min-width: 0;">
                                <!-- 상대방 이름, 메시지 수 -->
                                <div class="d-flex w-100 justify-content-between align-items-center ">
                                    <h5 class="chat-name"><?php echo $row["id"]; ?></h5>
                                    <?php
                                    if ($row["chat_state"] != 0) {
                                    ?>
                                        <span class="chat-badge">
                                            <?php echo $row["chat_state"]; ?>
                                        </span>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <!-- 상품명 -->
                                <p class="chat-product">
                                    <i class="bi bi-box-seam me-1"></i>
                                    <?php echo $row["name"]; ?>
                                </p>

                                <!-- 마지막 메시지, 마지막 시간 -->
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <p class="chat-message text-truncate me-3">
                                        <?php echo $last; ?>
                                    </p>

                                    <small class="chat-time">
                                        <?php echo $time_text; ?>
                                    </small>
                                </div>

                            </div>
                </div>
                </a>
            <?php
                    }
            ?>
        </div>
        </section>
    </div>
</div>
</div>
</div>
<?php
include "main_bottom.php";
?>