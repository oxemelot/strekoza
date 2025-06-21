<?php

declare(strict_types=1);

$directory = $argv[1] ?? '.';
$dryRun = in_array('--dry-run', $argv);

$iterator = new RecursiveIteratorIterator(
    new RecursiveCallbackFilterIterator(
        new RecursiveDirectoryIterator($directory),
        function ($file, $key, $iterator) {
            if ($iterator->hasChildren() && preg_match('#^(vendor|\.git|\.idea|\.vscode)$#', $file->getFilename())) {
                return false;
            }
            return true;
        }
    )
);

$modifiedFiles = 0;

foreach ($iterator as $file) {
    /** @var $file SplFileInfo */
    if (!$file->isFile() || $file->getExtension() !== 'php') {
        continue;
    }

    $path = $file->getPathname();
    $originalContent = file_get_contents($path);

    // Удаляем первое <?php
    $modifiedContent = preg_replace('/^\s*<\?php\s*/', '', $originalContent, 1);
    $modifiedContent = ltrim($modifiedContent);

    // Ищем declare(strict_types=1);
    preg_match('/^declare\(strict_types=1\);\s*/m', $modifiedContent, $declareMatches);
    $declareBlock = $declareMatches[0] ?? '';
    if ($declareBlock) {
        $modifiedContent = preg_replace('/^declare\(strict_types=1\);\s*/m', '', $modifiedContent, 1);
    }

    // Ищем namespace (если есть)
    preg_match('/^namespace\s+[^;]+;/m', $modifiedContent, $namespaceMatches);
    $namespaceBlock = $namespaceMatches[0] ?? '';
    if ($namespaceBlock) {
        $modifiedContent = preg_replace('/^namespace\s+[^;]+;/m', '', $modifiedContent, 1);
    }

    // Ищем use блоки
    preg_match_all('/^use\s+[^;]+;/m', $modifiedContent, $useMatches);
    $useBlock = implode("\n", $useMatches[0]);
    $modifiedContent = preg_replace('/^use\s+[^;]+;/m', '', $modifiedContent);

    // Ищем phpdoc vars в начале
    if (preg_match('/\A\s*(\/\*\*(?:\s*\*\s*@var[^\n]+\n)+\s*\*\/)/', $modifiedContent, $varBlock)) {
        $varBlockText = $varBlock[1];
        $modifiedContent = preg_replace('/\A\s*(\/\*\*(?:\s*\*\s*@var[^\n]+\n)+\s*\*\/)/', '', $modifiedContent, 1);
    } else {
        $varBlockText = '';
    }

    // Убираем множественные пустые строки
    $modifiedContent = preg_replace("/\n{3,}/", "\n\n", $modifiedContent);
    $modifiedContent = ltrim($modifiedContent);

    // Собираем итоговый файл
    $newContent = "<?php\n\n";

    if ($declareBlock) {
        $newContent .= trim($declareBlock) . "\n\n";
    }

    if ($namespaceBlock) {
        $newContent .= trim($namespaceBlock) . "\n\n";
    }

    if ($useBlock) {
        $newContent .= trim($useBlock) . "\n\n";
    }

    if ($varBlockText) {
        $newContent .= trim($varBlockText) . "\n\n";
    }

    $newContent .= $modifiedContent;

    // Если изменилось — сохраняем
    if ($newContent !== $originalContent) {
        $modifiedFiles++;
        echo "[MODIFIED] $path\n";
        if (!$dryRun) {
            file_put_contents($path, $newContent);
        }
    }
}

echo "Done. Modified files: $modifiedFiles\n";
if ($dryRun) {
    echo "Dry-run mode: no changes written.\n";
}
