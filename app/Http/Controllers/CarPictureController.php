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
   * Récupère toutes les images associées à une voiture spécifique.
   *
   * @param int $carId
   * @return \Illuminate\Http\Response
   */
  public function index($carId)
  {
    $carPictures = CarPicture::where('car_id', $carId)->get();
    return response()->json($carPictures);
  }

  /**
   * Récupère une image de voiture spécifique en fonction de son identifiant.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $carPicture = CarPicture::findOrFail($id);
    return response()->json($carPicture);
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
