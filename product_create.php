<?php

    include "common.php";
    loginCheck();

    $cookie_id = $_COOKIE["cookie_id"];

    $sql = "select * from member where id = '$cookie_id'";
    $result = mysqli_query($db, $sql);
    if(!$result) exit("에러 : $sql");

    $row = mysqli_fetch_assoc($result);
    $juso1 = $row["juso1"];
    $juso2 = $row["juso2"];
    $juso3 = $row["juso3"];
    $juso = $juso1." ".$juso2;

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 상품 등록 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

        body {
            background-color: #f8f9fa;
        }

        .product-title {
            color: #18766d;
            font-weight: 700;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #18766d;
            box-shadow: 0 0 0 0.2rem rgba(24, 118, 109, 0.15);
        }

        .address-btn {
            background-color: #18766d;
            border-color: #18766d;
            color: white;
        }

        .address-btn:hover {
            background-color: #105f58;
            border-color: #105f58;
            color: white;
        }

        .submit-btn {
            background-color: #18766d;
            border-color: #18766d;
            color: white;
        }
        .submit-btn:hover {
            background-color: #105f58;
            border-color: #105f58;
            color: white;
        }
</style>
</head>

<body>

<script>
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
    <form method="post" name="form2" action="product_insert.php" enctype="multipart/form-data"> <!-- 제출용 폼 태그 추가  -->
        <div class="container py-5">
            <h2 class="text-center mb-4 product-title">상품 등록</h2>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <select class="form-select" aria-label="Default select example" name="category">
                        <?php
                            for($i = 0; $i < $n_category; $i++) {
                                if($i == 0) { 
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

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_name" class="form-label">제품명</label>
                    <input type="text" name="name" class="form-control" id="product_name" placeholder="제품명을 입력해주세요.">
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_price" class="form-label">가격</label>
                    <input type="text" name="price" class="form-control" id="product_price" placeholder="">
                </div>
            </div>

            <div class="d-flex gap-2 mb-2">
				<input type="text" name="juso" id="zip11" class="form-control custom-dark-input" style="max-width: 140px;" readonly value="<?php echo $juso;?>">
				<a href="javascript:FindZip(0);" class="btn address-btn text-nowrap">
					<i class="bi bi-geo-alt me-1"></i> 주소찾기
			    </a>
		    </div>
				<input type="text" name="juso3" id="juso11" class="form-control custom-dark-input" placeholder="상세 주소를 입력하세요" value="<?php echo $juso3;?>">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="product_description" class="form-label">제품 설명</label>
                    <textarea class="form-control" name="text" id="product_description" placeholder="제품에 대한 설명을 입력해주세요."
                        rows="3"></textarea>
                </div>
            </div>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label" >제품 사진 등록</label>
                <input class="form-control" type="file" id="formFileMultiple" multiple name="image">
            </div>
            <div class="text-center">
                <a href="javascript:Submit();" class="btn btn-sm submit-btn">등록</a><!-- 제출 버튼 추가  -->
            </div>
        </div>
    </form>
</body>

</html>