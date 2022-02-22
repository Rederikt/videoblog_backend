<?php

function getPosts ($connect) {
    $posts = mysqli_query($connect, "SELECT * FROM `posts`");


    $postsList = [];

    while($post = mysqli_fetch_assoc($posts)){
        $postsList[] = $post;
    }
    echo json_encode($postsList);
}

function getMyPosts ($connect, $data) {
    $owner_id = $data['owner_id'];
    $posts = mysqli_query($connect, "SELECT * FROM `posts` WHERE `owner_id` = '$owner_id'");

    $postsList = [];

    while($post = mysqli_fetch_assoc($posts)){
        $postsList[] = $post;
    }
    echo json_encode($postsList);
}

function getPost ($connect, $data) {
    $id = $data['id'];
    $post = mysqli_query($connect, "SELECT * FROM `posts` WHERE `id` = '$id'");
    
    if (mysqli_num_rows($post) === 0) {
        http_response_code(404);
        $res = [
            "status" => false,
            "message" => "Post not found"
        ];
        echo json_encode($res);
    } else {
        $post = mysqli_fetch_assoc($post);
        echo json_encode($post);
    }
}

function addPost ($connect, $data) {
    $title = $data['title'];
    $description = $data['description'];
    $url = $data['url'];
    $owner_name = $data['owner_name'];
    $owner_id = $data['owner_id'];
    mysqli_query($connect, "INSERT INTO `posts` (`id`, `title`, `description`, `likes`, `url`, `owner_name`, `owner_id`) VALUES (NULL, '$title', '$description', 0, '$url', '$owner_name', '$owner_id')");
    
    http_response_code(201);

    $res = [
        "status" => true,
        "post_id" => mysqli_insert_id($connect),
    ];

    echo json_encode($res);
}

function editPost ($connect, $data) {
    $title = $data['title'];
    $description = $data['description'];
    $id = $data['id'];
    mysqli_query($connect, "UPDATE `posts` SET `title` = '$title', `description` = '$description' WHERE `id` = '$id'");

    $res = [
        "status" => true,
        "message" => "Posts is updated"
    ];
    echo json_encode($res);
}

function likePost ($connect, $data) {
    $id = $data['id'];
    $likes = $data['likes'];
    mysqli_query($connect, "UPDATE `posts` SET `likes` = '$likes' WHERE `id` = '$id'"); 

    $res = [
        "status" => true,
        "message" => "Posts is updated"
    ];
    echo json_encode($res);
}

function deletePost ($connect, $data) {
    $id = $data['id'];

    mysqli_query($connect, "DELETE FROM `posts` WHERE `id` = '$id'");
    
    http_response_code(201);

    $res = [
        "status" => true,
        "post_id" => mysqli_insert_id($connect),
    ];

    echo json_encode($res);
}