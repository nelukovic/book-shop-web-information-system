<?php


namespace app\models;


use app\core\DBModel;

class UserRolesModel extends DBModel
{
    public $id;
    public $idRole;
    public $idUser;


    public function tableName()
    {
        return "user_roles";
    }

    public function attributes(): array
    {
        return [
            'idRole',
            'idUser'
        ];
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.
    }

    public function labels(): array
    {
        // TODO: Implement labels() method.
    }
}