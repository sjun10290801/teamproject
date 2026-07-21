<?php
    include "common.php";
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> 상품 등록 </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <form method="post" action="product_insert.php" enctype="multipart/form-data"> <!-- 제출용 폼 태그 추가  -->
        <div class="container">
            <h2 class="text-center mb-4">제품 등록</h2>

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

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="product_region" class="form-label">지역</label>
                    <select class="form-select" name="region" id="product_region">
                        <option selected>지역을 선택해주세요.</option>
                        <option value="gangwon">강원특별자치도</option>
                        <option value="gyeonggi">경기도</option>
                        <option value="gyeongnam">경상남도</option>
                        <option value="gyeongbuk">경상북도</option>
                        <option value="gwangju">광주광역시</option>
                        <option value="daegu">대구광역시</option>
                        <option value="daejeon">대전광역시</option>
                        <option value="busan">부산광역시</option>
                        <option value="seoul">서울특별시</option>
                        <option value="sejong">세종특별자치시</option>
                        <option value="ulsan">울산광역시</option>
                        <option value="incheon">인천광역시</option>
                        <option value="jeonnam">전라남도</option>
                        <option value="jeonbuk">전북특별자치도</option>
                        <option value="jeju">제주특별자치도</option>
                        <option value="chungnam">충청남도</option>
                        <option value="chungbuk">충청북도</option>
                    </select>
                </div>
            </div>
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
                <button type="submit"  class="btn btn-primary">등록</button> <!-- 제출 버튼 추가  -->
            </div>
        </div>
    </form>
</body>

</html>