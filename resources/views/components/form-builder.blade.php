<div>
    @foreach ($collection as $item)

    @endforeach
    @switch($type)
        @case(1)

            @break
        @case(2)

            @break
        @default

    @endswitch
    <div>
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
            email</label>
        <input type="email" name="email" id="email"
            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
            placeholder="name@company.com" required>
    </div>
</div>
