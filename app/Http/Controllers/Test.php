<?php

namespace App\Http\Controllers;

use App\Model\UserTest;

class Test extends BaseController
{
  public function test() {
    $user = UserTest::all();
    return $user;
  }
}
