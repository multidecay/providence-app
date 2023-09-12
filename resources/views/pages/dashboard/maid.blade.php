<x-dashboard-layout>
<section class="flex flex-col w-1/2">
    <h2 class="font-bold text-2xl text-gray-800">Maid Config</h2>
    <h3 class="font-semibold text-l text-gray-600">Your maid detail and config.</h3>
    @if (!is_null($maid->name))
    <form id="maid_uniform" class="my-4">
        <section>
            <x-input-label for="name" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Name')" />
            <input id="name" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_name')" required autofocus autocomplete="username" value="{!!$maid->name!!}"> 
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </section>
        <section>
            <x-input-label for="abilities" placeholder="" aria-placeholder="" 
            class="font-semibold text-gray-700" :value="__('Abilities (i.e file-access,admin-priv)')" />
            <textarea id="abilities" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_abilities')" required autofocus rows="5" cols="33">{!! $maid->abilities !!}</textarea>
            <x-input-error :messages="$errors->get('abilities')" class="mt-2" />
        </section>
        <section>
            <x-input-label for="commands" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Commands (i.e upload-file command require file-access abilities)')" />
            <textarea id="commands" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_commands')" required autofocus rows="5" cols="33">{!! $maid->commands !!}</textarea>
            <x-input-error :messages="$errors->get('commands')" class="mt-2" />
        </section>
        <section>
            <x-input-label for="commands" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Signature')" />
            <p id="commands" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_commands')" required autofocus rows="5" cols="33">{!! $maid->signature !!}</p>
            <x-input-error :messages="$errors->get('commands')" class="mt-2" />
        </section>
        <p class="font-semibold text-gray-500 my-4">
            Abilities define what command can executed, because each device that connect could not have permission for certain abilities to perform command.
        </p>
        <button class="m-2 p-2 text-white bg-black hover:bg-black-700 rounded w-1/4 mx-auto focus:ring focus:ring-gray-300 font-semibold">Go!</button>
    </form>
    <script>
        window.addEventListener("load", ()=>{
            const maid_uniform = document.getElementyById("maids_uniform");
            const maid_formctrl = new FormData(maid_uniform);
            maid_formctrl.addEventListener("submit",(e)=>{
                event.preventDefault();
            })
        });
    </script>
    @else
        <p>Not Found</p>
    @endif
</section>
</x-dashboard-layout>