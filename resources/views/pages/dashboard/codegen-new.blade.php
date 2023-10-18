<x-dashboard-layout>
    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800"> New Codegen </h2>
        <h3 class="font-semibold text-l text-gray-600"> Adding new codegen to Providence </h3>
        <form action="/dashboard/codegens/new" method="POST">
            @csrf
            <section class="flex mt-4">
                <section>
                    <x-input-label for="name" placeholder="Minako" aria-placeholder="Minako" 
                    class="font-semibold text-gray-700" :value="__('Name')" />
                    <input id="name" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="name" :value="old('codegen_name')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </section>
                <section class="ml-4">
                    <x-input-label for="language" placeholder="Minako" aria-placeholder="Minako" 
                    class="font-semibold text-gray-700" :value="__('Language')" />
                    <input id="language" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="language" :value="old('codegen_language')" required autofocus autocomplete="language" />
                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                    <button type="submit" class="ml-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded mx-auto focus:ring focus:ring-gray-300 font-semibold"> Save </button>
                </section>
            </section>
            <section 
                class="flex flex-col mt-4" 
                x-data="{
                    files: [{}],
                    addFile(){
                        this.files.push({});
                    },
                    removeFile(id){

                    }
                }"    
            >
                <h2 class=" text-xl text-gray-700 mb-4 font-bold">Files</h2>
                <!-- File container-->
                <section id="files">
                    <template x-for="file in files ">
                        <section x-data="{expand: false}"" class="flex flex-col p-2 border border-gray-400 shadow rounded mb-4">
                            <section class="flex">
                                <input name="filename[]" class="rounded w-full focus:border-none focus:ring focus:ring-gray-300 font-mono" placeholder="filename" />
                                <button type="button" class="ml-2 px-2 text-white bg-black hover:bg-black-700 rounded focus:ring focus:ring-gray-300 font-mono" x-on:click="expand = !expand"> ... </button>
                            </section>
                                <textarea name="content[]" class="rounded mt-2 focus:ring focus:ring-gray-300 focus:border-none font-mono" placeholder="your code" x-show="expand" x-transition></textarea>
                        </section>
                    </template>
                </section>
                <button type="button" x-on:click="addFile()" class="mt-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded  focus:ring focus:ring-gray-300 font-semibold"> Add File</button>
            </section>
        </form>
    </section>
</x-dashboard-layout>