<div>
    @foreach ($formFildes as $item)
        @switch($item['type'])
            @case('email')
                <div>
                    <label for="{{ $item['id'] }}"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $item['name'] }}</label>
                    <input type="{{ $item['type'] }}" wire.model="{{ $item['wireName'] }}" id="{{ $item['id'] }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="{{ $item['placeholder'] }}">
                    @error($item['wireName'])
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror

                </div>
            @break
            @case(2)
        @endswitch
    @endforeach
</div>
