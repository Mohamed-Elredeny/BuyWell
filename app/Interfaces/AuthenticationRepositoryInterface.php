<?php

namespace App\Interfaces;

interface AuthenticationRepositoryInterface
{
    public function login(array $recordDetails);
    public function loginSocial(array $recordDetails);
    public function register(array $recordDetails);
    public function logout($token,$type);
    public function viewProfile($token,$type);
    public function updateProfile($token,array $recordDetails);
}
