<?php
namespace Wall\App\Controllers;

use Wall\App\Core\AbstractController;
use Wall\App\Core\Response;
use Wall\App\Exceptions\InvalidArgumentException;
use Wall\App\Exceptions\UserAlreadyExistsException;
use Wall\App\Services\User as UserService;

class User extends AbstractController
{
    /** @var UserService */
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
        parent::__construct();
    }

    public function register() : Response
    {
        $requiredFields = ['email', 'username', 'password'];
        $params = $this->request->getParams();

        foreach($requiredFields as $field) {
            if(empty($params[$field])) {
                throw new InvalidArgumentException("Field {$field} is required and should not be empty");
            }

        }

        if(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email: {$params['email']} is invalid.");
        }

        if($this->userService->IsEmailExists($params['email'])) {
            throw new UserAlreadyExistsException("User with email: {$params['email']} already registered");
        }

        if($this->userService->isUsernameExists($params['username'])) {
            throw new UserAlreadyExistsException("User with username: {$params['username']} exists.");
        }

        $this->userService->addUser($params['email'], $params['username'], $params['password']);

        return new Response(201, ['message' => 'User successfully registered.']);

    }
}
