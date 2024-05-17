<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;
use \Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait; 

    public function index()
    {
        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $user = $userModel->where('email', $email)->first();
        if(is_null($user)) {
            return $this->respond(['error' => 'invalid username or password.'],401);
        }
        $pwd_verify = password_verify($password, $user['password']);
        if(!$pwd_verify) {
            return $this->respond(['error'=> 'invalid username or password.'],401);
        }
        $key = getenv('JWT-SECRET');
        $iat = time(); //current timestamp value 
        $exp = $iat + 3600;
        $payload = array(
            "iss" => "issuer of the JWT",
            "aud" => "audience that the JWT",
            "sub" => "subject of the JWT",
            "iat" => $iat, //time the JWT issued at 
            "exp" => $exp, //expiration time of token 
            "email" => $user['email'], 
        );
        $token = JWT::encode($payload, $key, 'hs256');
        $response = [
            'message' => 'Login succesful',
            'token' => $token 

        ];
        return $this->respond($response, 200);
    }
}