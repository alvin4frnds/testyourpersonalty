<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Extras\Repo;
use App\Record;
use Illuminate\Http\Request;

$app->get('/', function() {
    return view('quiz', ['data' => (new Repo())->all(), 'lang' => null]);
});

$app->get('/{lang:[a-z]+}', function($lang) {
    return view('quiz', ['data' => (new Repo($lang))->all(), 'lang' => $lang]);
});

$app->get('/{id:[0-9]}', function($id) {
    $record = (new Record)->findOrFail($id);
    
    return view('quiz', ['data' => (new Repo($record->lang))->all($record), 'record' => $record->toArray()]);
});

$app->post('/', function(Request $request) {
    $all = $request->all();
    $all['lang'] = (new Repo())->languageLookup($request->lang);
    
    $record = (new Record)->create($all);
    
    $str = []; $result = "";
    foreach ($request->all() as $key => $value)
        if (strpos($key, "question") !== false) $str[] = $value;
    
    foreach ((new Repo)->all()['answers'] as $key => $value ) {
        $found = true; $value['key'] = $key;
        
        foreach ($str as $char) if(strpos($key, $char) === false) $found = false;
        
        if ($found) {
            $record->result = $key;
            $record->save();
            $result = $value;
        }
    }
    
    return array_merge($record->toArray(), [
        'result' => $result,
        'url' => url($record->id),
    ]);
});

$app->get('/app/version', function () use ($app) {
    return $app->version();
});
