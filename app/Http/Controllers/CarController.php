<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
  /**
   * Affiche les détails d'une voiture spécifique.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    // Recherche de la voiture par ID
    $car = Car::findOrFail($id);

    // Réponse avec les détails de la voiture
    return response()->json($car);
  }

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
      'name' => 'sometimes|required|string|max:55',
      'brand' => 'sometimes|required|string|max:55',
      'model' => 'sometimes|required|string|max:55',
      'color' => 'nullable|string|max:55',
      'fuel_type' => 'sometimes|required|string|max:55',
      'production_date' => 'sometimes|required|date|before_or_equal:today|after_or_equal:1900-01-01', // format Y-m-d
      'country_iso_code' => 'nullable|string|max:2',
      'plate_number' => 'sometimes|required|string|unique:cars|regex:/^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/i', // format xx-xxx-xx
      'mileage' => 'sometimes|required|integer|min:0',
      'last_maintenance_date' => 'sometimes|required|date|before_or_equal:today|after_or_equal:production_date', // format Y-m-d
      'user_id' => 'sometimes|required|exists:users,id'
    ]);

    // Création d'une nouvelle voiture
    $car = new Car();
    $car->name = $request->input('name');
    $car->brand = $request->input('brand');
    $car->model = $request->input('model');
    $car->color = $request->input('color');
    $car->fuel_type = $request->input('fuel_type');
    $car->production_date = $request->input('production_date');
    $car->country_iso_code = $request->input('country_iso_code');
    $car->plate_number = $request->input('plate_number');
    $car->mileage = $request->input('mileage');
    $car->last_maintenance_date = $request->input('last_maintenance_date');
    $car->is_active = true;
    $car->user_id = $request->input('user_id');
    $car->save();

    // Réponse avec la voiture nouvellement créée
    return response()->json(['message' => 'La voiture a correctement été créée.', 'data' => $car]);
  }

  /**
   * Met à jour les détails d'une voiture spécifique.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // Récupérer la voiture en fonction de son ID
    $car = Car::findOrFail($id);

    // Validation des données de la requête
    $validatedData = $request->validate([
      'name' => 'sometimes|required|string|max:55',
      'brand' => 'sometimes|required|string|max:55',
      'model' => 'sometimes|required|string|max:55',
      'color' => 'nullable|string|max:55',
      'fuel_type' => 'sometimes|required|string|max:55',
      'production_date' => 'sometimes|required|date|before_or_equal:today|after_or_equal:1900-01-01', // format Y-m-d'
      'country_iso_code' => 'nullable|string|max:2',
      'plate_number' => 'sometimes|required|string|unique:cars,plate_number,'.$id.'|regex:/^[A-Z]{2}-[0-9]{3}-[A-Z]{2}$/i', // format xx-xxx-xx
      'mileage' => 'sometimes|required|integer|min:0',
      'last_maintenance_date' => 'sometimes|required|date|before_or_equal:today|after_or_equal:production_date', // format Y-m-d
      'user_id' => 'sometimes|required|exists:users,id'
    ]);

    // Mise à jour des détails de la voiture
    $car->update($validatedData);

    // Réponse avec la voiture mise à jour
    return response()->json(['message' => 'Les informations de la voiture avec l\'id ' . $id . ' ont correctement été modifiées.', 'data' => $car]);
  }

  /**
   * Supprime une voiture spécifique.
   *
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    // Recherche de la voiture à désactiver
    $car = Car::findOrFail($id);

    // Mise à jour du statut is_active
    $car->update(['is_active' => false]);

    // Réponse confirmant la désactivation de la voiture
    return response()->json(['message' => 'La voiture a correctement été désactivée'], 200);
  }
}
