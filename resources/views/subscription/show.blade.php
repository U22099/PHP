<x-layout>
    <div class="bg-white py-16 sm:py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-4xl text-center">
                <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl">
                    Find the perfect plan for your freelancing journey
                </h1>
                <p class="mt-6 text-xl leading-8 text-gray-700">
                    Join {{ config('app.name') }} and connect with clients, find exciting projects, and grow your
                    career. Choose the plan that best supports your ambitions and unlocks your full potential.
                </p>
            </div>

            <div
                class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-10 sm:mt-20 lg:max-w-none lg:grid-cols-2 lg:gap-x-8 xl:gap-x-12">
                {{-- Basic Plan --}}
                <div
                    class="flex flex-col justify-between rounded-3xl bg-white p-8 shadow-xl ring-1 ring-gray-900/10 transition-transform duration-300 hover:scale-[1.02]">
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900">Basic</h2>
                        <p class="mt-4 text-sm leading-6 text-gray-600">
                            Kickstart your freelancing career with {{ config('app.name') }}. Perfect for new freelancers
                            to discover opportunities and build their portfolio.
                        </p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span class="text-5xl font-bold tracking-tight text-gray-900">Free</span>
                            <span class="text-sm font-semibold leading-6 text-gray-600">/ forever</span>
                        </p>

                        <h3 class="mt-10 text-xl font-semibold leading-6 text-gray-900">Includes:</h3>
                        <ul role="list" class="mt-6 space-y-4 text-sm leading-6 text-gray-700">
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                1 Article creation per day
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Up to 3 job posts daily
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Up to 15 community posts daily
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                10 job bids per day
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Up to 3 projects in your portfolio
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Upload up to 10 images
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Job descriptions up to 1500 characters
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Post bodies up to 500 characters
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Article content up to 7500 characters
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Bid messages up to 1200 characters
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-indigo-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Professional summary up to 1500 characters
                            </li>
                        </ul>
                    </div>
                    @if (Auth::user()->is_premium)
                        <div class="mt-8">
                            <button disabled
                                class="mt-8 block w-full rounded-md bg-gray-200 px-3.5 py-2 text-center text-sm font-semibold text-gray-500 shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-not-allowed">
                                Currently on Premium Plan
                            </button>
                        </div>
                    @else
                        <div class="mt-8">
                            <button disabled
                                class="mt-8 block w-full rounded-md bg-gray-200 px-3.5 py-2 text-center text-sm font-semibold text-gray-500 shadow-sm focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-indigo-600 cursor-not-allowed">
                                Current Plan
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Premium Plan --}}
                <div
                    class="relative flex flex-col justify-between rounded-3xl bg-indigo-600 p-8 shadow-2xl ring-1 ring-indigo-600 transition-transform duration-300 hover:scale-[1.02]">
                    <div
                        class="absolute top-0 right-0 -mt-4 -mr-4 bg-indigo-700 text-white text-xs font-semibold px-4 py-1.5 rounded-full uppercase shadow-md rotate-6">
                        Recommended
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold tracking-tight text-white">Premium</h2>
                        <p class="mt-4 text-sm leading-6 text-indigo-200">
                            Maximize your freelancing potential with {{ config('app.name') }} Premium. Unlock unlimited
                            opportunities, advanced features, and priority tools.
                        </p>
                        <p class="mt-6 flex items-baseline gap-x-1">
                            <span class="text-5xl font-bold tracking-tight text-white">
                                {{ $premium_price }}
                            </span>
                            <span class="text-sm font-semibold leading-6 text-indigo-100">/ month</span>
                        </p>

                        <h3 class="mt-10 text-xl font-semibold leading-6 text-white">Everything in Basic, plus:</h3>
                        <ul role="list" class="mt-6 space-y-4 text-sm leading-6 text-indigo-100">
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Unlimited Articles, Jobs, Posts, Bids, and Projects
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Increased image upload limit (20 images per project)
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Extended content limits for all fields (up to 25,000 characters)
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Exclusive Email Job Alert feature for freelancers
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="h-6 w-5 flex-none text-white" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Early access to powerful AI features (coming soon!)
                            </li>
                        </ul>
                    </div>
                    @if (Auth::user()->is_premium)
                        <div class="mt-8 rounded-md bg-indigo-700 px-6 py-4 text-center">
                            <p class="text-sm text-indigo-200 mb-2">Your subscription is active until</p>
                            <p class="text-lg font-semibold text-white">
                                {{ Auth::user()->last_premium_subscription && Auth::user()->last_premium_subscription->addMonth()->toFormattedDateString() }}
                            </p>
                            <form action="{{ route('subscription.cancel') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="mt-4 inline-flex items-center justify-center rounded-md bg-red-500 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-600 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-red-600 transition-colors duration-200">
                                    Cancel Subscription
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="mt-8">
                            <form action="{{ route('subscription.cancel') }}" method="POST">
                                @csrf
                                <button type="submit"
                                class="block w-full rounded-md bg-white px-3.5 py-2 text-center text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-50 focus-visible:outline focus-visible:outline-offset-2 focus-visible:outline-white transition-colors duration-200">
                                Subscribe Now
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout>
