
<x-dashboard-layout>
    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800 mb-4"> Update Code</h2>
        <form action="/dashboard/codegen/{!! $file->codegen_id !!}/file/{!! $file->id !!}" method="POST">
            @csrf
            <input name="codegen_id" type="hidden" value="{!! $file->codegen_id !!}" />
            <input name="id" type="hidden" value="{!! $file->id !!}" />
            <section class="flex flex-col p-2 border border-gray-400 shadow rounded mb-4">
                <section class="flex">
                    <input name="filename" class="rounded w-full focus:border-none focus:ring focus:ring-gray-300 font-mono" placeholder="filename"  value="{{$file->filename}}"/>
                </section>
                <textarea name="content" id="code" class="rounded mt-2 focus:ring focus:ring-gray-300 focus:border-none font-mono" placeholder="your code" x-show="expand" x-transition>{{ $file->content }}</textarea>
            </section>
            <button type="submit" class="mt-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded  focus:ring focus:ring-gray-300 font-semibold">Save Change</button>
            <a href="/dashboard/codegen/{!! $file->codegen_id !!}">
                <button type="button" class="mt-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded  focus:ring focus:ring-gray-300 font-semibold">Back</button>
            </a>
        </form>
    </section>
</x-dashboard-layout>