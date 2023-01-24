<x-layout>
    @include('partials._hero')
    @include('partials._search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">

        @unless(count($listings) == 0)

        @foreach($listings as $lists)
            <x-listing-card :listing="$lists"/> {{-- if passing a variable, must put ":" in front of it. --}}
            {{-- if passing a string, no need to put --}}
        @endforeach

        @else
            <p>No listing here</p>
        @endunless

    </div>
    
    <!-- Pagination -->
    <div class="mt-6 p-4">
        {{$listings->links()}}
    </div>
</x-layout>