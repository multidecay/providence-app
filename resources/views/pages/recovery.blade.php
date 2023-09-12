@extends('layouts.default')

@section('content')
    @if($recovery_code != null)
        <section class="flex flex-col mx-auto my-auto w-full h-full md:w-1/2 md:h-1/2 bg-white py-8 mt-8 border-gray-150 border rounded">
            <section class="mx-auto py-4 mt-4">
                
            </section>
            <form action="" method="post" class="flex flex-col mx-auto w-2/5">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <h1 style="" class="font-bold text-2xl"> Recovery Code </h1>
                <h2 style="" class="font-semibold text-gray-500 text-l mb-2">Hey, you only can see this now at once.</h2>

                <textarea class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300">{!! $recovery_code !!}</textarea>
                <button class="m-2 p-2 text-black bg-white hover:bg-black-700 rounded mx-auto focus:ring focus:ring-gray-300 font-semibold border border-black" id="copy_clipboard" type="button">Copy to Clipboard</button>
                <script>
                    document.getElementById("copy_clipboard").onclick = function(){
                        document.querySelector("textarea").select();
                        document.execCommand('copy');
                    }
                </script>
                <a href="/dashboard">
                    <button type="button" class="m-2 p-2 text-white bg-black hover:bg-black-700 rounded mx-auto focus:ring focus:ring-gray-300 font-semibold"> Continue to Dashboard </button>
                </a>
            </form>
        </section>
    @endif
@endsection