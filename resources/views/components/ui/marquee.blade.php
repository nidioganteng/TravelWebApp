@props([
    'reverse' => false,
    'pauseOnHover' => false,
    'vertical' => false,
    'repeat' => 4, // Default sama dengan React
])

<div {{ $attributes->merge(['class' => 'group flex overflow-hidden p-2 [--duration:40s] [--gap:1rem] gap-(--gap) ' . ($vertical ? 'flex-col' : 'flex-row')]) }}>
    {{-- Logic: Array(repeat).map(...) di React menjadi @for di sini --}}
    @for ($i = 0; $i < $repeat; $i++)
        <div class="flex shrink-0 justify-around gap-(--gap) {{ $vertical ? 'animate-marquee-vertical flex-col' : 'animate-marquee flex-row' }} {{ $pauseOnHover ? 'group-hover:[animation-play-state:paused]' : '' }} {{ $reverse ? '[animation-direction:reverse]' : '' }}">
            {{ $slot }}
        </div>
    @endfor
</div>