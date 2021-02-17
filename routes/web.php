<?php

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
// Ignores notices and reports all other kinds... and warnings
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('itemCRUD','ItemCRUDController');

// IsoController
Route::resource('hisoctrl','IsoController'); 
Route::get('/hisoctrl', 'IsoController@index')->name('hisoctrl');
Route::get('isoctrl/index', ['as'=>'isoctrl.index','uses'=>'IsoController@hisoctrl']); // for datatable
Route::get('/isostatus', 'IsoController@isostatusindex')->name('isostatus');
Route::get('isoctrl/isostatusindex', ['as'=>'isoctrl.isostatusindex','uses'=>'IsoController@isostatus']); // for datatable
Route::post('/jsvcomments', 'IsoController@jsvcomments')->name('jsvcomments');


Route::post('sendfromdesignbulk','IsoController@sendfromdesignbulk')->name('sendfromdesignbulk');
Route::post('sendfromstressbulk','IsoController@sendfromstressbulk')->name('sendfromstressbulk');
Route::post('sendfromsupportsbulk','IsoController@sendfromsupportsbulk')->name('sendfromsupportsbulk');
Route::post('sendfrommaterialsbulk','IsoController@sendfrommaterialsbulk')->name('sendfrommaterialsbulk');
Route::post('sendfromleadbulk','IsoController@sendfromleadbulk')->name('sendfromleadbulk');
Route::post('sendfromisobulk','IsoController@sendfromisobulk')->name('sendfromisobulk');

Route::post('sendtostressfromdesign','IsoController@sendtostressfromdesign')->name('sendtostressfromdesign');
Route::post('sendtostressfromsupports','IsoController@sendtostressfromsupports')->name('sendtostressfromsupports');
Route::post('sendtosupportsfromdesign','IsoController@sendtosupportsfromdesign')->name('sendtosupportsfromdesign');
Route::post('sendtomaterialsfromdesign','IsoController@sendtomaterialsfromdesign')->name('sendtomaterialsfromdesign');
Route::post('sendtoleadfromdesign','IsoController@sendtoleadfromdesign')->name('sendtoleadfromdesign');
Route::post('sendtoleadfromstress','IsoController@sendtoleadfromstress')->name('sendtoleadfromstress');
Route::post('sendtoisofromdesign','IsoController@sendtoisofromdesign')->name('sendtoisofromdesign');
Route::post('sendtoisofromlead','IsoController@sendtoisofromlead')->name('sendtoisofromlead');
Route::post('sendtoissuefromiso','IsoController@sendtoissuefromiso')->name('sendtoissuefromiso');
Route::post('sendtosupportsfromstress','IsoController@sendtosupportsfromstress')->name('sendtosupportsfromstress');
Route::post('rejectfromstress','IsoController@rejectfromstress')->name('rejectfromstress');
Route::post('sendtomaterialsfromsupports','IsoController@sendtomaterialsfromsupports')->name('sendtomaterialsfromsupports');
Route::post('rejectfromsupports','IsoController@rejectfromsupports')->name('rejectfromsupports');
Route::post('sendtoleadfrommaterials','IsoController@sendtoleadfrommaterials')->name('sendtoleadfrommaterials');
Route::post('rejectfrommaterials','IsoController@rejectfrommaterials')->name('rejectfrommaterials');
Route::post('rejectfromlead','IsoController@rejectfromlead')->name('rejectfromlead');
Route::post('rejectfromiso2','IsoController@rejectfromiso2')->name('rejectfromiso2'); //SOLO PARA MIDOR
Route::post('rejectfromiso','IsoController@rejectfromiso')->name('rejectfromiso');
Route::get('public/storage/isoctrl/{filename}', ['as' => 'isoctrl', 'uses' => 'IsoController@show']);
Route::get('public/storage/isoctrl/attach/{filename}', ['as' => 'isoctrl', 'uses' => 'IsoController@showattach']);
Route::get('reqfromdesign/{filename}/{req}', ['as' => 'reqfromdesign', 'uses' => 'IsoController@reqfromdesign']);
Route::get('reqfromlead/{filename}/{req}', ['as' => 'reqfromlead', 'uses' => 'IsoController@reqfromlead']);


// VERIFICACIONES

Route::get('verifyfordesignlead/{filename}/{req}', ['as' => 'verifyfordesignlead', 'uses' => 'IsoController@verifyfordesignlead']);
Route::get('verifyforstresslead/{filename}/{req}', ['as' => 'verifyforstresslead', 'uses' => 'IsoController@verifyforstresslead']);
Route::get('verifyforsupportslead/{filename}/{req}', ['as' => 'verifyforsupportslead', 'uses' => 'IsoController@verifyforsupportslead']);

