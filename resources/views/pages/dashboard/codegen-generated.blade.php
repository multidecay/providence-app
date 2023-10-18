<x-dashboard-layout>
    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800 mb-2">Generated Code</h2>
        <h3 class="font-semibold text-l text-gray-600 mb-4"> Code for {!! $maid_name !!} maid from {!! $codegen_name !!} codegen</h3>
        <section>
            @forelse ($codes as $filename => $code)
            <section class="flex flex-col p-2 border border-gray-400 shadow rounded mb-4">
                <section class="flex">
                    <input name="filename" class="rounded w-full focus:border-none focus:ring focus:ring-gray-300 font-mono" placeholder="filename" value={!! $filename !!} />
                </section>
                <textarea name="content" id="code" class="rounded mt-2 focus:ring focus:ring-gray-300 focus:border-none font-mono" placeholder="your code" x-show="expand" x-transition>{!! $code !!}</textarea>
            </section>
            @empty
                
            @endforelse
        </section>
    </section>
</x-dashboard-layout>