@extends('layouts.app')

@section('content')
  <transaction-root-component :balance="{{ $balance }}" :transactions="{{ $transactions }}" :plinks="{{ json_encode($plinks) }}"></transaction-root-component>
@endsection
