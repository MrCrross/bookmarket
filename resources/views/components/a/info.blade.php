<a {{ $attributes->merge(['class' => 'items-center mx-1 p-1.5 bg-blue-300 border border-transparent rounded-md hover:bg-blue-400 active:bg-blue-500 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
