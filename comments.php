<?php

function addComment ($connect, $data) {
    $text = $data['text'];
    $username = $data['username'];
    $post_id = $data['post_id'];
    mysqli_query($connect, "INSERT INTO `comments` (`comment_id`, `text`, `username`, `post_id`) VALUES (NULL, '$text', '$username', '$post_id')");
    
    http_response_code(201);

    $res = [
        "status" => true,
        "post_id" => mysqli_insert_id($connect),
    ];

    echo json_encode($res);
}

function getComments ($connect, $data) {
    $post_id = $data['post_id'];
    $comments = mysqli_query($connect, "SELECT * FROM `comments` WHERE `post_id` = '$post_id'");

    $commentsList = [];

    while($comment = mysqli_fetch_assoc($comments)){
        $commentsList[] = $comment;
    }
    echo json_encode($commentsList);
}

function deleteComment ($connect, $data) {
    $comment_id = $data['comment_id'];

    mysqli_query($connect, "DELETE FROM `comments` WHERE `comment_id` = '$comment_id'");
    
    http_response_code(201);

    $res = [
        "status" => true,
        "post_id" => mysqli_insert_id($connect),
    ];

    echo json_encode($res);
}