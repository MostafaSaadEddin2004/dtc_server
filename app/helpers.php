<?php

if (! function_exists('storeImage')) {
    function storeImage($request, $imageName, $directory) {
            $image = $request->file($imageName);
            $name = $image->hashName();
            $request->file($imageName)->store('public/' . $directory);
            return $directory . '/' . $name;
    }
}
