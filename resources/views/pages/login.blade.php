@extends('layouts.default')

@section('content')
<section class="flex flex-col mx-auto my-auto w-full h-full md:w-1/2 md:h-1/2 bg-white py-8 mt-8 border-gray-150 border rounded">
    
    <section class="mx-auto py-4 mt-4">
        
    </section>
    <form action="/" method="post" class="flex flex-col mx-auto w-2/5">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <h1 style="" class="font-bold text-2xl"> Providence </h1>
        <h2 style="" class="font-semibold text-gray-500 text-l mb-2">Never lost your device, again</h2>
        {{-- <label for="identity_text" placeholder="admin" aria-placeholder="admin" class="font-semibold text-gray-700">Identity</label>
        <input id="identity_text" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"> --}}
        {{-- <label for="password_text" placeholder="your_password" aria-placeholder="your_password" class="font-semibold text-gray-700">Password</label>
        <input id="password_text" type="password" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"> --}}
        <div>
            <x-input-label for="identity" placeholder="admin" aria-placeholder="admin" 
            class="font-semibold text-gray-700" :value="__('Identity')" />
            <input id="identity" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('identity')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('identity')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label class="font-semibold text-gray-700" for="password"  :value="__('Password')" />

            <input id="password" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="m-2 p-2 text-white bg-black hover:bg-black-700 rounded w-1/4 mx-auto focus:ring focus:ring-gray-300 font-semibold"> Sign </button>

    </form>
</section>
@endsection