Route::get('chef/modules_vacantes',[chefModulesController::class,'vacantesList']); 
Route::post('chef/modules_vacantes/affecter/{id}',[chefModulesController::class,'affecter']); 
