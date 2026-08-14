<?php
    include "main_top.php";
    include "common.php";

    loginCheck();

    $product_id = $_GET["product_id"];

    $sql = "select p.image, p.memo, p.price, p.name, m.id, p.member_id from product p inner join member m 
            on p.member_id = m.member_id where product_id = $product_id";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    $product_image = $row["image"] ?: "default.jpg";
    
?>
<script>
    function Submit() {
        if(!pay_form.payment_method.value) {
            alert("결제방법을 선택해주세요.");
            pay_form.payment_method.focus();
            return;
        }

        if(pay_form.payment_method.value == 0 && pay_form.bank_name.value == 0) {
            alert("은행을 선택해주세요.");
            pay_form.bank_name.focus();
            return;
        }

        if(pay_form.payment_method.value == 0 && !pay_form.bank_num.value) {
            alert("카드번호를 입력해주세요.");
            pay_form.bank_name.focus();
            return;
        }

        if(pay_form.payment_method.value == 0 && pay_form.bank_num.value.indexOf('-') != -1) {
                alert("-를 제외하고 입력해주세요.");
                pay_form.bank_num.focus();
                return;
        }

        pay_form.submit();
    }
</script>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">

                <h2 class="text-center mb-4">
                    구매 확인
                </h2>

                <form name="pay_form" method="post" action="order_insert.php">

                <input type="hidden" name="product_id" id="product_id" class="form-control" value="<?php echo $product_id;?>">
                <input type="hidden" name="seller_id" id="seller_id" class="form-control" value="<?php echo $row["member_id"];?>">

                    <!-- 구매할 상품 -->
                    <div class="card mb-4">
                        <div class="card-header">
                            구매 상품
                        </div>

                        <div class="card-body">
                            <div class="d-flex align-items-center">

                                <img src="product/<?php echo $product_image;?>" alt="상품 이미지"
                                    class="rounded border object-fit-cover me-3" style="width: 100px; height: 100px;">

                                <div>
                                    <h5 class="mb-2">
                                        <?php echo $row["name"];?>
                                    </h5>

                                    <p class="mb-1">
                                        <?php echo number_format($row["price"]);?>
                                    </p>

                                    <p class="text-secondary mb-0">
                                        판매자: <?php echo $row["id"];?>
                                    </p>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- 결제 방법 -->
                    <div class="mb-4">
                        <label for="payment_method" class="form-label">
                            결제 방법
                        </label>

                        <select name="payment_method" id="payment_method" class="form-select">
                            <option value="" selected>
                                결제 방법을 선택해주세요.
                            </option>

                            <option value="0">
                                지금 결제
                            </option>

                            <option value="1">
                                만나서 현금결제
                            </option>
                        </select>
                    </div>

                    <!-- 은행 선택 -->
                    <div class="mb-4">
                        <label for="bank_name" class="form-label">
                            은행 선택 * 지금 결제 선택 시에만 작성
                        </label>

                        <select name="bank_name" id="bank_name" class="form-select">
                            <option value="0" selected>
                                은행 선택
                            </option>
                        <?php
                            for($i = 1; $i < $n_bank; $i++) {
                        ?>
                            <option value="<?php echo $i; ?>">
                                <?php echo $a_bank[$i]; ?>
                            </option>
                        <?php
                            }
                        ?>
                        </select>
                    </div>

                    <!-- 카드번호 -->
                    <div class="mb-4">
                        <label for="bank_num" class="form-label">
                            카드번호(하이픈 제외하고 입력) * 지금 결제 선택 시에만 작성
                        </label>

                        <input type="text" name="bank_num" id="bank_num" class="form-control"
                            placeholder="카드번호를 입력해주세요.">
                    </div>

                    <!-- 현금결제 안내 -->
                    <div class="alert alert-secondary mb-4">
                        만나서 현금결제를 선택한 경우 채팅을 통해 판매자와 거래 장소와 시간을 정해주세요.
                    </div>

                    <!-- 결제 금액 -->
                    <div class="border rounded p-3 mb-4">
                        <div class="d-flex justify-content-between">
                            <strong>결제 금액</strong>
                            <strong><?php echo number_format($row["price"]);?>원</strong>
                        </div>
                    </div>

                    <!-- 하단 버튼 -->
                    <div class="d-flex gap-2">
                        <a href="javascript:history.back()" class="btn btn-outline-secondary flex-fill">
                            취소
                        </a>

                        <button type="button" class="btn btn-dark flex-fill" onclick="javascript:Submit()">
                            구매하기
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</body>

</html>