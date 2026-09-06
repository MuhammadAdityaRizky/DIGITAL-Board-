<?php
$files = array_merge(glob('resources/views/admin/*.blade.php'), glob('resources/views/dosen/*.blade.php'));

$search = "form.addEventListener('submit', function(e) {\n                    if (form.checkValidity && !form.checkValidity()) {";
$replace = "form.addEventListener('submit', function(e) {\n                    if (e.defaultPrevented) return;\n                    if (form.checkValidity && !form.checkValidity()) {";

foreach($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, $search) !== false) {
        $content = str_replace($search, $replace, $content);
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