// RECLAMOS

Route::get('claimiso/{filename}/{req}', ['as' => 'claimiso', 'uses' => 'IsoController@claimiso']);

Route::post('sendtomaterialsfromldgdesign','IsoController@sendtomaterialsfromldgdesign')->name('sendtomaterialsfromldgdesign');
Route::post('sendtostressfromldgdesign','IsoController@sendtostressfromldgdesign')->name('sendtostressfromldgdesign');
Route::post('sendtosupportsfromldgdesign','IsoController@sendtosupportsfromldgdesign')->name('sendtosupportsfromldgdesign');
Route::post('rejectfromldgdesign','IsoController@rejectfromldgdesign')->name('rejectfromldgdesign');

Route::post('sendtomaterialsfromldgstress','IsoController@sendtomaterialsfromldgstress')->name('sendtomaterialsfromldgstress');
Route::post('rejectfromldgstress','IsoController@rejectfromldgstress')->name('rejectfromldgstress');
Route::post('rejectfromldgstresstodesign','IsoController@rejectfromldgstresstodesign')->name('rejectfromldgstresstodesign');
Route::post('rejectfromldgstresstoldgsupports','IsoController@rejectfromldgstresstoldgsupports')->name('rejectfromldgstresstoldgsupports');

Route::post('sendtomaterialsfromldgsupports','IsoController@sendtomaterialsfromldgsupports')->name('sendtomaterialsfromldgsupports');
Route::post('sendtoldgstressfromldgsupports','IsoController@sendtoldgstressfromldgsupports')->name('sendtoldgstressfromldgsupports');
Route::post('rejectfromldgsupports','IsoController@rejectfromldgsupports')->name('rejectfromldgsupports');
Route::post('rejectfromldgsupportstodesign','IsoController@rejectfromldgsupportstodesign')->name('rejectfromldgsupportstodesign');



// END VERIFICACIONES

Route::get('delfromleadoriso/{filename}/{req}/{tray}', ['as' => 'delfromleadoriso', 'uses' => 'IsoController@delfromleadoriso']);
Route::get('chktie/{filename}/{req}', ['as' => 'chktie', 'uses' => 'IsoController@chktie']);
Route::get('chkspo/{filename}/{req}', ['as' => 'chkspo', 'uses' => 'IsoController@chkspo']);
Route::get('chksit/{filename}/{req}', ['as' => 'chksit', 'uses' => 'IsoController@chksit']);
Route::post('/subir','IsoController@subirArchivo')->name('subir');
Route::post('/subircommon','IsoController@subirArchivoCommon')->name('subircommon'); // PARA SPO Y SIT
Route::post('/subirrev','IsoController@subirArchivoRev')->name('subirrev');
Route::resource('file', 'FileController'); // PARA SUBIR MULTIPLES ARCHIVOS
Route::get('exportisodates', 'IsoExportController@exportisodates');
Route::get('exportissued', 'IsoExportController@exportissued');

Route::get('exportisostatus', 'IsoExportController@exportisostatus');
Route::get('exportisostatuscount', 'IsoExportController@exportisostatuscount');
Route::get('exportisostatuswithdates', 'IsoExportController@exportisostatuswithdates');
Route::get('exportisostatuswithdatesreport', 'IsoExportController@exportisostatuswithdatesreport');
Route::get('exportisostatusprogress', 'IsoExportController@exportisostatusprogress');
Route::get('exportisostatuscountbytypeline', 'IsoExportController@exportisostatuscountbytypeline');
Route::get('exportissuedwithnotsupports', 'IsoExportController@exportissuedwithnotsupports');
Route::get('exportstatussitspo', 'IsoExportController@exportstatussitspo');


// NAVIS CONFIGURATION
//Route::resource('filenavis', 'FileNavisController'); // PARA SUBIR MULTIPLES ARCHIVOS
Route::get('exportxml', 'NavisExportController@exportxml');
Route::post('exportnavisxml','FileNavisController@store')->name('exportnavisxml');
Route::get('public/storage/navis/navis.xml', ['as' => 'navis', 'uses' => 'FileNavisController@show']);
$router->get('importnavis', 'NavisImportController@importnavis');

Route::resource('navisattselect','NavisController'); 
Route::get('/navisattselect', 'NavisController@navis')->name('navisattselect');
Route::get('navis/navis', ['as'=>'navis.navis','uses'=>'DequiTypeController@navisAtt']); // for datatable





