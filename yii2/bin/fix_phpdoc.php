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

    $newContent = preg_replace_callback(
        '#((?:/\*\*\s*@var\s+[^*]+\*/\s*){2,})#',
        function ($matches) {
            $block = $matches[1];
            preg_match_all('#/\*\*\s*@var\s+([^\s]+)\s+\$?([^\s]+)\s*\*/#', $block, $allMatches, PREG_SET_ORDER);

            if (count($allMatches) <= 1) {
                return $block;
            }

            $varLines = [];
            foreach ($allMatches as $m) {
                $varLines[] = [
                    'type' => $m[1],
                    'var'  => $m[2],
                ];
            }

            usort($varLines, function ($a, $b) {
                if ($a['var'] === 'this') {
                    return -1;
                }
                if ($b['var'] === 'this') {
                    return 1;
                }
                return strcmp($a['var'], $b['var']);
            });

            $newBlock = "/**\n";
            foreach ($varLines as $varLine) {
                $newBlock .= " * @var {$varLine['type']} \${$varLine['var']}\n";
            }
            $newBlock .= " */\n\n";

            return $newBlock;
        },
        $originalContent
    );

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
