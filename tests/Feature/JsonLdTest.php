<?php

// ─── Helper ──────────────────────────────────────────────────────────────────

function extractJsonLd(string $html): ?array
{
    preg_match('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $m);

    if (empty($m[1])) {
        return null;
    }

    return json_decode($m[1], true);
}

// ─── TravelAgency (home & contact) ───────────────────────────────────────────

it('home JSON-LD decodes to valid TravelAgency schema', function () {
    $data = extractJsonLd($this->get(route('home'))->getContent());

    expect($data)->not->toBeNull()
        ->and($data['@context'])->toBe('https://schema.org')
        ->and($data['@type'])->toBe('TravelAgency')
        ->and($data['name'])->toBe('Mijn Amor Travel')
        ->and($data['telephone'])->toBe('+310612397002')
        ->and($data['email'])->toBe('mjinamor@yahoo.com');
});

it('contact JSON-LD decodes to valid TravelAgency schema', function () {
    $data = extractJsonLd($this->get(route('contact'))->getContent());

    expect($data)->not->toBeNull()
        ->and($data['@context'])->toBe('https://schema.org')
        ->and($data['@type'])->toBe('TravelAgency');
});

// ─── Encoding safety ─────────────────────────────────────────────────────────

it('json_encode flags safely handle &, quotes, and </script> in values', function () {
    $flags = JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP;

    $input = [
        '@context' => 'https://schema.org',
        '@type' => 'Test & <script>"quoted"</script>',
        'url' => 'https://example.com/?a=1&b=2',
    ];

    $json = json_encode($input, $flags);

    // </script> must not appear literally — would break the HTML script tag
    expect($json)->not->toContain('</script>')
        // & must be & — prevents HTML entity injection
        ->and($json)->not->toContain('&b=')
        // Round-trip: original values must be fully recoverable
        ->and(json_decode($json, true)['@type'])->toBe($input['@type'])
        ->and(json_decode($json, true)['url'])->toBe($input['url']);
});