//Route::get('sendtosupports/{filename}', ['as' => 'sendtosupports', 'uses' => 'IsoController@sendtosupports']);
//Route::get('sendtomaterials/{filename}', ['as' => 'sendtomaterials', 'uses' => 'IsoController@sendtomaterials']);

//Route::post('sendtostressfromdesign/{filename}', ['as' => 'sendtostressfromdesign', 'uses' => 'IsoController@sendtostressfromdesign']);




Route::get('/design', 'IsoController@design')->name('design');
Route::get('/stress', 'IsoController@stress')->name('stress');
Route::get('/supports', 'IsoController@supports')->name('supports');
Route::get('/materials', 'IsoController@materials')->name('materials');
Route::get('/iso', 'IsoController@iso')->name('iso');
Route::get('/lead', 'IsoController@lead')->name('lead');
Route::get('/trash', 'IsoController@trash')->name('trash');
Route::get('/commontray', 'IsoController@commontray')->name('commontray');
//Route::get('rejectfromstress/{filename}', ['as' => 'rejectfromstress', 'uses' => 'IsoController@rejectfromstress']);
//Route::get('rejectfromsupports/{filename}', ['as' => 'rejectfromsupports', 'uses' => 'IsoController@rejectfromsupports']);
//Route::get('rejectfrommaterials/{filename}', ['as' => 'rejectfrommaterials', 'uses' => 'IsoController@rejectfrommaterials']);

// End IsoController

Route::resource('elecs','DelecUiController'); 
Route::get('elecs','DelecUiController@create')->name('elecs');
Route::get('elec/indexelec', ['as'=>'electrical.indexelec','uses'=>'DelecUIController@index']); // for datatable
Route::get('electrical/eelecs', ['as'=>'electrical.eelecsfullquery','uses'=>'DelecUIController@eelecsfullquery']); // for datatable
Route::get('electrical/modeled', ['as'=>'electrical.delecsfullquery','uses'=>'DelecUIController@delecsfullquery']); // for datatable
Route::get('/eelecs', 'DelecUiController@eelecs')->name('eelecs');
Route::post('deleelec','DelecUIController@destroy')->name('deleelec');
Route::post('updateelec','DelecUiController@update')->name('updateelec');
Route::post('deleteelec','DelecUiController@destroy')->name('deleteelec');
Route::get('/glineelec', 'DelecUiController@gline')->name('glineelec');
Route::post('/glineelec', 'DelecUiController@gline')->name('glineelec');
Route::get('/glineelectotal', 'DelecUiController@glineTotal')->name('glineelectotal');
Route::get('/modeledelec', 'DelecUiController@modeled')->name('modeledelec');
Route::get('/milestoneelec', 'DelecUiController@milestone')->name('milestoneelec');
Route::get('elec/milestone', ['as'=>'electrical.milestone','uses'=>'DelecUIController@milestoneelec']); // for datatable

Route::resource('typeselec','DelecTypeController'); 
Route::get('/typeselec', 'DelecTypeController@types')->name('typeselec');
Route::get('elec/types', ['as'=>'electrical.types','uses'=>'DelecTypeController@typeselec']); // for datatable
Route::post('updatetypeselec','DelecTypeController@update')->name('updatetypeselec');
Route::post('deletetypeselec','DelecTypeController@destroy')->name('deletetypeselec');

Route::resource('insts','DinstUiController'); 
Route::get('insts','DinstUiController@create')->name('insts');
Route::get('instruments/indexinst', ['as'=>'instruments.indexinst','uses'=>'DinstUIController@index']); // for datatable
Route::get('instruments/einsts', ['as'=>'instruments.einstsfullquery','uses'=>'DinstUIController@einstsfullquery']); // for datatable
Route::get('instruments/modeled', ['as'=>'instruments.dinstsfullquery','uses'=>'DinstUIController@dinstsfullquery']); // for datatable
Route::get('/einsts', 'DinstUiController@einsts')->name('einsts');
Route::post('deleinst','DinstUIController@destroy')->name('deleinst');
Route::post('updateinst','DinstUiController@update')->name('updateinst');
Route::post('deleteinst','DinstUiController@destroy')->name('deleteinst');
Route::get('/glineinst', 'DinstUiController@gline')->name('glineinst');
Route::post('/glineinst', 'DinstUiController@gline')->name('glineinst');
Route::get('/glineinsttotal', 'DinstUiController@glineTotal')->name('glineinsttotal');
Route::get('/modeledinst', 'DinstUiController@modeled')->name('modeledinst');
Route::get('/milestoneinst', 'DinstUiController@milestone')->name('milestoneinst');
Route::get('inst/milestone', ['as'=>'instruments.milestone','uses'=>'DinstUIController@milestoneinst']); // for datatable

