<?php

if (filter_input(INPUT_GET, 'page')=='header'){
    include 'Pages/header.php';
}elseif (filter_input(INPUT_GET, 'page')=='my-page'){
    include 'Pages/my-page.php';
}else{
    include 'Pages/footer.php';
};


