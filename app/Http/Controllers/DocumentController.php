<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
  /**
   * Crée un nouveau document à partir des données fournies dans la requête.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Validation des données de la requête
    $request->validate([
      'name' => 'required|string|max:255',
      'type' => 'required|string',
      'file' => 'required|file|max:10240',
      'file_size' => 'nullable|integer',
      'car_id' => 'required|exists:cars,id',
    ]);

    // Récupération du fichier depuis la requête
    $file = $request->file('file');

    // Stockage du fichier dans le répertoire spécifique
    $path = $file->store('documents');

    // Création d'un nouveau document
    $document = new Document();
    $document->name = $request->input('name');
    $document->type = $request->input('type');
    $document->file = $path;
    $document->file_size = $file->getSize();
    $document->car_id = $request->input('car_id');
    $document->save();

    // Réponse avec le document nouvellement créé
    return response()->json($document, 201);
  }

  /**
   * Affiche les détails d'un document spécifique.
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
   * Met à jour les détails d'un document spécifique.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    // Validation des données de la requête
    $request->validate([
      'name' => 'required|string|max:255',
      'type' => 'required|string',
      'file' => 'nullable|file|max:10240',
      'file_size' => 'nullable|integer',
      'car_id' => 'required|exists:cars,id',
    ]);

    // Recherche du document par ID
    $document = Document::findOrFail($id);

    // Mise à jour des détails du document
    $document->name = $request->input('name');
    $document->type = $request->input('type');

    // Si un nouveau fichier est fourni, mettre à jour le fichier
    if ($request->hasFile('file')) {
      $file = $request->file('file');
      $path = $file->store('documents');
      $document->file = $path;
      $document->file_size = $file->getSize();
    }

    $document->car_id = $request->input('car_id');
    $document->save();

    // Réponse avec le document mis à jour
    return response()->json($document);
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
    return response()->json(['message' => 'Le document a correctement été désactivé'], 200);
  }
}