Route::resource('typesinst','DinstTypeController'); 
Route::get('/typesinst', 'DinstTypeController@types')->name('typesinst');
Route::get('inst/types', ['as'=>'instruments.types','uses'=>'DinstTypeController@typesinst']); // for datatable
Route::post('updatetypesinst','DinstTypeController@update')->name('updatetypesinst');
Route::post('deletetypesinst','DinstTypeController@destroy')->name('deletetypesinst');



Route::resource('civils','DcivilUiController'); 
Route::get('civils','DcivilUiController@create')->name('civils');
Route::get('civil/indexcivil', ['as'=>'civil.indexcivil','uses'=>'DcivilUIController@index']); // for datatable
Route::get('civil/ecivils', ['as'=>'civil.ecivilsfullquery','uses'=>'DcivilUIController@ecivilsfullquery']); // for datatable
Route::get('civil/modeled', ['as'=>'civil.dcivilsfullquery','uses'=>'DcivilUIController@dcivilsfullquery']); // for datatable
Route::get('/ecivils', 'DcivilUiController@ecivils')->name('ecivils');
Route::post('updatecivil','DcivilUiController@update')->name('updatecivil');
Route::post('delecivil','DcivilUIController@destroy')->name('delecivil');
Route::post('deletecivil','DcivilUiController@destroy')->name('deletecivil');
Route::get('/glinecivil', 'DcivilUiController@gline')->name('glinecivil');
Route::post('/glinecivil', 'DcivilUiController@gline')->name('glinecivil');
Route::get('/glineciviltotal', 'DcivilUiController@glineTotal')->name('glineciviltotal');
Route::get('/modeledcivil', 'DcivilUiController@modeled')->name('modeledcivil');
Route::get('/milestonecivil', 'DcivilUiController@milestone')->name('milestonecivil');
Route::get('civil/milestone', ['as'=>'civil.milestone','uses'=>'DcivilUIController@milestonecivil']); // for datatable

Route::resource('typescivil','DcivilTypeController'); 
Route::get('/typescivil', 'DcivilTypeController@types')->name('typescivil');
Route::get('civil/types', ['as'=>'civil.types','uses'=>'DcivilTypeController@typescivil']); // for datatable
Route::post('updatetypescivil','DcivilTypeController@update')->name('updatetypescivil');
Route::post('deletetypescivil','DcivilTypeController@destroy')->name('deletetypescivil');



Route::resource('equipments','DequiUiController'); 
Route::get('equipments','DequiUiController@create')->name('equipments');
Route::get('equipment/indexequi', ['as'=>'equipment.indexequi','uses'=>'DequiUIController@index']); // for datatable
Route::get('equipment/eequis', ['as'=>'equipment.eequisfullquery','uses'=>'DequiUIController@eequisfullquery']); // for datatable
Route::get('equipment/modeled', ['as'=>'equipment.dequisfullquery','uses'=>'DequiUIController@dequisfullquery']); // for datatable
Route::get('/eequis', 'DequiUiController@eequis')->name('eequis');
Route::post('deleequi','DequiUIController@destroy')->name('deleequi');
Route::post('updateequi','DequiUiController@update')->name('updateequi');
// Route::post('deleteequi','DequiUiController@destroy')->name('deleteequi');
Route::get('/glineequi', 'DequiUiController@gline')->name('glineequi');
Route::post('/glineequi', 'DequiUiController@gline')->name('glineequi');
Route::get('/glineequitotal', 'DequiUiController@glineTotal')->name('glineequitotal');
Route::get('/modeledequi', 'DequiUiController@modeled')->name('modeledequi');
Route::get('/milestoneequi', 'DequiUiController@milestone')->name('milestoneequi');
Route::get('equipment/milestone', ['as'=>'equipment.milestone','uses'=>'DequiUIController@milestoneEqui']); // for datatable


Route::resource('typesequi','DequiTypeController'); 
Route::get('/typesequi', 'DequiTypeController@types')->name('typesequi');
Route::get('equipment/types', ['as'=>'equipment.types','uses'=>'DequiTypeController@typesEqui']); // for datatable
Route::post('updatetypesequi','DequiTypeController@update')->name('updatetypesequi');
Route::post('deletetypesequi','DequiTypeController@destroy')->name('deletetypesequi');


