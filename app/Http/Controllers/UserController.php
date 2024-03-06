<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  /**
   * Affiche les détails d'un utilisateur spécifique en fonction de son ID.
   *
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function show($id)
  {    
    // Récupérer l'utilisateur en fonction de son ID
    $user = User::findOrFail($id);

    // Retourner les détails de l'utilisateur sous forme de réponse JSON
    return response()->json($user);
  }

  /**
   * Met à jour les informations d'un utilisateur existant en fonction de son ID.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, $id)
  {
    // Récupérer l'utilisateur en fonction de son ID
    $user = User::findOrFail($id);

    // Valider les données de la requête
    $validatedData = $request->validate([
      'firstname' => 'required|string|max:255',
      'lastname' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email',
      'email_verified_at' => 'nullable|date',
      'birth_date' => 'nullable|date',
      'phone' => ['nullable', 'string', 'regex:/^0\d{9}$/'],
      'password' => 'required|string|min:8',
      'remember_token' => 'nullable|string|max:255',
      'is_active' => 'nullable|boolean'
    ]);

    // Mettre à jour les informations de l'utilisateur avec les données validées
    $user->update($validatedData);

    // Retourner les détails de l'utilisateur mis à jour sous forme de réponse JSON
    return response()->json($user);
  }

  /**
   * Met à jour le statut is_active de l'utilisateur spécifié pour le désactiver.
   *
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    // Récupérer l'utilisateur en fonction de son ID
    $user = User::findOrFail($id);

    // Mettre à jour le statut is_active de l'utilisateur à false
    $user->update(['is_active' => false]);

    // Retourner une réponse JSON pour indiquer que l'utilisateur a été désactivé avec succès
    return response()->json(['message' => 'L\'utilisateur a correctement été désactivé.']);
  }
}
