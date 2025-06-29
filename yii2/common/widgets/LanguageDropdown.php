<?php

declare(strict_types=1);

namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

class LanguageDropdown extends Widget
{
    public array $languages = [
        'en' => '🇬🇧 English',
        'ru' => '🇷🇺 Русский',
    ];

    public string $buttonClass = 'btn btn-outline-secondary dropdown-toggle';
    public string $menuClass = 'dropdown-menu';

    public function run(): string
    {
        $current = Yii::$app->language;
        $currentLabel = $this->languages[$current] ?? strtoupper($current);

        $items = [];
        foreach ($this->languages as $code => $label) {
            $url = Url::current(['language' => $code]);
            $items[] = Html::a($label, $url, [
                'class' => 'dropdown-item' . ($code === $current ? ' active' : ''),
            ]);
        }

        return Html::tag(
            'div',
            Html::button($currentLabel, [
                'class'          => $this->buttonClass,
                'type'           => 'button',
                'data-bs-toggle' => 'dropdown',
                'aria-expanded'  => 'false',
            ]) .
            Html::tag('div', implode("\n", $items), ['class' => $this->menuClass]),
            ['class' => 'dropdown']
        );
    }
}
