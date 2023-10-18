<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Providence</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            ::selection{
                background-color: black;
                color:aliceblue;
            }
        </style>
    </head>
    <body class="antialiased bg-gray-50 h-100 md:visible">
        <section class="flex flex-col">
            <section class="flex flex-row-reverse mt-4 mx-auto w-5/6">
                <nav
                    class="relative flex w-full flex-wrap items-center justify-between bg-white py-2 text-neutral-500 shadow-md hover:text-neutral-700 focus:text-neutral-700 dark:bg-neutral-600 lg:py-4 rounded border border-gray-200">
                    <section class="flex w-full flex-wrap items-center justify-between px-3">
                        <section class="mr-auto">
                            <h1 class="text-black font-bold text-xl ml-4">Providence</h1>
                        </section>
                        <section class="mx-auto">
                            <ul class="list-none  font-medium list-inside flex">
                                <li class="px-2 mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                    <a href="/dashboard/devices">Device</a>
                                </li>
                                <li class="px-2 mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                    <a href="/dashboard/maids">Maid</a>
                                </li>
                                <li class="px-2 mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                    <a href="/dashboard/codegens">Codegen</a>
                                </li>
                            </ul>
                        </section>
                        <section class="ml-auto">
                            <a href="/logout" class="flex">
                                <button class="bg-black shadow text-white p-2 m-2 flex rounded font-bold">
                                    {!! $user !!} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out ml-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                                </button>
                            </a>
                        </section>
                    </section>
                </nav>
            </section>
            <section class="flex w-5/6 mt-4 mx-auto">
                <section class="flex flex-col w-full h-full md:h-1/2 mr-auto">
                    <section class="flex flex-col mr-auto my-auto w-full h-full bg-white py-8 mt-2 border-gray-150 border rounded px-8">
                        {{ $slot }}
                    </section>
                </section>
            </section>
        </section>
        <footer>
            <section class="my-8">
                <p class="text-center"> Crafted with ❤️ and lot 🤬 at text editor by <a href="https://github.com/norabellm" target="_blank" class="text-pink-700">Minako Norabell</a> under MIT License.<p> 
                <p class="text-center"> Dont forget support me on GitHub.</p>
            </section>
        </footer>
    </body>
</html>