<?php
/**
 * Created by PhpStorm.
 * User: praveen
 * Date: 10/11/17
 * Time: 10:31 AM
 */

namespace App\Extras;

class Repo {
    const DEFAULT_LANG = "en";
    
    function __construct($lang = null)
    {
        if (is_null($lang)) $lang = self::DEFAULT_LANG;
        
        $path = storage_path("languages/{$lang}.json");
        $file = (file_exists($path)) ? $path : storage_path("languages/".self::DEFAULT_LANG.".json");
        
        $arr = json_decode(file_get_contents($file), true);
        
        $arr['lang']['options'] = $this->languageLookup(false);
        
        foreach ($arr as $key => $value) {
            $this->$key = $value;
        }
        
        
    }
    
    public function all($record = null) {
        if (is_null($record))
            return get_object_vars($this);
        
        $firstName = explode(" ", $record->name)[0];
        
        foreach ($this->questions as $key => $question) {
            $this->questions[$key]['text'] = str_replace("you", $firstName, $question['text']);
            $keyname = "question".($key + 1);
            $this->questions[$key]['answ'] = $record->$keyname;
        }
        
        return get_object_vars($this);
    }
    
    public function languageLookup($lang = false)
    {
        $table = [
            "English US" => "en",
            "English India" => "in",
            "Hindi" => "hi",
        ];
    
        if ($lang === false) {
            $newTable = [];
            
            foreach ($table as $key => $value) {
                $newTable[] = [
                    'key' => $key,
                    'value' => $value,
            ];  }
            return $newTable;
        };
    
        return (isset($table[$lang]) ? $table[$lang] : self::DEFAULT_LANG);
    }
}