Route::resource('pipes','DpipeUiController'); 
Route::get('pipes','DpipeUiController@create')->name('pipes');
Route::get('piping/indexpipe', ['as'=>'piping.indexpipe','uses'=>'DpipeUIController@index']); // for datatable
Route::get('piping/epipes', ['as'=>'piping.epipesfullquery','uses'=>'DpipeUIController@epipesfullquery']); // for datatable
Route::get('/epipes', 'DpipeUiController@epipes')->name('epipes');
Route::post('delepipe','DpipeUIController@destroy')->name('delepipe');
//Route::get('piping/ldlpipe', ['as'=>'piping.ldlpipe','uses'=>'DpipeUIController@ldl']); // for datatable
Route::post('updatepipe','DpipeUiController@update')->name('updatepipe');
Route::post('storecnotes','DpipeUiController@store')->name('storecnotes');
Route::post('deletepipe','DpipeUiController@destroy')->name('deletepipe');
Route::get('/modeledpipe', 'DpipeUiController@modeled')->name('modeledpipe');
Route::get('/glinepipe', 'DpipeUiController@gline')->name('glinepipe');
Route::post('/glinepipe', 'DpipeUiController@gline')->name('glinepipe');
Route::get('/glinepipetotal', 'DpipeUiController@glineTotal')->name('glinepipetotal');
Route::post('/jsppipe', 'DpipeUiController@jsppipe')->name('jsppipe');
Route::post('/jscnotes', 'DpipeUiController@jscnotes')->name('jscnotes');
Route::post('deletecnotes','DpipeUiController@destroycnotes')->name('deletecnotes');

//Pipe Filter
Route::resource('filterpipes','DpipeFilterController');
Route::get('filterpipes','DpipeFilterController@filter')->name('filterpipes');
Route::get('piping/filter', ['as'=>'piping.filter','uses'=>'DpipeFilterController@filterPipes']); // for datatable
Route::post('deletefilterpipes','DpipeFilterController@destroy')->name('deletefilterpipes');

// Pipe Milestone
Route::resource('milestonespipe','PmanagerUiController'); 
Route::get('/milestonespipe', 'PmanagerUiController@mpipes')->name('milestonespipe');
Route::get('piping/milestones', ['as'=>'piping.milestones','uses'=>'PmanagerUiController@milestonespipe']); // for datatable
Route::post('updatemilestonespipe','PmanagerUiController@updatemilestonespipe')->name('updatemilestonespipe');

// Equi Milestone
Route::resource('milestonesequi','PmanagerUiController'); 
Route::get('/milestonesequi', 'PmanagerUiController@mequis')->name('milestonesequi');
Route::get('equipment/milestones', ['as'=>'equipment.milestones','uses'=>'PmanagerUiController@milestonesequi']); // for datatable
Route::post('updatemilestonesequi','PmanagerUiController@updatemilestonesequi')->name('updatemilestonesequi');

// Civil Milestone
Route::resource('milestonescivil','PmanagerUiController'); 
Route::get('/milestonescivil', 'PmanagerUiController@mcivils')->name('milestonescivil');
Route::get('civil/milestones', ['as'=>'civil.milestones','uses'=>'PmanagerUiController@milestonescivil']); // for datatable
Route::post('updatemilestonescivil','PmanagerUiController@updatemilestonescivil')->name('updatemilestonescivil');

// Inst Milestone
Route::resource('milestonesinst','PmanagerUiController'); 
Route::get('/milestonesinst', 'PmanagerUiController@minsts')->name('milestonesinst');
Route::get('instruments/milestones', ['as'=>'instruments.milestones','uses'=>'PmanagerUiController@milestonesinst']); // for datatable
Route::post('updatemilestonesinst','PmanagerUiController@updatemilestonesinst')->name('updatemilestonesinst');

// Elec Milestone
Route::resource('milestonesinst','PmanagerUiController'); 
Route::get('/milestonesinst', 'PmanagerUiController@minsts')->name('milestonesinst');
Route::get('inst/milestones', ['as'=>'inst.milestones','uses'=>'PmanagerUiController@milestonesinst']); // for datatable
Route::post('updatemilestonesinst','PmanagerUiController@updatemilestonesinst')->name('updatemilestonesinst');

//Route::resource('ldlpipes','DldlpipeUiController'); 
// Route::get('piping/ldlpipes', ['as'=>'piping.index','uses'=>'DpipeUIController@index']); // for datatable
// Route::get('ldlpipes','DldlpipeUiController@index')->name('ldlpipes');

//Route::get('/', 'DldlpipeUiController@index');

