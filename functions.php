<?php

//Function that sets a default value for required POST keys if they are not entered (excample at first startup)

function getPost($key, $default) {
    if (isset($_POST[$key]))
        return $_POST[$key];
    return $default;
}
function getGet($key, $default) {
    if (isset($_GET[$key]))
        return $_GET[$key];
    return $default;
}

?>
