@extends('components.layout')

@section('content')
    <div class="px-6 py-8">
        <div class="flex justify-between container mx-auto">
            <div class="w-full lg:w-8/12">
                <x-jobs.edit-bid-form :job="$job" :bid="$bid" />
            </div>
            @include('components.jobs.job-filter-sidebar')
        </div>
    </div>
@endsection
