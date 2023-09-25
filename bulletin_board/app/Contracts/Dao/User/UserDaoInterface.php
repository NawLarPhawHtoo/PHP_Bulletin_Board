<?php

namespace App\Contracts\Dao\User;

interface UserDaoInterface
{
  /**
   * To save user that from api request
   * @param array $validated  Validated values from request
   * @return Object created user object
   */
  public function saveUser($validated);
}