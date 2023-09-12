<x-dashboard-layout>
<section class="flex flex-col">
    <h2 class="font-bold text-2xl text-gray-800">New Maid?!</h2>
    <h3 class="font-semibold text-l text-gray-600">Yahoo, welcome our fellow Maid. Maid is command definiton of your software.</h3>
    <form id="maid_uniform" method="post" action="/dashboard/maids" class="my-4">
        @csrf
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <section>
            <x-input-label for="name" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Name')" />
            <input id="name" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="name" :value="old('maid_name')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </section>
        <p class="font-semibold text-gray-500 my-4">
            Abilities define what command can executed, because each device that connect could not have permission for certain abilities to perform command.
        </p>
        <section>
            <x-input-label for="abilities" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Abilities (i.e file-access,admin-priv)')" />
            <textarea id="abilities" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="abilities" :value="old('maid_abilities')" required autofocus rows="5" cols="33">["file-access","admin-priv"]</textarea>
            <x-input-error :messages="$errors->get('abilities')" class="mt-2" />
        </section>
        <section>
            <x-input-label for="commands" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Commands (i.e upload-file command require file-access abilities)')" />
            <textarea id="commands" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="commands" :value="old('maid_commands')" required autofocus rows="5" cols="33">{
    "upload-file": ["file-access","admin-priv"]
}</textarea>
            <x-input-error :messages="$errors->get('commands')" class="mt-2" />
        </section>
        <button class="m-2 p-2 text-white bg-black hover:bg-black-700 rounded w-1/4 mx-auto focus:ring focus:ring-gray-300 font-semibold">Go!</button>
    </form>
    <script>
        // window.addEventListener("load", ()=>{
        //     const maid_uniform = document.getElementyById("maids_uniform");
        //     const maid_formctrl = new FormData(maid_uniform);
        //     maid_formctrl.addEventListener("submit",(e)=>{
        //         event.preventDefault();
        //     })
        // });
    </script>
</section>
</x-dashboard-layout>