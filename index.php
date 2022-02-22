<?php

header('Content-type: json/application');

require 'connect.php';
require 'posts.php';
require 'auth.php';
require 'comments.php';



$q = $_GET['q'];
$params = explode('/', $q);
$method = $_SERVER['REQUEST_METHOD'];

$type = $params[0];
$id = $params[1]; 

switch ($method) {
    case 'GET':
        if ($type === 'getposts') {
            getPosts($connect);
            break;
        }
        break;
    case 'POST':
        if ($type === 'addpost') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            addPost($connect, $data);
            break;
        } elseif ($type === 'register') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            register($connect, $data);
            break;
        } elseif ($type === 'login') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            login($connect, $data);
            break;
        } elseif ($type === 'myposts') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            getMyPosts($connect, $data);
        } elseif ($type === 'post') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            getPost($connect, $data);
            break;
        }
         elseif ($type === 'addcomment') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            addComment($connect, $data);
        }
        elseif ($type === 'comments') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            getComments($connect, $data);
        }
        break;

    case 'DELETE':
        if ($type === 'deletecomment') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            deleteComment($connect, $data);
            break;
        }
        elseif ($type === 'deletepost') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            deletePost($connect, $data);
            break;
        }
    break;

    case 'PATCH':
        if ($type === 'editpost') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            editPost($connect, $data);
            break;
        }
        elseif ($type === 'likepost') {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            likePost($connect, $data);
            break;
        }
    break;
}


