<?php

use App\Models\TrackRecord;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    Cache::flush();
});

it('sitemap.xml returns 200 with application/xml content type', function () {
    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertHeader('Content-Type', 'application/xml');
});

it('sitemap.xml contains static public pages', function () {
    $content = $this->get('/sitemap.xml')->getContent();

    expect($content)->toContain(route('home'))
        ->and($content)->toContain(route('about'))
        ->and($content)->toContain(route('products'))
        ->and($content)->toContain(route('contact'));
});

it('sitemap.xml contains track record URLs', function () {
    $record = TrackRecord::factory()->create();

    Cache::flush();

    $content = $this->get('/sitemap.xml')->getContent();

    expect($content)->toContain(route('track-record.show', $record->slug));
});

it('sitemap.xml does not contain admin URLs', function () {
    $content = $this->get('/sitemap.xml')->getContent();

    expect($content)->not->toContain('/admin');
});

it('sitemap.xml is valid XML with urlset root element', function () {
    $content = $this->get('/sitemap.xml')->getContent();

    expect($content)->toContain('<?xml version="1.0" encoding="UTF-8"?>')
        ->and($content)->toContain('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
});
