<button {{ $attributes->merge(['type'=>'button','class' => 'items-center mx-1 p-1.5 bg-green-600 border text-gray-50 border-transparent rounded-md hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-600 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
