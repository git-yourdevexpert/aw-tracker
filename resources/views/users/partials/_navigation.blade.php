<nav class="bg-white">
    <div class="container mx-auto">
        <div class="flex items-center justify-between py-2 px-4">
            <div>
                <a href="{{ url('/') }}">
                    <img src="{{ asset('/images/logo.svg') }}" alt="{{ config('app.name') }} - Logo" class="h-20" loading="lazy" />
                </a>
            </div>

            <div class="block sm:hidden">
                <div class="text-3xl text-green-700"><span><i class="fas fa-bars"></i></span></div>
            </div>

            <div class="hidden sm:block my-4 sm:my-0">
                <ul class="sm:flex sm:space-x-12 space-y-4 sm:space-y-0">
                    <li class="border-b sm:border-0 pb-2 sm:pb-0"><a href="{{ route('users.dashboard') }}" class="text-gray-700 hover:text-green-700 focus:text-green-700 transition ease-in-out duration-300">Dashboard</a></li>
                    <li class="border-b sm:border-0 pb-2 sm:pb-0">
                        <form action="{{ route('users.logout') }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="text-gray-700 hover:text-green-700 focus:text-green-700 transition ease-in-out duration-300">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>