<?php

class Table
{
    public static function getTableHeader()
    {
        return '
        <thead>
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Город</th>
            <th>Навыки</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>';
    }

    public static function getTableFooter()
    {
        return '</tbody>';
    }

    public static function getTableTr($data_item)
    {
        return '<tr id="' . $data_item['id'] . '">
            <th scope="row">' . $data_item['id'] . '</th>
            <td>' . $data_item['user_name'] . '</td>
            <td>' . $data_item['city_name'] . '</td>
            <td>' . $data_item['skills'] . '</td>
            <td class="edit_user"><i class="fas fa-edit"></i></td>
            <td class="delete_user"><i class="fas fa-trash-alt"></i></td>
        </tr>';
    }

    public static function getTable()
    {
        require_once __DIR__ . '/profiles.php';
        $profilesInstance = new Profiles();
        $profiles = $profilesInstance->getProfiles();

        $table = self::getTableHeader();
        foreach ($profiles as $profile) {
            $table .= self::getTableTr($profile);
        }
        $table .= self::getTableFooter();
        return $table;
    }
}
