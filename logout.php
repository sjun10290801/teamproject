<?php
    setcookie("cookie_id", "", time() - 3600);

    //세션 삭제
    session_start();
    //session_unset($_SESSION["id"]);
    session_destroy();

	echo("<script>location.href='index.html'</script>");
?>