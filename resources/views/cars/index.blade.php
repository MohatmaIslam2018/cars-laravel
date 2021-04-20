@extends('layouts.app')

<!--if we convert object to array
    then we need to use this way-->
{{-- @foreach ($cars as $car)
    {{ $car['name'] }}
@endforeach --}}

@section('content')


    <div class="m-auto w-4/5 py-24">

        <div class="text-center">
            <h1 class="text-5xl uppercase bold">
                Cars
            </h1>
        </div>

        {{ session('msg') }}

        @if (Auth::user())
            <div class="pt-10">
                <a href="cars/create"
                class="border-b-2 pb-2 border-dotted italic text-gray-500">
                    Add a new car &rarr;
                </a>
            </div>
        @endif



        <div class="w-5/6 py-10">
            @foreach ($cars as $car )

            <div class="m-auto">
                {{-- Checking if the person who logged in, is the person who created the car --}}
                @if (isset(Auth::user()->id) && Auth::user()->id == $car->user_id)
                <div class="float-right
                border-b-2 pb-2 border-dotted italic text-green-500">
                     <a href="cars/{{ $car->id }}/edit">Edit &rarr;</a>


                        <form action="/cars/{{ $car->id }}" method="POST" class="pt-3">
                        @csrf
                        @method('DELETE')

                            <button type="submit"
                            class="float-right
                                border-b-2 pb-2 border-dotted italic text-red-500">
                                Delete &rarr;
                            </button>
                        </form>
                    </div>
                @endif
               

                <span class="uppercase text-blue-500 font-bold text-sm italic">
                   Founded: {{ $car->founded }}
                </span>

                <h2 class="text-gray-700 text-5xl hover:text-gray-500">
                    <a href="/cars/{{ $car->id }}">
                        {{ $car->name }}
                    </a>
                </h2>

                <p class="text-lg text-gray-700 py-6">
                    {{ $car->description }}
                </p>

                <hr class="mt-4 mb-8">
            </div>
            @endforeach
        </div>

        {{ $cars->links() }}

    </div>

@endsection