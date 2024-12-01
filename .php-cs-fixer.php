<?php

declare(strict_types=1);
use PhpCsFixer\Config;
use PhpCsFixer\Finder;

return
    (new Config())
        ->setFinder(
            Finder::create()
                ->in([
                    __DIR__ . '/app',
                    __DIR__ . '/config',
                    __DIR__ . '/database',
                    __DIR__ . '/public',
                    __DIR__ . '/resources',
                    __DIR__ . '/routes',
                    __DIR__ . '/tests',
                ])
                ->exclude([
                    // https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/3317
                    'factories',
                ])
                ->append([
                    __FILE__,
                ])
        )
        ->setRules([
            '@PSR12' => true,
            '@PSR12:risky' => true,
            '@Symfony' => true,
            '@Symfony:risky' => true,
            '@PhpCsFixer' => true,
            '@PhpCsFixer:risky' => true,
            '@PHP81Migration' => true,
            '@PHP80Migration:risky' => true,
            '@PHPUnit84Migration:risky' => true,

            'ordered_imports' => ['imports_order' => ['class', 'function', 'const']],

            'concat_space' => ['spacing' => 'one'],
            // 'cast_spaces' => ['space' => 'none'],
            'binary_operator_spaces' => false,
            'trim_array_spaces' => false,

            'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
            'phpdoc_align' => ['align' => 'left'],
            'phpdoc_line_span' => true,
            // 'phpdoc_to_param_type' => true,
            // 'phpdoc_to_property_type' => true,
            // 'phpdoc_to_return_type' => true,
            'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
            'comment_to_phpdoc' => false,
            'phpdoc_to_comment' => false,
            'phpdoc_no_empty_return' => false,
            'phpdoc_separation' => false,
            'no_superfluous_phpdoc_tags' => false,
            'single_line_comment_style' => false,
            'no_empty_comment' => false,
            'no_extra_blank_lines' => false,

            // 'operator_linebreak' => false,

            'global_namespace_import' => false,
            'native_function_invocation' => false,

            'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],

            'fopen_flags' => ['b_mode' => true],

            'php_unit_strict' => false,
            'php_unit_test_class_requires_covers' => false,
            'php_unit_test_case_static_method_calls' => ['call_type' => 'self'],
            'php_unit_method_casing' => ['case' => 'snake_case'],
            // 'php_unit_test_annotation' => ['style' => 'annotation'],
            'php_unit_internal_class' => false,

            'yoda_style' => false,

            'final_class' => false,
            // 'final_public_method_for_abstract_class' => true,
            'self_static_accessor' => true,

            'simplified_if_return' => false,
            'simplified_null_return' => true,

            'strict_comparison' => false,
            'strict_param' => false,

            'use_arrow_functions' => false,

            'static_lambda' => false,
            'octal_notation' => false,

            'phpdoc_order' => false, // todo: enable after merge all MRs
        ]);
