<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR12' => true,

        // Строгие типы
        'declare_strict_types' => true,

        // Массивы всегда короткие
        'array_syntax' => ['syntax' => 'short'],

        // Упорядоченные импорты (группировка use)
        'ordered_imports' => ['sort_algorithm' => 'alpha'],

        // Чистим неиспользуемые use
        'no_unused_imports' => true,

        // На каждое объявление должно быть одно ключевое слово use
        'single_import_per_statement' => true,

        // Не нужны лишние пустые комментарии
        'no_empty_comment' => true,

        // Убираем пустые PHPDoc, если они не содержат полезной информации
        'no_superfluous_phpdoc_tags' => true,

        // Чистим лишние пустые строки
        'no_extra_blank_lines' => [
            'tokens' => [
                'throw',
                'use',
                'extra',
                'return',
                'continue',
                'break',
                'case',
                'default',
            ]
        ],

        // Запрет пробелов после открывающей фигурной скобки
        'braces_position' => true,

        // Запрещаем trailing comma в однострочных массивах
        'trailing_comma_in_multiline' => ['after_heredoc' => true],

        // Запрещаем несколько подряд пустых строк
        'no_multiple_statements_per_line' => true,

        // Чистим ненужные пустые конструкторы
        // composer require --dev friendsofphp/php-cs-fixer:^3.80
        //'no_useless_constructor' => true,

        // Запрещаем конструкторы в стиле PHP4
        'no_php4_constructor' => true,

        // Приведение типов без лишних скобок
        'cast_spaces' => ['space' => 'single'],

        // Отступы в switch/case как в PSR-12
        'switch_case_space' => true,

        // Строгая пустота
        'no_empty_phpdoc' => true,

        // Как выравниваются пробелы вокруг бинарных операторов
        'binary_operator_spaces' => ['operators' => ['=>' => 'align_single_space']],

        // Добавить пустую строку
        'blank_line_after_opening_tag' => true,

        // Добавить пустую строку после declare
        // composer require --dev friendsofphp/php-cs-fixer:^3.89
        //'blank_line_after_declare' => true,

        // Порядок в PHPDoc
        'phpdoc_trim' => true,
        'phpdoc_separation' => false,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_order' => true,

        // Замена 'ClassName' на ClassName::class
        'class_keyword' => true,
    ])
    ->setFinder($finder);
