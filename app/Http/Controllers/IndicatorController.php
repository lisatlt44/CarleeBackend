<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Validator;

class IndicatorController extends Controller
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
   * Affiche les informations d'un voyant spécifique.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */

   public function index()
   {
       $indicators = Indicator::all();
       return response()->json($indicators);
   }


  public function show($id)
  {
    // Recherche du voyant par ID
    $indicator = Indicator::findOrFail($id);

    // Réponse avec les détails du voyant
    return response()->json($indicator);
  }
}