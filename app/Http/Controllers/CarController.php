<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
  /**
   * Crée une nouvelle voiture à partir des données fournies dans la requête.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Validation des données de la requête
    $request->validate([
      'name' => 'required|string|max:55',
      'brand' => 'required|string|max:55',
      'model' => 'required|string|max:55',
      'color' => 'nullable|string|max:55',
      'fuel_type' => 'required|string|max:55',
      'production_date' => 'required|date',
      'plate_number' => 'required|string|unique:cars|regex:/^[A-Z0-9]{1,10}$/i',
      'mileage' => 'required|integer|min:0',
      'last_maintenance_date' => 'required|date|after_or_equal:production_date',
      'user_id' => 'required|exists:users,id',
    ]);

    // Récupération du code ISO du pays
    $countryIsoCode = $request->input('country_iso_code');

    // Création d'une nouvelle voiture avec le code ISO du pays associé
    $car = new Car();
    $car->name = $request->input('name');
    $car->brand = $request->input('brand');
    $car->model = $request->input('model');
    $car->color = $request->input('color');
    $car->fuel_type = $request->input('fuel_type');
    $car->production_date = $request->input('production_date');
    $car->country_iso_code = $countryIsoCode;
    $car->plate_number = $request->input('plate_number');
    $car->mileage = $request->input('mileage');
    $car->last_maintenance_date = $request->input('last_maintenance_date');
    $car->user_id = $request->input('user_id');
    $car->save();

    // Réponse avec la voiture nouvellement créée
    return response()->json($car, 201);
  }
}
