<?php

if($_POST){
    $post = $_POST;
    $result = [];
    if(isset($post['action'])){
        switch ($post['action']){
            case 'add_user':
                $result = addUser($post);
                break;
            case 'delete_user':
                $result = deleteUser($post);
                break;
        }
    }
    echo $result;
}

function addUser($params){
    require_once __DIR__ . '/core/profiles.php';
    require_once __DIR__ . '/core/table.php';
    Profiles::createProfile();
    return Table::getTable();
}

function deleteUser($params){
    require_once __DIR__ . '/core/profiles.php';
    require_once __DIR__ . '/core/table.php';
    $profile = new Profiles();
    $profile->deleteProfileById($params['id']);
    return Table::getTable();
}