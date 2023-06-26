<?php
namespace app\Models;

class User extends Model
{
    protected $table = 'user';

    public $id, $name, $username, $password;

}