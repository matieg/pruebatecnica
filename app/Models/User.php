<?php
namespace app\Models;

class User extends Model
{
    protected string $table = 'user';

    public $id, $name, $username, $password;

}