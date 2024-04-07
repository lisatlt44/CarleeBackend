<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Validator;

class DocumentController extends Controller
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
   * Affiche les informations d'un document spécifique.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    // Recherche du document par ID
    $document = Document::findOrFail($id);

    // Réponse avec les détails du document
    return response()->json($document);
  }

  /**
   * Crée un nouveau document à partir des données fournies dans la requête.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Validation des données de la requête
    $validator = Validator::make($request->all(), [
      'name' => 'required|string|max:255',
      'type' => 'required|string|max:55',
      'file' => 'required|file',
      'car_id' => 'required|exists:cars,id',
    ]);

    // Vérification de la validation
    if ($validator->fails()) {
      return response()->json($validator->errors(), 400);
    } 

    // Récupération du fichier depuis la requête
    $file = $request->file('file');

    // Stockage du fichier dans le répertoire spécifique
    $path = $file->store('public/documents');

    $url = Storage::url($path);

    // Création d'un nouveau document
    $document = new Document();
    $document->name = Str::ucfirst($request->input('name'));
    $document->type = $request->input('type');
    $document->file = $url;
    $document->file_size = $file->getSize(); // en octets
    $document->is_active = true;
    $document->car_id = $request->input('car_id');
    $document->save();

    // Réponse avec le document nouvellement créé
    return response()->json(['message' => 'Le document a correctement été créé.', 'data' => $document]);
  }

  /**
   * Met à jour les informations d'un document spécifique.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // Récupérer le document en fonction de son ID
    $document = Document::findOrFail($id);

    // Validation des données de la requête
    $validator = Validator::make($request->all(), [
      'name' => 'sometimes|required|string|max:255',
      'type' => 'sometimes|required|string|max:55',
      'car_id' => 'sometimes|required|exists:cars,id',
    ]);

    // Vérification de la validation
    if ($validator->fails()) {
      return response()->json($validator->errors(), 400);
    }

    // Obtenir les données validées
    $validatedData = $validator->validated();

    // Mise à jour des détails du document
    $document->update($validatedData);

    // Réponse avec le document mis à jour
    return response()->json(['message' => 'Les informations du document avec l\'id ' . $id . ' ont correctement été modifiées.', 'data' => $document]);
  }

  /**
   * Supprime un document spécifique.
   *
   * @param int $id
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy($id)
  {
    // Recherche du document à désactiver
    $document = Document::findOrFail($id);

    // Mise à jour du statut is_active
    $document->update(['is_active' => false]);

    // Réponse confirmant la désactivation du document
    return response()->json(['message' => 'Le document a correctement été désactivé.'], 200);
  }
}
