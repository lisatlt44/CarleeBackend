<?php

namespace App\Http\Controllers;

use App\Model\UserTest;

class Controller extends BaseController
{
  public function test() {
    $user = UserTest::all();
    return response()->json($user);
  }
}
