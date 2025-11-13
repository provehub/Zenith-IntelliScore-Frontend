<x-mail::message>
   
# {{$subject}}
 <br>
 From {{$name}} <br>
{{$message}}
 <br>
    <x-mail::button :url="$url['url']">
        {{ $url['text'] }}
    </x-mail::button>
<br>
<br>
Warm regards,<br>
{{ config('app.name') }}
</x-mail::message>