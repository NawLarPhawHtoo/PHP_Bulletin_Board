<?php

namespace App\Contracts\Services\User;

interface UserServiceInterface
{
  /**
   * To save user that from api request
   * @param array $validated Validated values from request
   * @return Object created user object
   */
  public function saveUser($validated);
}