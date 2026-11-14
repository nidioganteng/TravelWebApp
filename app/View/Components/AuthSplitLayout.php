<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AuthSplitLayout extends Component
{
    public array $slides;

    public function __construct()
    {
        $rawSlides = config('auth_ui.slides', [
            [
                'image' => 'img/homepage/assets/background_hero.png',
                'headline_key' => 'user.auth_headline',
                'description_key' => 'user.auth_subheadline',
            ],
        ]);

        $this->slides = collect($rawSlides)
            ->map(fn (array $slide) => [
                'image' => $slide['image'],
                'headline' => __($slide['headline_key']),
                'description' => __($slide['description_key']),
            ])
            ->all();
    }

    public function render(): View
    {
        return view('layouts.auth-split', ['slides' => $this->slides]);
    }
}
