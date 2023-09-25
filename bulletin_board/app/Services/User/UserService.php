<?php

namespace App\Services\User;

use App\Contracts\Dao\User\UserDaoInterface;
use App\Contracts\Services\User\UserServiceInterface;

class UserService implements UserServiceInterface
{
  private $userDao;

  /**
   * Class constructor
   * @param UserDaoInterface
   * @return
   */
  public function __construct(UserDaoInterface $userDao)
  {
    $this->userDao = $userDao;
  }

  /**
   * To save user that from api request
   * @param array $validated Validated value from request
   * @return Object created user object
   */
  public function saveUser($validated)
  {
    $user = $this->userDao->saveUser($validated);
    return $user;
  }
}