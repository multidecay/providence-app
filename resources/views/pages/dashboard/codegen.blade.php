<x-dashboard-layout>
    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800"> Codegen </h2>
        <h3 class="font-semibold text-l text-gray-600"> Adding new codegen to Providence </h3>
        <form action="/dashboard/codegen/update" method="POST">
            @csrf
            <input type="hidden" value="{{$codegen->id}}" name="codegen_id"/>
            <section class="flex mt-4">
                <section>
                    <x-input-label for="name" placeholder="Minako" aria-placeholder="Minako" 
                    class="font-semibold text-gray-700" :value="__('Name')" />
                    <input id="name" class="my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="name" value="{!! $codegen->name !!}" required autofocus autocomplete="codegen_name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </section>
                <section class="ml-4">
                    <x-input-label for="language" placeholder="Minako" aria-placeholder="Minako" 
                    class="font-semibold text-gray-700" :value="__('Language')" />
                    <input id="language" class="font-mono my-2 bg-gray-100 rounded border-none focus:ring focus:ring-gray-300" type="text" name="language" value="{!! $codegen->language !!}" required autofocus autocomplete="language" />
                    <x-input-error :messages="$errors->get('language')" class="mt-2" />
                    <button type="submit" class=" font-mono ml-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded mx-auto focus:ring focus:ring-gray-300 font-semibold"> Save </button>
                </section>
            </section>
        </form>
        <section 
            class="flex flex-col mt-4" 
            x-data="{
                files: {{json_encode($files,true)}},
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
                            <input name="id" type="hidden" :value="file.id" />
                            <input name="filename" :value="file.filename" class="rounded w-full focus:border-none focus:ring focus:ring-gray-300 font-mono" placeholder="filename" />
                            <button type="button" class="ml-2 px-2 text-white bg-black hover:bg-black-700 rounded focus:ring focus:ring-gray-300 font-semibold" x-on:click="expand = !expand"> ... </button>
                        </section>
                        <textarea name="content" :value="file.content" class="rounded mt-2 focus:ring focus:ring-gray-300 focus:border-none font-mono" placeholder="your code" x-show="expand" x-transition></textarea>
                        <a :href="'/dashboard/codegen/' + file.codegen_id + '/file/' + file.id" x-show="expand" class="mt-2 w-full">
                            <button type="button" class="ml-2 py-2 px-2 text-white bg-black hover:bg-black-700 rounded focus:ring focus:ring-gray-300 font-semibold w-full"> Edit </button>
                        </a>
                    </section>
                </template>
            </section>
            <a href="/dashboard/codegen/{!! $codegen->id !!}/file">
                <button type="button" x-on:click="" class="mt-4 px-4 py-2 text-white bg-black hover:bg-black-700 rounded  focus:ring focus:ring-gray-300 font-semibold"> Add File</button>
            </a>
        </section>
    </section>
</x-dashboard-layout>