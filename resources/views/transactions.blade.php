@extends('layouts.app')

@section('content')
  <transaction-root-component :balance="{{ $balance }}" :transactions="{{ $transactions }}"></transaction-root-component>
@endsection
