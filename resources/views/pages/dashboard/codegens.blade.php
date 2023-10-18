<x-dashboard-layout>

    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800"> Codegen </h2>
        <h3 class="font-semibold text-l text-gray-600"> List of available codegen </h3>
        <section class="flex flex-row-reverse w-full my-4">
            <a href="/dashboard/codegens/new" class="decoration-none">
                <button class="px-3 py-2 bg-black text-white rounded font-semibold">New Codegen</button>
            </a>
        </section>
        <table class="text-center my-6 table-auto">
            <tr class="text-gray-800">
                <th>Id</th>
                <th>Name</th>
                <th>Language</th>              
                <th>Action</th>
            </tr>
            @forelse ($codegens as $codegen)
                <tr class="text-center text-gray-600 my-2">
                    <td>{!! $codegen->id !!}</td>
                    <td>{!! $codegen->name !!}</td>
                    <td>{!! $codegen->language !!}</td>
                    <td>
                        <a href="/dashboard/codegen/{!! $codegen->id !!}" class="decoration-none">
                            <button class="px-3 py-2 bg-black text-white rounded font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </button>
                        </a>
                    </td>
                </tr>
            @empty
                <td colspan="4">
                    <section>
                        <p class="mx-auto my-4 font-bold text-2xl text-gray-700">¯\_(ツ)_/¯</p>
                        <p class="mx-auto my-4 font-bold text-m text-gray-700">No codegen added.</p>
                    </section>
               </td>
            @endforelse
        </table>
    </section>
</x-dashboard-layout>