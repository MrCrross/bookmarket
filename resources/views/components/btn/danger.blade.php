<button {{ $attributes->merge(['type'=>'button','class' => 'inline-flex mx-1 items-center p-1.5 bg-red-600 border border-transparent rounded-md hover:bg-red-700 active:bg-red-800 focus:outline-none focus:border-red-900 focus:ring ring-red-600 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
