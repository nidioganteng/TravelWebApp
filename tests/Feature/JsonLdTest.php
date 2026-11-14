<?php

it('home page contains TravelAgency JSON-LD script', function () {
    $content = $this->get(route('home'))->getContent();

    expect($content)->toContain('application/ld+json')
        ->and($content)->toContain('"@type": "TravelAgency"')
        ->and($content)->toContain('"name": "Mijn Amor Travel"');
});

it('contact page contains TravelAgency JSON-LD script', function () {
    $content = $this->get(route('contact'))->getContent();

    expect($content)->toContain('application/ld+json')
        ->and($content)->toContain('"@type": "TravelAgency"');
});

it('home JSON-LD contains telephone and email', function () {
    $content = $this->get(route('home'))->getContent();

    expect($content)->toContain('+310612397002')
        ->and($content)->toContain('mjinamor@yahoo.com');
});
