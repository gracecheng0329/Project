<?php

session_start();

unset($_SESSION['admin']);

# session_destroy(); // 清掉所有 session 資料

header('Location: biddingList.php'); // redirect // 轉向
