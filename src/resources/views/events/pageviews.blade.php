@extends('layout')

@section('title', 'Page Views')

@section('content')
  <h1>Page Views</h1>

  <table class="table">
    <thead>
      <tr>
        <th>Date</th>
        <th>IP</th>
        <th>Host</th>
        <th>Path</th>
      </tr>
    </thead>

    <tbody>
    @foreach ($events as $event)
      <tr>
        <th scope="row">{{ date('d M Y H:i:s', strtotime($event['created_at'])) }}</th>
        <td>{{ $event['ip'] }}</td>

        @if (!empty($event['host']))
        <td><a class="link" href="{{ $event['host'] }}" target="_blank">{{ $event['host'] }}</a></td>
        @endif

        @if (!empty($event['host']))
        <td><a class="link" href="{{ $event['host'] }}{{ $event['path'] }}" target="_blank">{{ urldecode($event['path']) }}</a></td>
        @else
        <td>{{ urldecode($event['path']) }}</td>
        @endif
      </tr>
    @endforeach
    </tbody>
  </table>

  <div class="text-center">
  @if ($before)
    <a class="link" href="?before={{ $before }}">&lt; Previous</a>
  @endif

  @if ($after)
    <a class="link" href="?after={{ $after }}">Next &gt;</a>
  @endif
  </div>
@endsection
