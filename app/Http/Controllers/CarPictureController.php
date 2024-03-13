<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Support\Facades\Storage;
use App\Models\CarPicture;

class CarPictureController extends Controller
{
  /**
   * Récupère la liste des images de voiture pour une voiture donnée.
   *
   * @param int $carId L'identifiant de la voiture
   * @return \Illuminate\Http\Response
   */
  public function index($carId)
  {
    // Récupérer la voiture
    $car = Car::findOrFail($carId);

    // Récupérer les images de la voiture
    $carPictures = $car->carPictures;

    // Réponse avec les images de la voiture
    return response()->json(['data' => $carPictures]);
  }

  /**
   * Crée une nouvelle image de voiture à partir des données fournies dans la requête.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    // Validation des données de la requête
    $request->validate([
      'car_id' => 'required|exists:cars,id',
      'picture' => 'required|array',
      'picture.*' => 'image|mimes:jpeg,png,jpg', 
    ]);

    // Récupérer la voiture à laquelle ajouter les images
    $car = Car::findOrFail($request->input('car_id'));

    // Tableau pour stocker les URLs des images ajoutées
    $imageUrls = [];

    // Traiter et enregistrer les images téléchargées
    foreach ($request->file('picture') as $picture) {
      $path = $picture->store('public/carPictures');
      $url = Storage::url($path);
      $imageUrls[] = $url;
      $carPicture = new CarPicture(); 
      $carPicture->picture = $url;
      $carPicture->picture_size = $picture->getSize(); // en octets
      $car->carPictures()->save($carPicture);
    }

    // Réponse avec un message de succès
    return response()->json(['message' => 'Les images de la voiture ont correctement été créés.', 'data' => $imageUrls]);
  }
}
