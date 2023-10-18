
<x-dashboard-layout>
    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800 mb-4"> New Codegen File</h2>
        <form action="/dashboard/codegen/{!! $codegen_id !!}/file" method="POST">
            @csrf
            <input name="codegen_id" type="hidden" value="{!! $codegen_id !!}" />
            <section class="flex flex-col p-2 border border-gray-400 shadow rounded mb-4">
                <section class="flex">
                    <input name="filename" class="rounded w-full focus:border-none focus:ring focus:ring-gray-300 font-mono" placeholder="filename" />
                </section>
                <textarea name="content" id="code" class="rounded mt-2 focus:ring focus:ring-gray-300 focus:border-none font-mono" placeholder="your code" x-show="expand" x-transition>{!! $template !!}</textarea>
            </section>
            <button type="submit" class="mt-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded  focus:ring focus:ring-gray-300 font-semibold"> Add File</button>
            <a href="/dashboard/codegen/{!! $codegen_id !!}">
                <button type="button" class="mt-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded  focus:ring focus:ring-gray-300 font-semibold">Back</button>
            </a>
        </form>
    </section>
</x-dashboard-layout>