<x-dashboard-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/2.3.0/alpine-ie11.min.js" integrity="sha512-Atu8sttM7mNNMon28+GHxLdz4Xo2APm1WVHwiLW9gW4bmHpHc/E2IbXrj98SmefTmbqbUTOztKl5PDPiu0LD/A==" crossorigin="anonymous"></script>
    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800"> Device </h2>
        <h3 class="font-semibold text-l text-gray-600"> Here the specification </h3>
        <section name="device-details" class="flex border borde-gray-500 rounded my-4 p-6">
            <section class="w-1/4">
                <img src="" />
            </section>
            <section class="w-3/4 px-4 text-gray-700">
                <p>HWID : {!! $device->hwid !!}</p>
                <p>Operating System : {!! $device->operating_system !!}</p>
                <p class="flex">Country : <img class="m-2 border border-gray-700" src="http://purecatamphetamine.github.io/country-flag-icons/3x2/{!! $device->country_code !!}.svg" width="30"/></p>
                <p>Last IP : {!! $device->ip !!}</p>
                <p>Maid : {!! $device->maid()->get()->first()->name !!}</p>
                <p>Note : {!! $device->notes !!}</p>
            </section>
        </section>
        <section name="action-tabs" x-data="{route:'task'}">
            <section class="flex flex-row-reverse">
                <a href="/dashboard/device/{{$device->id}}/new-task" class="decoration-none">
                    <button class="px-3 py-2 bg-black text-white rounded font-semibold">New Task</button>
                </a>
            </section>
            <section name="task-tab" x-show="route == 'task'">
                <table class="text-center my-2 w-full">
                    <thead>
                        <tr>
                            <th>Command</th>
                            <th>Argument</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="tasks">
                    </tbody>
                </table>
            </section>
        </section>
    </section>
    <script>
    async function get_device_tasks() {
        var table = document.getElementById("tasks");
        await fetch("/dashboard/device/{!!$device->id!!}/tasks")
            .then((r)=> r.json())
            .then((r)=>{
                r.map((v)=>{
                    var task_state = "";
                    switch(v.state){
                        case 'wait_to_pick':
                            task_state = `<p class="text-white bg-gray-700 rounded">Await to pick</p>`;
                            break;
                        case 'delivered':
                            task_state = `<p class="text-white bg-blue-700 rounded">Delivered</p>`;
                            break;
                        case 'reported':
                            if(v.report_type == "failure")
                            {
                                task_state = `<p class="text-white bg-red-700 rounded">Failed</p>`;
                                break;
                            }
                            task_state = `<p class="text-white bg-green-700 rounded">Succeed</p>`;
                            break;
                    }

                    var tr = document.createElement('tr');
                    tr.innerHTML = `<td>`+ v.command +`</td><td>`+ v.argument +`</td><td>`+ task_state +`</td>`;
                    table.appendChild(tr);
                })
            });
        }

        window.onload = function(){
            get_device_tasks().then()
        }
    </script>
</x-dashboard-layout>