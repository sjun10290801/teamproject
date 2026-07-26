<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인화면</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

      <style>
    body {
        padding-top: 80px; 
    }
    </style>

          <style>
    body {
        padding-bottom: 50px; 
    }
    </style>

    <style>
        .search-container {
            display: flex;
            justify-content: space-between;
            ;
            padding: 20px;
            width: 100%;
        }
    </style>

    <style>
        .card-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
        }
    </style>

    <style>
        .product-card {
            border: 1px solid #000000;
            padding: 15px;
            width: 320px;
            height: 400px;
        }
    </style>
</head>

<body>
<nav class="navbar bg-body-tertiary fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">중고거래</a>

        <form class="d-flex mt-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasNavbarLabel">메뉴</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">로그인</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">최근 본 글</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              마이페이지
            </a>
          </button>
          <ul class="dropdown-menu dropdown-menu-lights">
            <li><a class="dropdown-item" href="#">내정보</a></li>
            <li><a class="dropdown-item" href="#">찜한목록</a></li>
            <li><a class="dropdown-item" href="#">채팅</a></li>
            <li><a class="dropdown-item" href="#">상품등록</a></li>
          </ul>
          </li>
        </ul>
        <form class="d-flex mt-3" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"/>
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </div>
</nav>

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