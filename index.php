<?php
    include "main_top.php";
?>


<form>
    <fieldset>
        <legend>위치정보</legend>
        <label for="city">지역 선택: </label>
        <select name="city" id="city">
            <option value="" disabled selected>지역을 선택해주세요</option>
            
            <optgroup label="서울시">
                <option value="강북구">강북구</option>
                <option value="강남구">강남구</option>
                <option value="서초구">서초구</option>
                <option value="노원구">노원구</option>
                <option value="도봉구">도봉구</option>
                <option value="중랑구">중랑구</option>
                <option value="관악구">관악구</option>
            </optgroup>

            <optgroup label="경기도">
                <option value="가평군">가평군</option>
                <option value="고양시">고양시</option>
                <option value="과천시">과천시</option>
                <option value="광명시">광명시</option>
                <option value="광주시">광주시</option>
                <option value="구리시">구리시</option>
                <option value="군포시">군포시</option>
                <option value="남양주시">남양주시</option>
                <option value="시흥시">시흥시</option>
            </optgroup>
        </select>
    </fieldset>
<button type="button" class="btn btn-outline-secondary">위치검색하기</button>
</form>

<ul class="nav align-items-center">
  <li class="nav-item">
    <span class="nav-link fw-bold text-dark ps-0">카테고리</span>
  </li>

  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">디지털기기</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">가구</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">가전</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">의류</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">게임</a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">음악</a>
  </li>
    </li>
  <li class="nav-item">
    <a class="nav-link text-secondary" href="category.php">기타</a>
  </li>
</ul>

    <div class="card-list">

        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">메리다 로드자전거</h5>
                <p class="card-text">자전거</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 상계동</li>
                <li class="list-group-item">15분 전</li>
                <li class="list-group-item">700,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>

        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">삼성갤럭시북</h5>
                <p class="card-text">노트북</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 중계동</li>
                <li class="list-group-item">하루전</li>
                <li class="list-group-item">500,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>

        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">로지텍 102마우스</h5>
                <p class="card-text">마우스</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 노원구</li>
                <li class="list-group-item">1시간 전</li>
                <li class="list-group-item">20,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>


        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">5060 컴퓨터 본체</h5>
                <p class="card-text">컴퓨터</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 공릉동</li>
                <li class="list-group-item">3시간 전</li>
                <li class="list-group-item">,1500,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>


        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">메리다 로드자전거</h5>
                <p class="card-text">자전거</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 상계동</li>
                <li class="list-group-item">15분 전</li>
                <li class="list-group-item">700,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>

        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">삼성갤럭시북</h5>
                <p class="card-text">노트북</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 중계동</li>

                <li class="list-group-item">하루전</li>
                <li class="list-group-item">500,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>

        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">로지텍 102마우스</h5>
                <p class="card-text">마우스</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 노원구</li>
                <li class="list-group-item">1시간 전</li>
                <li class="list-group-item">20,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>


        <div class="card">
            <img src="..." class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">5060 컴퓨터 본체</h5>
                <p class="card-text">컴퓨터</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">서울시 공릉동</li>
                <li class="list-group-item">3시간 전</li>
                <li class="list-group-item">,1500,000원</li>
            </ul>
            <div class="card-body">
                <a href="#" class="card-link">찜하기</a>
                <a href="#" class="card-link">채팅하기</a>
                <a href="member_profile.html" class="card-link">프로필보기</a>
            </div>
        </div>
    </div>

    <?php
    include "main_bottom.php";
?>