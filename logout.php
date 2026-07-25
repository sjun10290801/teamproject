<?php
    setcookie("cookie_id", "", time() - 3600);
	echo("<script>location.href='index.html'</script>");
?>