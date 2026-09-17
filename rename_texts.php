<?php
$dir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $originalContent = file_get_contents($path);
        
        $content = str_replace('Portail Humanitaire', 'Portail Partenaires', $originalContent);
        
        $content = str_replace('Coordination & Suivi', 'Rapportage des activités', $content);
        $content = str_replace('Coordination et Suivi', 'Rapportage des activités', $content);
        
        // Replace PH by PP but only when it is strictly between > and <
        $content = preg_replace('/>\s*PH\s*</', '>PP<', $content);
        
        if ($content !== $originalContent) {
            file_put_contents($path, $content);
            echo "Updated: " . basename($path) . "\n";
        }
    }
}
