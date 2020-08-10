<x-app>
    <header class="mb-6 relative">

        <div>
            <img src="/images/laravel.png" alt="" class="mb-2">

            <img src="{{$user->avatar}}" alt="" class="rounded-full mr-2 absolute"
                style="width: 150px; left: calc(50% - 75px); top: 40%">
        </div>



        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="font-bold text-2xl mb-2">{{$user->name}}</h2>
                <p class="text-sm">Joined {{$user->created_at->diffForHumans()}}</p>
            </div>

            <div class="flex">
                @can ('edit', $user)
                <a href="{{$user->path('edit')}}" class="rounded-full shadow py-2 px-2 text-black">
                    Edit Profile
                </a>
                @endcan
                <x-follow-button :user="$user">
                </x-follow-button>

            </div>
        </div>
        <p class="text-sm">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
            industry's
            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it
            to
            make
            of Lorem Ipsum.
        </p>


    </header>


    @include('_timeline', [ 'tweets'=> $user->tweets
    ])

</x-app>