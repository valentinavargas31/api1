<?php
namespace app\controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

Class User extends BaseController
{
    use ResponseTrait;

    public function index()
    {
     $users = new UserModel;
     return $this->respond(['users' => $users->findAll()],200);
    }
}