//Route::get('/ldlpipes', 'DldlpipeUiController@indexTasks')->name('datatable.ldlpipes');
//Route::get('createlinewindow','DldlpipeUiController@create')->name('createlinewindow');

//Route::resource('ldlpipe','DldlpipeUiController'); 

Route::get('ldlpipes', 'DldlpipeUiController@index');
Route::get('getDatatableLdl', ['as'=>'piping.ldlpipe','uses'=>'DldlpipeUiController@getDatatableLdl']);
Route::get('createlinewindow','DldlpipeUiController@create')->name('createlinewindow');


//Holds by Marcos Miguel
Route::resource('holds','DpipeUiController'); 
Route::get('/holds', 'DpipeUiController@holds')->name('holds');
Route::get('piping/holds', ['as'=>'piping.holds','uses'=>'DpipeUiController@holdspipes']);


Route::post('/jshold', 'DpipeUiController@jshold')->name('jshold');


$router->get('importholds', 'HoldsController@importholds');

//FIN Holds by Marcos Miguel





$router->get('importdcivil', 'DcivilImportController@importdcivil');
$router->get('importdinst', 'DinstImportController@importdinst');
$router->get('importdelec', 'DelecImportController@importdelec'); //DO IT
$router->get('importdelecdistboards', 'DelecdistboardsImportController@importdelecdistboards');
$router->get('importdelecjunt', 'DelecjuntImportController@importdelecjunt');
$router->get('importdeleclight', 'DeleclightImportController@importdeleclight');
$router->get('importdelectray', 'DelectrayImportController@importdelectray');
$router->get('importdequi', 'DequiImportController@importdequi');
$router->get('importdinstfg', 'DinstfgImportController@importdinstfg');
$router->get('importdinstinst', 'DinstinstImportController@importdinstinst');
$router->get('importdinstjunct', 'DinstjunctImportController@importdinstjunct');
$router->get('importdinstmani', 'DinstmaniImportController@importdinstmani');
$router->get('importdinstpanel', 'DinstpanelImportController@importdinstpanel');
$router->get('importdinsttray', 'DinsttrayImportController@importdinsttray');
$router->get('importdpipe', 'DpipeImportController@importdpipe');
$router->get('exportpipe', 'PipeExportController@exportpipe');
$router->get('exportequi', 'EquiExportController@exportequi');
$router->get('exportmodeledequi', 'EquiExportController@exportmodeledequi');
$router->get('exportmodeledcivil', 'CivilExportController@exportmodeledcivil');
$router->get('exportmodeledinst', 'InstExportController@exportmodeledinst');
$router->get('exportmodeledelec', 'ElecExportController@exportmodeledelec'); //DO IT
$router->get('exporttypeequi', 'EquiExportController@exporttypeequi');
$router->get('exporttypecivil', 'CivilExportController@exporttypecivil');
$router->get('exporttypeinst', 'InstExportController@exporttypeinst');
$router->get('exporttypeelec', 'ElecExportController@exporttypeelec');//DO IT
$router->get('importdstation', 'DstationImportController@importdstation');
$router->get('importdstru', 'DstruImportController@importdstru');

$router->get('importpcivil', 'PcivilImportController@importpcivil');
$router->get('importpinst', 'PinstImportController@importpinst');
$router->get('importpelec', 'PelecImportController@importpelec');//DO IT
$router->get('importppipesupport', 'PpipesupportImportController@importppipesupport');
$router->get('importppipeiso', 'PpipeisoImportController@importppipeiso');
$router->get('importppipestress', 'PpipestressImportController@importppipestress');
$router->get('importppipepid', 'PpipepidImportController@importppipepid');
$router->get('importpequi', 'PequiImportController@importpequi');

$router->get('importunit', 'UnitImportController@importunit');
$router->get('importarea', 'AreaImportController@importarea');
$router->get('importeequi', 'EequiImportController@importeequi');
$router->get('importecivil', 'EcivilImportController@importecivil');
$router->get('importeinst', 'EinstImportController@importeinst');
$router->get('importeelec', 'EelecImportController@importeelec');//DO IT
$router->get('importepipe', 'EpipesImportController@importepipe');
$router->get('importtpipe', 'TpipeImportController@importtpipe');
$router->get('importmequi', 'MequiImportController@importMequi');
$router->get('importmcivil', 'McivilImportController@importMcivil');
$router->get('importminst', 'MinstImportController@importMinst');
$router->get('importmelec', 'MelecImportController@importMelec');//DO IT
$router->get('importtcivil', 'TcivilImportController@importTcivil');
$router->get('importtinst', 'TinstImportController@importTinst');
$router->get('importtelec', 'TelecImportController@importTelec');//DO IT
$router->get('importtequi', 'TequiImportController@importtequi');
$router->get('importdiam', 'DiamImportController@importDiam');
$router->get('importspec', 'SpecImportController@importspec');
$router->get('importfluid', 'FluidImportController@importfluid');
$router->get('importfludesc', 'FluDescImportController@importfludesc');
$router->get('importflupha', 'FluPhaImportController@importflupha');
$router->get('importinscod', 'InsCodImportController@importinscod');


