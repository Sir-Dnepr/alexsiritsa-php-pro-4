<?php

spl_autoload_register(function ($className) {
    $prefix = 'App\\';

    // does the class use the namespace prefix?
    $prefixLen = strlen($prefix);

    if (strncmp($prefix, $className, $prefixLen) !== 0) {
        return;
    }

    // get the relative class name
    $relativeClass = substr($className, $prefixLen);

    // Construct the full path to the class file
    $baseDir = __DIR__ . '/../src/';

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $classFile = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    // if the file exists, require it
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});
