<h1>{{ $concert->title }}</h1>
<h2>{{ $concert->subtitle }}</h2>
<p>{{ $concert->date->format('F j, Y') }}</p>
<p>{{ $concert->date->format('g:ia') }}</p>
<p>{{ number_format($concert->price / 100, 2) }}</p>
<p>{{ $concert->venue }}</p>
<p>{{ $concert->address }}</p>
<p>{{ $concert->city }}, {{ $concert->state }} {{ $concert->zip }}</p>
<p>{{ $concert->additional_information }}</p>