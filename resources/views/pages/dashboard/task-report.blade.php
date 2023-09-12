<x-dashboard-layout>
<section class="flex flex-col w-1/2">
    <h2 class="font-bold text-2xl text-gray-800">Task Details</h2>
    <h3 class="font-semibold text-l text-gray-600">Your order task and report details</h3>
    @if(!is_null($task->command))
    <form id="task_uniform" class="my-4">
        <section>
            <x-input-label for="name" placeholder="Minako" aria-placeholder="Minako" 
            class="font-semibold text-gray-700" :value="__('Name')" />
            <input id="name" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_name')" required autofocus autocomplete="username" value="{!!$task->command!!}"> 
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </section>
        <section>
            <x-input-label for="abilities" placeholder="" aria-placeholder="" 
            class="font-semibold text-gray-700" :value="__('Abilities (i.e file-access,admin-priv)')" />
            <textarea id="abilities" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_abilities')" required autofocus rows="5" cols="33" readonly>{!! $task->argument !!}</textarea>
            <x-input-error :messages="$errors->get('abilities')" class="mt-2" />
        </section>
        @if($task->state == 'reported')
            <section class="my-2">
                <h3 class="font-semibold text-xl text-gray-700">Report</h3>
                <span class="my-2 w-1/3">
                @if($task->report_type == "failure")
                    <p class="text-white bg-red-700 rounded">Failed</p>
                @else
                    <p class="text-white bg-green-700 rounded">Success</p>
                @endif
                </span>
                <section>
                    <x-input-label for="commands" placeholder="Minako" aria-placeholder="Minako" 
                    class="font-semibold text-gray-700" :value="__('Message')" />
                    <textarea id="commands" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="identity" :value="old('maid_commands')" required autofocus rows="5" cols="33" readonly>{!! $task->report_message !!}</textarea>
                    <x-input-error :messages="$errors->get('commands')" class="mt-2" />
                </section>
            </section>
        @endif
    </form>
    @else
    @endif
</section>
</x-dashboard-layout>