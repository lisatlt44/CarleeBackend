<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserTest;

class Test extends Controller
{
  public function test() {
    $user = UserTest::all();
    return response()->json($user);
  }
}
