<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller

{
  /**
   * Création d'une instance.
   * Spécification des méthodes soumises à la vérification d'authentification 
   *
   * @return void
   */
  public function __construct() 
  {
    $this->middleware('auth:api', ['except' => ['login', 'register']]);
  }

  /**
   * Générer un JWT à la connexion d'un utilisateur.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function login(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    if (! $token = auth()->attempt($validator->validated())) {
      return response()->json(['error' => 'Non autorisé.'], 401);
    }

    return $this->createNewToken($token);
  }

  /**
   * Inscription d'un utilisateur.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function register(Request $request) 
  {
    $validator = Validator::make($request->all(), [
      'firstname' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'birth_date' => ['nullable', 'date', 'before_or_equal:today', 'after_or_equal:1900-01-01'], // format Y-m-d
      'phone' => ['nullable', 'string', 'regex:/^0\d{9}$/'],
      'email' => 'required|string|email|max:255|unique:users,email',
      'password' => 'required|string|min:8',
    ]);

    if($validator->fails()){
      return response()->json($validator->errors()->toJson(), 400);
    }

    $user = User::create(array_merge(
      $validator->validated(),
      ['password' => Hash::make($request->password)]
    ));

    return response()->json([
      'message' => 'L\'utilisateur a correctement été enregistré.',
      'user' => $user
    ], 201);
  }

  /**
   * Déconnection de l'utilisateur (Invalider le token).
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function logout() {
    auth()->logout();
    return response()->json(['message' => 'L\'utilisateur a correctement été déconnecté.']);
  }

  /**
   * Rafraîchir le token.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function refresh() {
    return $this->createNewToken(auth()->refresh());
  }

  /**
   * Chargement des identifiants de l'utilisateur.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function userProfile() {
    return response()->json(auth()->user());
  }

  /**
    * Chargement de la structure du token.
    *
    * @param string $token
    *
    * @return \Illuminate\Http\JsonResponse
    */
  protected function createNewToken($token){
    return response()->json([
      'access_token' => $token,
      'token_type' => 'bearer',
      'expires_in' => auth()->factory()->getTTL() * 60,
      'user' => auth()->user()
    ]);
  }
}
