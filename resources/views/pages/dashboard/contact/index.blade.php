@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="From Emails" />
    <div class="space-y-6">
        
        <x-common.component-card title="Data Email">
            <x-tables.basic-tables.basic-tables-two :contacts="$contacts" />
        </x-common.component-card>
       
    </div>
@endsection
