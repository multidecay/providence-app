<x-dashboard-layout>

    <section class="flex flex-col">
        <h2 class="font-bold text-2xl text-gray-800"> Devices list</h2>
        <h3 class="font-semibold text-l text-gray-600"> List of devices that already registered to concensus </h3>
        <table class="text-center my-6">
            <tr class="text-gray-800">
                <th>Id</th>
                <th>Hostname</th>
                <th>Operating System</th>              
                <th>Country</th>
                <th>Maid</th>
                <th>Note</th>
                <th>See details</th>
            </tr>
            @forelse ($devices as $device)
                <tr class="text-center text-gray-600 my-2">
                    <td>{!! $device->id !!}</td>
                    <td>{!! $device->hostname !!}</td>
                    <td>{!! $device->operating_system !!}</td>
                    <td><img src="http://purecatamphetamine.github.io/country-flag-icons/3x2/{!! $device->country_code !!}.svg" width="30" class="mx-auto"/></td>
                    <td>{!! $device->maid()->get()->first()->name !!}</td>
                    <td>{!! $device->notes !!}</td>
                    <td>
                        <a href="/dashboard/device/{!! $device->id !!}">
                            <button class="p-2 my-2 bg-black text-white rounded font-semibold">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </button>
                        </a>
                    </td>
                </tr>
            @empty
                <td colspan="7">
                    <section>
                        <p class="mx-auto my-4 font-bold text-2xl text-gray-700">¯\_(ツ)_/¯</p>
                        <p class="mx-auto my-4 font-bold text-m text-gray-700">No registered devices.</p>
                    </section>
               </td>
            @endforelse
        </table>
    </section>
</x-dashboard-layout>