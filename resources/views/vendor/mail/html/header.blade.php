@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/favicon.png') }}" class="logo" alt="SmartBuddy" style="height: 60px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
