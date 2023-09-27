<x-dashboard-layout>
    <section 
        class="flex flex-col" 
        x-data="{
                showModal: false,
                tasks: [],
                task: null,
                async setTaskId(id){
                    this.task = await (await fetch('/dashboard/task/' + id)).json();
                    if(this.task.report_type == 'file'){
                        const report_file = await (await fetch('/dashboard/report-file/' + this.task.report_message)).json();
                        $dispatch('set-reportfile', report_file);
                        $dispatch('set-task', this.task);
                    }
                    $dispatch('set-task', this.task);
                    this.showModal = true;
                }
            }"
        x-init="tasks = await(await fetch('/dashboard/device/{!!$device->id!!}/tasks')).json()"    
        @refresh-tasks.window="tasks = await(await fetch('/dashboard/device/{!!$device->id!!}/tasks')).json()"
    >
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
                <form action="/dashboard/device/{!! $device->id !!}/notes" method="POST">
                    @csrf
                    <label for="notes">Notes: </label>
                    <input type="hidden" name="device_id" value="{!! $device->id !!}"/>
                    <input name="notes" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" value="{!! $device->notes !!}" />
                    <button type="submit" class="p-2 bg-black text-white text-bold rounded">Noted!</button>
                </form>
                <form method="POST" action="/dashboard/device/{{$device->id}}/delete" onsubmit="return confirm('Really, you want delete the device? this can not be undo after it.');">
                    @csrf
                    <button class="mt-4 px-3 py-2 bg-white border-2 border-red-400 text-red-400 rounded font-semibold" type="submit">
                        Delete
                    </button>
                </form>
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
                    <tbody>
                        <template x-for="task in tasks" :key="task.id">
                            <tr>
                                <td x-text="task.command"/>
                                <td x-text="task.argument"/>
                                <td x-on:click="await setTaskId(task.id)">
                                    <template x-if="task.state == 'wait_to_pick'">
                                        <p class="p-2 my-2 font-bold border border-gray-700 bg-white text-gray-700 rounded">Wait to pick</p>
                                    </template>
                                    <template x-if="task.state == 'delivered'">
                                        <p class="p-2 my-2 font-bold text-white bg-blue-700 rounded">Delivered</p>
                                    </template>
                                    <template x-if="task.state == 'reported'">
                                        <section>
                                            <template x-if="task.type == 'failure'">
                                                <p class="p-2 my-2 font-bold text-white bg-red-700 rounded">Failed</p>
                                            </template>
                                            
                                            <template x-if="task.type != 'failure'">
                                                <p  class="p-2 my-2 font-bold text-white bg-green-700 rounded">Succeed</p>
                                            </template>
                                        </section>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <template x-if="tasks.length == 0">
                            <td colspan="6">
                                <section>
                                    <p class="mx-auto my-4 font-bold text-2xl text-gray-700">¯\_(ツ)_/¯</p>
                                    <p class="mx-auto my-4 font-bold text-m text-gray-700">No tasks for devices.</p>
                                </section>
                           </td>
                        </template>
                    </tbody>
                </table>
            </section>
        </section>
    </section>
            <!-- modal section -->
    <section
            x-data="{task_form:null,report_file: null}"
            x-show="task_form != null" 
            :class="{ 'absolute inset-0 z-10 flex items-center justify-center mx-auto': (task_form != null) }"
            style="background-color: rgba(0,0,0,0.5)""
            @set-task.window="task_form = $event.detail"
            @set-reportfile.window="report_file = $event.detail"
        >
            <section  class="bg-white rounded w-1/2 mb-4 flex flex-col">
                <template x-if="task_form != null">
                    <section>
                        <form id="task_report" class="px-4 py-4">
                            <h2 class="font-bold text-2xl text-gray-800">Task Report</h2>
                            <h3 class="font-semibold text-l text-gray-600">Your task and report details</h3>
                            <template x-if="task_form.command != null">
                                <section class="flex flex-col mt-4">
                                    <label 
                                        for="command" 
                                        class="font-semibold text-gray-700"
                                    > Command </label>
                                    <input id="command" 
                                        class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"
                                        type="text"
                                        name="command"
                                        x-model="task_form.command"
                                        readonly
                                    />
                                </section>
                            </template>
                            <template x-if="task_form.argument != null">
                                <p x-text="task_form.argument"> </p>
                                <section class="flex flex-col">
                                    <label 
                                        for="argument" 
                                        class="font-semibold text-gray-700"
                                    > Argument </label>
                                    <input
                                        class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"
                                        type="text"
                                        name="argument"
                                        x-model="task_form.argument"
                                        readonly
                                    />
                                </section>
                            </template>
                            <section>
                                <label  
                                    class="font-semibold text-gray-700"
                                > Status </label>
                                <section class="my-2">
                                    <template x-if="task_form.state == 'wait_to_pick'">
                                        <p class="p-2 font-bold text-gray-700 bg-white border border-gray-700 rounded">Wait to pick</p>
                                    </template>
                                    <template x-if="task_form.state == 'delivered'">
                                        <p class="p-2 font-bold text-white bg-blue-700 rounded">Delivered</p>
                                    </template>
                                    <template x-if="task_form.state == 'reported'">
                                        <section>
                                            <template x-if="task_form.type == 'failure'">
                                                <p class="p-2 font-bold text-white bg-red-700 rounded">Failed</p>
                                            </template>
                                            
                                            <template x-if="task_form.type != 'failure'">
                                                <p  class="p-2 font-bold text-white bg-green-700 rounded">Succeed</p>
                                            </template>
                                        </section>
                                    </template>
                                </section>
                            </section>
                            <h3 class="font-semibold text-l text-gray-700 mb-2 mt-4">Report</h3>
                            <template x-if="task_form.report_type != null">
                                <section class="flex flex-col">
                                    <label 
                                        for="type" 
                                        class="font-semibold text-gray-700"
                                    > Type </label>
                                    <input  
                                        class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"
                                        type="text"
                                        name="type"
                                        x-model="task_form.report_type"
                                        readonly
                                    />
                                </section>
                            </template>
                            <template x-if="task_form.report_message != null">
                                <section>
                                    <template x-if="report_file != null">
                                        <section class="border p-2 rounded">
                                            <p>Filename: <p x-text="report_file.filename"> </p> </p>
                                            <p>Mimes: <p x-text="report_file.mimes"></p></p>
                                            <button
                                                class="p-2 bg-black font-semibold rounded text-white mt-4"
                                                type="button"
                                                x-on:click="
                                                 window.open('/dashboard/report-file/' + report_file.id + '/download','_blank').focus();
                                                "
                                            >
                                                Download
                                            </button>
                                        </section>
                                    </template>
                                    <template x-if="report_file == null">
                                        <section class="flex flex-col">
                                            <label 
                                                for="message" 
                                                class="font-semibold text-gray-700"
                                            > Message </label>
                                            <input id="message" 
                                                class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300"
                                                type="text"
                                                name="message"
                                                x-model="task_form.report_message"
                                                readonly
                                            />
                                        </section>
                                    </template>
                                <section>
                            </template>
                        </form>
                        <form 
                            class="px-4 py-4"
                            method="POST" x-ref="delete-task" onsubmit="return confirm('Really, you want delete the task? this can not be undo after it.');"
                            x-on:submit.prevent="
                            let formData = new FormData();
                            fetch('/dashboard/task/' + task_form.id + '/delete', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-urlencoded',
                                    'X-CSRF-TOKEN': document.getElementsByName('_token')[0].value,
                                },
                                body: formData,
                            })
                            .then((result) => {
                              $dispatch('refresh-tasks');
                              task_form = null;
                            })
                            .catch((error) => {
                              console.error('Error:', error);
                            });"
                            "
                        >
                            @csrf
                            <button 
                                class="mt-4 px-3 py-2 bg-white border-2 border-glay-400 text-gray-400 rounded font-semibold" 
                                type="button"
                                x-on:click="task_form = null"
                            >
                                Back
                            </button>
                            <button 
                                class="mt-4 px-3 py-2 bg-white border-2 border-red-400 text-red-400 rounded font-semibold" 
                                type="submit"
                            >
                                Delete
                            </button>
                        </form>
                    </section>
                </template>
            </section>
        </section>
        <!-- end of modal section -->
    <script>
    </script>
</x-dashboard-layout>