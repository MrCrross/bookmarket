<a {{ $attributes->merge(['class' => 'items-center mx-1 p-1.5 bg-blue-600 text-gray-50 border border-transparent rounded-md hover:bg-blue-700 hover:text-gray-100 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-600 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
