@extends('layout.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            {{ __('Date') }}
                        </th>
                        <th>
                            {{ __('Amount') }}
                        </th>
                        <th>
                            {{ __('Download') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoices as $invoice)
                        <tr>
                            <td>
                                {{ $invoice->number }}
                            </td>
                            <td>
                                {{ $invoice->date()->toFormattedDateString() }}
                            </td>
                            <td>
                                {{ $invoice->total() }}
                            </td>
                            <td>
                                <a href="{{ route('invoice.download', $invoice->id) }}">Download</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                {{ __('You have no invoice') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
    
@endsection