<form class="{{ $formData['class'] }}" wire:submit="{{ $formData['function'] }}">
    @foreach ($formData['fildes'] as $item)
        @switch($item['type'])
            @case('email')
                <div>
                    <label for="{{ $item['id'] }}"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white @error($item['wireName']) {{ '!text-red-700 !dark:text-red-500' }}@enderror">{{ $item['name'] }}</label>
                    <input type="{{ $item['type'] }}" wire:model="{{ $item['wireName'] }}" id="{{ $item['id'] }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500
                        focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                         dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                         @error($item['wireName']) {{ '!bg-red-50 border !border-red-500 !text-red-900 !placeholder-red-700 text-sm rounded-lg !focus:ring-red-500 !focus:border-red-500 block w-full p-2.5 !dark:bg-red-100 !dark:border-red-400' }}@enderror"
                        placeholder="{{ $item['placeholder'] }}">
                    @error($item['wireName'])
                        <p class="mt-2 text-sm text-red-600 dark:text-red-600">{{ $message }}</p>
                    @enderror

                </div>
            @break

            @case('password')
                <div>
                    <label for="{{ $item['id'] }}"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white @error($item['wireName']) {{ '!text-red-700 !dark:text-red-500' }}@enderror">{{ $item['name'] }}</label>
                    <input type="{{ $item['type'] }}" wire:model="{{ $item['wireName'] }}" id="{{ $item['id'] }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700
                        dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500
                        @error($item['wireName']) {{ '!bg-red-50 border !border-red-500 !text-red-900 !placeholder-red-700 text-sm rounded-lg !focus:ring-red-500 !focus:border-red-500 block w-full p-2.5 !dark:bg-red-100 !dark:border-red-400' }}@enderror"
                        placeholder="{{ $item['placeholder'] }}">
                    @error($item['wireName'])
                        <p class="mt-2 text-sm text-red-600 dark:text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            @break

            @case('rememberMeForgotPassword')
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="{{ $item['id'] }}" aria-describedby="{{ $item['id'] }}"
                            wire:model="{{ $item['wireName'] }}" type="{{ $item['id'] }}"
                            class="w-4 h-4 border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300
                            dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600
                            ">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="{{ $item['id'] }}" class="font-medium text-gray-900 dark:text-white">Remember me</label>
                    </div>
                    <a href="{{ $item['forgotPasswordRedirectLint'] }}"
                        class="ml-auto text-sm text-primary-700 hover:underline dark:text-primary-500">Lost
                        Password?</a>
                </div>
            @break
        @endswitch
    @endforeach
    <button type="submit"
        class="w-full px-5 py-3 text-base font-medium text-center text-white bg-primary-700 rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ $formData['buttonText'] ?? 'Submit' }}</button>
</form>
