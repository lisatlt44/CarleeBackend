<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;

class ReminderController extends Controller
{
  /**
   * Création d'une instance.
   * Spécification des méthodes soumises à la vérification d'authentification 
   *
   * @return void
   */
  public function __construct() 
  {
    $this->middleware('auth:api');
  }

  /**
   * Affiche les informations d'un rappel spécifique.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */

   public function index()
   {
    $reminders = Reminder::all();
    return response()->json($reminders);
   }


  public function show($id)
  {
    // Recherche du rappel par ID
    $reminder = Reminder::findOrFail($id);

    // Réponse avec les détails du voyant
    return response()->json($reminder);
  }
}