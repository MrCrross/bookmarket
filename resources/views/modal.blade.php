{{--Модальное окно отображения одной картинки--}}
<x-modal id="imgModal">
    <x-slot name="header"></x-slot>
</x-modal>
{{--Модальное окно отображения слайдера картинок--}}
<x-modal id="sliderModal">
    <x-slot name="header"></x-slot>
    <div class="content">

    </div>
</x-modal>
{{--Модальное окно добавления жанра--}}
<x-modal id="genreCreate">
    <x-slot name="header">Добавить новый жанр</x-slot>
    {!! Form::open(['id'=>'genreCreateForm','class'=>'w-full']) !!}
        <div class="clone">
            <div class="num">
                <p class="num font-semibold italic"># 1</p>
            </div>
            <x-label for="name" :value="__('Название:')" />
            <x-input class="block mt-1 w-full" type="text" name="name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе]+$" minLength="5" maxLength="50" placeholder="Название жанра" required/>
        </div>
        <div class="content">

        </div>
        <div class="flex flex-row items-center justify-center mt-4">
            <x-btn.primary type="submit">
                {{ __('Отправить') }}
            </x-btn.primary>
            <x-btn.primary class="addClone">
                {{ __('Добавить ещё') }}
            </x-btn.primary>
        </div>
    {!! Form::close() !!}
</x-modal>

{{--Модальное окно добавления автора--}}
<x-modal id="authorCreate">
    <x-slot name="header">Добавить нового автора</x-slot>
    {!! Form::open(['id'=>'authorCreateForm','class'=>'w-full']) !!}
        <div class="clone">
            <div class="num">
                <p class="num font-semibold italic"># 1</p>
            </div>
            <div>
                <x-label for="last_name" :value="__('Фамилия:')" />
                <x-input class="block mt-1 w-full" type="text" name="last_name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Фамилия автора" required/>
            </div>
            <div class="mt-4">
                <x-label for="first_name" :value="__('Имя:')" />
                <x-input class="block mt-1 w-full" type="text" name="first_name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Имя автора" required/>
            </div>
            <div class="mt-4">
                <x-label for="father_name" :value="__('Отчество (если есть):')" />
                <x-input class="block mt-1 w-full" type="text" name="father_name[]" :value="old('name')" pattern="^[А-Яа-яЁёЕе]+$" minLength="2" maxLength="100" placeholder="Отчетсво автора"/>
            </div>
        </div>
        <div class="content">

        </div>
        <div class="flex flex-row items-center justify-center mt-4">
            <x-btn.primary type="submit">
                {{ __('Отправить') }}
            </x-btn.primary>
            <x-btn.primary class="addClone">
                {{ __('Добавить ещё') }}
            </x-btn.primary>
        </div>
    {!! Form::close() !!}
</x-modal>

{{--Модальное окно добавления издательства--}}
<x-modal id="publisherCreate">
    <x-slot name="header">Добавить новое издательство</x-slot>
    {!! Form::open(['id'=>'publisherCreateForm','class'=>'w-full']) !!}
    <div class="clone">
        <div class="num">
            <p class="num font-semibold italic"># 1</p>
        </div>
        <x-label for="name" :value="__('Название:')" />
        <x-input class="block mt-1 w-full" type="text" name="name[]" :value="old('name')" minLength="2" maxLength="100" required placeholder="Название издательства"/>
    </div>
    <div class="content">

    </div>
    <div class="flex flex-row items-center justify-center mt-4">
        <x-btn.primary type="submit">
            {{ __('Отправить') }}
        </x-btn.primary>
        <x-btn.primary class="addClone">
            {{ __('Добавить ещё') }}
        </x-btn.primary>
    </div>
    {!! Form::close() !!}
</x-modal>

