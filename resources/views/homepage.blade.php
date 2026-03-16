@extends('layouts.app')

@section('content')
<main class="p-6">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-3 gap-8">

        <!-- =========================
                TASK FORM SECTION
        ========================== -->
        @include('partials.tasks.create')

        <!-- =========================
                TASK LIST SECTION
        ========================== -->
        @include('partials.tasks.index')

    </div>
</main>
@endsection
