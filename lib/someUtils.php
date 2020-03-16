<?php
    function loadPathsFile($file_path=null)  {
        /**
         * Recupera los paths de su fichero y los devuelve como un objeto
         */

        $file_path = '/var/www/html/PathsConfig.xml';

        if (file_exists($file_path)) {
            return simplexml_load_file($file_path);
        }

        return false;
    }

    function getPath( $path, $paths=null) {
        /**
         * Obtiene un path
         */
        if (empty($paths)) $paths = loadPathsFile();

        if (($wantedPath = path_exists($path, $paths)) == false) return false;

        $matching = true;
        $value = $wantedPath['value'];

        while (true) {
            if (($match = hasChildRoutes($value)) !== false) {
                // Hay match por lo que buscamos la ruta
                foreach ($match as $subPath) {
                    $subPathName = str_replace("%", "", $subPath);
                    if ($subPathNode = getPath($subPathName, $paths)) {
                        // Remplazamos el path con el valor del subpath encontrado
                        $value = str_replace($subPath, $subPathNode, $value);
                    }
                }
            } else {
                break;
            }
        }

        return $value;

    }

    function path_exists($key, $paths) {
        /**
         * Comprueba si un path existe
         */
        foreach ($paths->paths->path as $path) {
            if ($path['name'] == $key) {
                return $path;
            }
        }
        return false;
    }

    function hasChildRoutes( $path ) {
        /**
         * Retorna un valor booleano en funcion de si el path proporcionado es la raiz o tiene otros paths asociados
         */
        preg_match('/\%\w*\%/', $path, $match);

        return count($match) > 0 ? $match : false;
    }



    /** Cosa para las rutas de windows **/

    function parse_windows_path ($str) {
        return preg_replace('/(\\\\)+/m', '/', addslashes($str));
    }


    function json($endpoint, $array = [], $headers = []) {
        $curl = curl_init();

        if (!is_resource($curl)) {
            throw new \Exception();
        }

        $body = json_encode($array);

        $headers[] = "Content-Type: text/json";
        $headers[] = sprintf(
            "Content-Length: %d",
            strlen($body)
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($curl);
    }


    function sendFileWithCurl($url, $pathToFile, $params = []) {

        $curl = curl_init();

        if (!empty($pathToFile) && file_exists($pathToFile) && is_readable($pathToFile)) {
            if (class_exists('CurlFile')) {
                $params['file'] = new CurlFile($pathToFile, 'application/octet-stream');
            } else {
                $params['file'] = '@' . realpath($pathToFile);
            }
            curl_setopt($curl, CURLOPT_SAFE_UPLOAD, true);
        }else{
            echo "Unable to find file";
            return false;
        }

        if (!is_resource($curl)) {
            throw new \Exception();
        }

        $body      = $params;
        $headers   = [];
        $headers[] = "Content-Type: multipart/form-data";
        /*$headers[] = sprintf(
            "Content-Length: %d",
            strlen($body)
        );*/

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); # Puede que los headers no sean apropiados
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        return curl_exec($curl);
    }
?>


