<?php
class LoadEnv {
    public static function load($envs) {
        try {
            foreach($envs as $env){
                $lines = explode("\n", file_get_contents(CONFIG.'envs/'.$env));
                foreach($lines as $line){
                    preg_match("/([^#]+)\=(.*)/",$line, $matches);
                    if(isset($matches[2])){
                        $_ENV[trim($matches[1])] = trim($matches[2]);
                    }
                } 
            }
        } catch (\Throwable $th) {
            trigger_error("no env loaded", E_USER_NOTICE);
        }
    }
}
?>