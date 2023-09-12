<x-dashboard-layout>
<section class="flex flex-col">
    <h2 class="font-bold text-2xl text-gray-800">New Tasks</h2>
    <h3 class="font-semibold text-l text-gray-600">Ready to serve.</h3>
    <form action="/dashboard/device/{{$device_id}}/task" method="POST" >
        @csrf
        <input type="hidden" name="maid_id" value="{{ $maid_id }}" />
        <input type="hidden" name="device_id" value="{{ $device_id }}" />
        <section>
            <x-input-label for="command" 
            class="font-semibold text-gray-700" :value="__('Command')" />
            <select id="command" name="command" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300">
            </select>
            <x-input-error :messages="$errors->get('Command')" class="mt-2" />
        </section>
        <section>
            <x-input-label for="argument"
            class="font-semibold text-gray-700" :value="__('Argument')" />
            <textarea rows="5" cols="33" id="argument" name="argument" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300 w-1/3"></textarea>
        </section>
        <x-input-error :messages="$errors->get('task_new')" class="my-2" />
        <button class="m-2 p-2 text-white bg-black hover:bg-black-700 rounded w-1/4 mx-auto focus:ring focus:ring-gray-300 font-semibold">Go!</button>
    </form>
</section>
<script>
    const maid_commands = {!!json_decode($maid_commands,true)!!};
    const device_abilties = {!!json_decode($device_abilities,true)!!};

    window.onload = ()=>{
        var commands_option = document.getElementById("command");
        for(var command in maid_commands){
            const permission = maid_commands[command];

            // matching the maid and device abilities for commands
            if(permission.filter((p)=> !device_abilties.includes(p)).length == 0){
                const option_item = document.createElement("option");
                option_item.value = command;
                option_item.innerText = command;
                commands_option.add(option_item);
            }
        }
    }
</script>
</x-dashboard-layout>