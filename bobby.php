<?php

/**
 * $method is the first passed argument and refers to an action
 * that you want to execute.
 *
 * $element is the second passed argument and refers to the element
 * that you want to create.
 *
 * $name is the third element passed and refers to the name you
 * want to assign to the element
 *
 * i.e.:
 *
 * php bobby.php make controller Example
 */

$method  = $argv[1];
$element = $argv[2];
$name    = $argv[3];

switch ($method) {
    case 'make':
        make($element, $name);
}

function make(string $element, string $name)
{
    switch ($element) {
        case 'controller':
            makeController($name);
            break;
        case 'model':
            makeModel($name);
            break;
        case 'view':
            makeView($name);
    }
}

function makeController(string $name)
{
    $text = "<?php\n\nnamespace NanoPHP\Controllers;\n\nclass $name extends BaseController {\n\t\n}";
    $filepath = __DIR__ . "/src/NanoPHP/Controllers/$name.php";
    $fileCreated = createFile($filepath, $text);
    if ($fileCreated) {
        echo "Controller $name was created successfully!\n";
    }
}

function makeModel(string $name)
{
    $text = "<?php\n\nnamespace NanoPHP\Models;\n\nclass $name extends BaseModel {\n\tprotected \$tableName = \"$name\";\n}";
    $filepath = __DIR__ . "/src/NanoPHP/Views/$name.php";
    $fileCreated = createFile($filepath, $text);
    if ($fileCreated) {
        echo "View $name was created successfully!\n";
    }
}

function makeView(string $name)
{
    $text = "$name view";
    $filepath = __DIR__ . "/src/NanoPHP/Views/$name.php";
    $fileCreated = createFile($filepath, $text);
    if ($fileCreated) {
        echo "View $name was created successfully!\n";
    }
}

function createFile(string $filepath, string $text)
{
    try {
        checkFileExists($filepath);
        $file = fopen($filepath, "w");
        $fileWritten = fwrite($file, $text);
        $fileClosed = fclose($file);
    } catch (\Exception $e) {
        echo $e;
    }

    return $fileWritten && $fileClosed;
}

function checkFileExists(string $filepath)
{
    if (file_exists($filepath)) {
        echo "File $filepath already exists\n";
        exit();
    }
}