$router->get('updateequimilestone', 'DequiUIController@updateMilestone');
$router->get('updatecivilmilestone', 'DcivilUIController@updateMilestone');
$router->get('updateinstmilestone', 'DinstUIController@updateMilestone');
$router->get('updateelecmilestone', 'DelecUIController@updateMilestone');//DO IT


Route::get('dcivildatatable', ['uses'=>'DcivilDatatableController@dcivildatatable']);
Route::get('dcivildatatable/dcivilgetposts', ['as'=>'dcivildatatable.dcivilgetposts','uses'=>'DcivilDatatableController@dcivilgetPosts']);

Route::get('dcivildatatable', ['uses'=>'DcivilDatatableController@dcivildatatable']);
Route::get('dcivildatatable/dcivilgetposts', ['as'=>'dcivildatatable.dcivilgetposts','uses'=>'DcivilDatatableController@dcivilgetPosts']);

Route::get('dinstdatatable', ['uses'=>'DinstDatatableController@dinstdatatable']);
Route::get('dinstdatatable/dinstgetposts', ['as'=>'dinstdatatable.dinstgetposts','uses'=>'DinstDatatableController@dinstgetPosts']);

Route::get('delecdistboardsdatatable', ['uses'=>'DelecdistboardsDatatableController@delecdistboardsdatatable']);
Route::get('delecdistboardsdatatable/delecdistboardsgetposts', ['as'=>'delecdistboardsdatatable.delecdistboardsgetposts','uses'=>'DelecdistboardsDatatableController@delecdistboardsgetPosts']);

Route::get('delecjuntsdatatable', ['uses'=>'DelecjuntsDatatableController@delecjuntsdatatable']);
Route::get('delecjuntsdatatable/delecjuntsgetposts', ['as'=>'delecjuntsdatatable.delecjuntsgetposts','uses'=>'DelecjuntsDatatableController@delecjuntsgetPosts']);

Route::get('deleclightsdatatable', ['uses'=>'DeleclightsDatatableController@deleclightsdatatable']);
Route::get('deleclightsdatatable/deleclightsgetposts', ['as'=>'deleclightsdatatable.deleclightsgetposts','uses'=>'DeleclightsDatatableController@deleclightsgetPosts']);

Route::get('dpipedatatable', ['uses'=>'DpipeDatatableController@dpipedatatable']);
Route::get('dpipedatatable/dpipegetposts', ['as'=>'dpipedatatable.dpipegetposts','uses'=>'DpipeDatatableController@dpipegetPosts']);
Route::get('dpipedatatable/dpipegetareas', ['as'=>'dpipedatatable.dpipegetareas','uses'=>'DpipeDatatableController@dpipegetAreas']);

// Route::get('dpipedatatable/dpipegetmodeled', ['as'=>'dpipedatatable.dpipegetmodeled','uses'=>'DpipeDatatableController@dpipegetModeled']);

Route::get('dequidatatable', ['uses'=>'DequiDatatableController@dequidatatable']);
Route::get('dequidatatable/dequigetposts', ['as'=>'dequidatatable.dequigetposts','uses'=>'DequiDatatableController@dequigetPosts']);
Route::get('dequidatatable/dequigetprogress', ['as'=>'dequidatatable.dequigetprogress','uses'=>'DequiDatatableController@dequigetProgress']);
Route::get('dequidatatable/dequigetprogressbyarea', ['as'=>'dequidatatable.dequigetprogressbyarea','uses'=>'DequiDatatableController@dequigetProgressByArea']);
Route::get('dequidatatable/dequichartprogress', ['as'=>'dequidatatable.dequichartprogress','uses'=>'DequiDatatableController@dequiChartProgress']);
Route::get('dequidatatable/dequilineprogress', ['as'=>'dequidatatable.dequilineprogress','uses'=>'DequiDatatableController@dequiLineProgress']);

