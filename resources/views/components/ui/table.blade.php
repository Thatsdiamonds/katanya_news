<div class="flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-300']) }}>
                    @if(isset($head))
                        <thead class="bg-gray-50">
                            <tr>
                                {{ $head }}
                            </tr>
                        </thead>
                    @endif
                    <tbody class="divide-y divide-gray-200 bg-white">
                        {{ $slot }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
