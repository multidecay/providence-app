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
                <ul class="list-none font-medium list-inside ml-auto my-auto bg-white border-gray-150 border rounded px-4">
                    <li class="my-2 font-semibold text-gray-700">
                        <a href="/logout" class="flex">{!! $user !!} <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out ml-2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg></a>
                    </li>
                </ul>
            </section>
            <section class="flex md:flex mt-4">
                <section class="flex flex-col md:w-1/6 md:h-1/2 ml-auto mr-2">
                    <section class="flex flex-col ml-auto mr-2 my-auto w-full h-full bg-white py-6 mt-2 border-gray-150 border rounded">
                        <h1 class="font-bold text-2xl mx-auto my-2 w-4/6 font-semibold text-gray-800"> Providence </h1>
                        <ul class="list-none  font-medium list-inside">
                            {{-- <li class="mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                <a href="/dashboard">Summaries</a>
                            </li> --}}
                            {{-- <li class="mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                <a href="/dashboard/tasks">Tasks & Reports</a>
                            </li> --}}
                            <li class="mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                <a href="/dashboard/devices">Devices</a>
                            </li>
                            <li class="mx-auto my-2 w-4/6 font-semibold text-gray-700">
                                <a href="/dashboard/maids">Maids</a>
                            </li>
                            <li class="mx-auto my-2 w-4/6 font-semibold text-gray-400">
                                <a>Codegen</a>
                            </li>
                        </ul>
                    </section>
                </section>
                <section class="flex flex-col w-full h-full md:w-4/6 md:h-1/2 mr-auto">
                    <section class="flex flex-col mr-auto my-auto w-full h-full bg-white py-8 mt-2 border-gray-150 border rounded px-8">
                        {{ $slot }}
                    </section>
                </section>
            </section>
        </section>
        <footer>
            <section class="my-8">
                <p class="text-center"> Crafted with ❤️ by <a href="https://github.com/minako2" target="_blank" class="text-pink-700">Minako</a> under MIT License.<p> 
                <p class="text-center"> Dont forget support me on GitHub.</p>
            </section>
        </footer>
    </body>
</html>