Route::get('dcivildatatable', ['uses'=>'DcivilDatatableController@dcivildatatable']);
Route::get('dcivildatatable/dcivilgetposts', ['as'=>'dcivildatatable.dcivilgetposts','uses'=>'DcivilDatatableController@dcivilgetPosts']);
Route::get('dcivildatatable/dcivilgetprogress', ['as'=>'dcivildatatable.dcivilgetprogress','uses'=>'DcivilDatatableController@dcivilgetProgress']);
Route::get('dcivildatatable/dcivilgetprogressbyarea', ['as'=>'dcivildatatable.dcivilgetprogressbyarea','uses'=>'DcivilDatatableController@dcivilgetProgressByArea']);
Route::get('dcivildatatable/dcivilchartprogress', ['as'=>'dcivildatatable.dcivilchartprogress','uses'=>'DcivilDatatableController@dcivilChartProgress']);
Route::get('dcivildatatable/dcivillineprogress', ['as'=>'dcivildatatable.dcivillineprogress','uses'=>'DcivilDatatableController@dcivilLineProgress']);

Route::get('dinstdatatable', ['uses'=>'DinstDatatableController@dinstdatatable']);
Route::get('dinstdatatable/dinstgetposts', ['as'=>'dinstdatatable.dinstgetposts','uses'=>'DinstDatatableController@dinstgetPosts']);
Route::get('dinstdatatable/dinstgetprogress', ['as'=>'dinstdatatable.dinstgetprogress','uses'=>'DinstDatatableController@dinstgetProgress']);
Route::get('dinstdatatable/dinstgetprogressbyarea', ['as'=>'dinstdatatable.dinstgetprogressbyarea','uses'=>'DinstDatatableController@dinstgetProgressByArea']);
Route::get('dinstdatatable/dinstchartprogress', ['as'=>'dinstdatatable.dinstchartprogress','uses'=>'DinstDatatableController@dinstChartProgress']);
Route::get('dinstdatatable/dinstlineprogress', ['as'=>'dinstdatatable.dinstlineprogress','uses'=>'DinstDatatableController@dinstLineProgress']);


Route::get('delecdatatable', ['uses'=>'DelecDatatableController@delecdatatable']);
Route::get('delecdatatable/delecgetposts', ['as'=>'delecdatatable.delecgetposts','uses'=>'DelecDatatableController@delecgetPosts']);
Route::get('delecdatatable/delecgetprogress', ['as'=>'delecdatatable.delecgetprogress','uses'=>'DelecDatatableController@delecgetProgress']);
Route::get('delecdatatable/delecgetprogressbyarea', ['as'=>'delecdatatable.delecgetprogressbyarea','uses'=>'DelecDatatableController@delecgetProgressByArea']);
Route::get('delecdatatable/delecchartprogress', ['as'=>'delecdatatable.delecchartprogress','uses'=>'DelecDatatableController@delecChartProgress']);
Route::get('delecdatatable/deleclineprogress', ['as'=>'delecdatatable.deleclineprogress','uses'=>'DelecDatatableController@delecLineProgress']); //DO IT

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/homeload', 'HomeloadController@homeload')->name('homeload');
Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
Route::get('/glineprogresstotal', 'HomeController@glineprogresstotal')->name('glineprogresstotal');

Route::get('/pmanager', 'PmanagerUiController@pmanager')->name('pmanager');
Route::post('updatepmanager','PmanagerUiController@update')->name('updatepmanager');
Route::post('updatewtpipe','PmanagerUiController@updatewtpipe')->name('updatewtpipe');
Route::post('updatepmanagerb','PmanagerUiController@updateb')->name('updatepmanagerb'); // B por submit para segunda parte del formulario
Route::get('/summary_pmanager', 'PmanagerUiController@summary_pmanager')->name('summary_pmanager');

// FEED
Route::get('/feed', 'PmanagerUiController@feed')->name('feed');

// Validator contraseña
Route::get('/user', 'UserController@user')->name('user');
Route::get('/password', 'UserController@password')->name('password');
Route::get('user/password', 'UserController@password');
Route::post('user/updatepassword', 'UserController@updatePassword');

// Users
Route::resource('indexusers','UserController'); 
Route::get('/indexusers', 'UserController@index')->name('indexusers');
Route::get('user/index', ['as'=>'user.index','uses'=>'UserController@indexUsers']); // for datatable
Route::post('/jsuroles', 'UserController@jsuroles')->name('jsuroles');





// Test LOG
Route::get('test', function () {
    try {
        // La variable no existe
        return $test_var;
    } catch (\Exception $e) {
        // Almacenamos la información del error.
        \Log::debug('Test var fails' . $e->getMessage());
    }
});