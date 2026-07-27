<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    if(!isset($_COOKIE["cookie_id"])) {
            echo("<script>alert('로그인이 필요한 서비스입니다.');</script>");
            echo("<script>location.href='login.php'</script>"); // 로그인 화면으로 돌아감.
            exit();
        }

    include "common.php";

    $product_id = $_GET["id"];
    $cookie_id = $_COOKIE["cookie_id"];

    $sql = "select p.category, p.name, p.price, p.juso1, p.juso2, p.juso3, p.memo, p.image, m.id as member_id, p.state
            from product p inner join member m on p.member_id = m.member_id where p.product_id = '$product_id'";    
    // id에 해당하는 상품 찾기, id검증을 위해 멤버테이블 join
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);

    if($cookie_id != $row["member_id"]) {
        echo("<script>alert('자신의 상품만 수정할 수 있습니다.');</script>");
        echo("<script>location.href='index.html'</script>");
    }

?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 제품 수정 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<script>
    function FindZip() {
            window.open(
                "zipcode.php",
                "zip",
                "width=440,height=320,scrollbars=no"
            );
    }

    function Submit() {
        if(form2.category.value == 0) {
            alert("카테고리를 선택해주세요.");
            form2.category.focus();
            return;
        }
        if(!form2.name.value) {
            alert("제품명을 입력해주세요.");
            form2.name.focus();
            return;
        }
        if(!form2.price.value) {
            alert("가격을 입력해주세요.");
            form2.price.focus();
            return;
        }
        if(!form2.juso.value) {
            alert("주소를 입력해주세요.");
            form2.juso.focus();
            return;
        }
        if(!form2.text.value) {
            alert("제품 설명을 입력해주세요.");
            form2.text.focus();
            return;
        }
        if(!form2.text.value) {
            alert("제품 설명을 입력해주세요.");
            form2.text.focus();
            return;
        }

        form2.submit();

    }
    function FindZip(zip_kind) 
	{
		w=window.open("zipcode.php", "zip", 
			"width=440,height=320,scrollbars=no");
	}
</script>
    <form method="post" name="form2" action="product_update.php" enctype="multipart/form-data">
        <div class="container">
            <h2 class="text-center mb-4">제품 수정</h2>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <select class="form-select" aria-label="Default select example" name="category">
                        <?php
                            for($i = 0; $i < $n_category; $i++) {
                                if($i == $row["category"]) { 
                                    $tmp = "selected";
                                } else {
                                    $tmp = "";
                                }
                                echo("<option value='$i' $tmp>$a_category[$i]</option>");
                            }
                        ?>
                    </select>
                </div>
            </div>
                    <input type="hidden" name="product_id" class="form-control" id="product_id" value = "<?php echo $product_id;?>"> <!-- 제품 id -->
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_name" class="form-label">제품명</label>
                    <input type="text" name="name" class="form-control" id="product_name" placeholder="제품명을 입력해주세요." value = "<?php echo $row["name"];?>">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_price" class="form-label">가격</label>
                    <input type="text" name="price" class="form-control" id="product_price" placeholder="" value = "<?php echo $row["price"];?>">
                </div>
            </div>

            <div class="d-flex gap-2 mb-2">
				<input type="text" name="juso" id="zip11" class="form-control custom-dark-input" style="max-width: 140px;" readonly value = "<?php echo $row["juso1"]." ".$row["juso2"];?>">
				<a href="javascript:FindZip(0);" class="btn btn-premium-inline text-nowrap">
					<i class="bi bi-geo-alt me-1"></i> 주소찾기
			    </a>
		    </div>
				<input type="text" name="juso3" id="juso11" class="form-control custom-dark-input" placeholder="상세 주소를 입력하세요" value = "<?php echo $row["juso3"];?>">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="product_description" class="form-label">제품 설명</label>
                    <textarea class="form-control" name="text" id="product_description" placeholder="제품에 대한 설명을 입력해주세요."
                        rows="3"><?php echo stripslashes($row["memo"]);?></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label" >제품 사진 수정 (이미지 삭제 시 체크) </label>
                <input type="checkbox" name="check" value="1"> <!--체크박스 체크 시 1 전송-->
                <img src="product/<?php echo $row["image"];?>" width="100" height="100" class="img-thumbnail">
                <input type="hidden" name="image_name" value="<?php echo $row["image"];?>">
                <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
            </div>
            <?php if($row["state"] != 2) { ?>
                <div>
                    <label for="formFileMultiple" class="form-label" >판매 상태</label>
                    <select class="form-select" aria-label="Default select example" name="state">
                        <?php if($row["state"] == 0)  {?>
                        <option value="0" selected>판매 중</option>
                        <option value="1">예약됨</option>
                        <?php } else { ?>
                        <option value="0">판매 중</option>
                        <option value="1" selected>예약됨</option>
                        <?php }?>
                    </select>
                </div>
            <?php } else { ?>
                <div>
                    <label for="formFileMultiple" class="form-label" >판매 상태</label>
                    <span class="badge text-bg-success">판매 완료</span>
                </div>
            <?php } ?>
            <div class="text-center">
                <a href="javascript:Submit();" class="btn btn-sm btn-dark text-white myfont">등록</a><!-- 제출 버튼 추가  -->
            </div>
        </div>
    </form>
</body>

</html>