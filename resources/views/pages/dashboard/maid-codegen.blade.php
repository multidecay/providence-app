<x-dashboard-layout>
    <section class="flex flex-col w-1/2">
        <h2 class="font-bold text-2xl text-gray-800">Maid Codegen</h2>
        <h3 class="font-semibold text-l text-gray-600 mb-4">Generate Maid interpreter program code</h3>
        <form action="/dashboard/maid/codegen" method="POST">
            @csrf
            <section class="">
                <label for="codegen_name">Select Codegen: </label>
                <input type="hidden" value="{!! $maid_id !!}" name="maid_id"/>
                <select name="codegen_id">
                    @foreach ($codegens as $codegen)
                        <option value="{!! $codegen->id !!}">{!! $codegen->name !!}</option>
                    @endforeach
                </select>
            </section>
            <button type="submit" class="m-2 p-2 text-white bg-black hover:bg-black-700 rounded mx-auto focus:ring focus:ring-gray-300 font-semibold">Generate</button>
        </form>
    </section>
</x-dashboard-layout>