<x-app-layout>
    <x-slot name="header">
        <div class="mb-5">
            <div class="float-left">
                <h2 class="text-xl">Продукты</h2>
            </div>
            <div class="float-right">
                <a class="rounded p-2 bg-blue-600 text-gray-50" href=""></a>
            </div>
        </div>
    </x-slot>
{{--Окно для вывода сообщений пользователю--}}

    <div class="message hidden w-full px-10 py-5" >
        <p></p>
    </div>
{{--    <div class="success hidden w-full px-10 py-5 bg-green-500" >--}}
{{--        <p></p>--}}
{{--    </div>--}}

{{--    <div class="danger hidden w-full px-10 py-5 bg-red-500" >--}}
{{--        <p></p>--}}
{{--    </div>--}}

    <div class="container mx-auto my-5 rounded-xl bg-white">
{{--        Форма для добавления данных в базу--}}
        <form id="productCreateForm" action="" class="rounded-t-xl bg-gray-300 py-2">
            <div class="formData clone">
                <div class="flex items-center justify-center mb-4">
                    <p class="num font-semibold italic">Новая книга # 1</p>
                </div>
                <div class="block md:flex md:flex-row w-full my-5 mx-auto">
    {{--                Главное изображение + доп изображения--}}
                    <div class="md:w-1/4 p-4 md:ml-2 bg-gray-100 rounded-l-xl">
                        <div class="flex flex-col">
                            <div class="inline-flex justify-center">
                                <div class="main-hid-img h-72 w-full flex items-center justify-center border-2 border-gray-400 border-dashed">
                                    <x-svg.x fill="rgb(156,163,175)" width="36" height="36" />
                                </div>
                                <img class="main-img h-72 hidden" src="" alt="">
                            </div>
                            <div class="sec-hid-img inline-flex justify-start mt-2 ">
                            </div>
                            <div class="inline-flex items-center justify-center mt-2 ">
                                <label class="w-1/6 relative md:w-1/3 flex flex-col p-2 mr-2 rounded-full text-blue-200 cursor-pointer bg-blue-200" title="Добавить изображение">
                                    <svg height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                                    </svg>
                                    <input type='file' name="main_img" class="absolute top-1 main-img w-1 bg-green-500 -z-1" accept="image/jpeg, image/png" required/>
                                </label>
                                <label class="flex flex-col p-2 rounded-full cursor-pointer bg-blue-600" title="Добавить больше изображений">
                                    <img class="w-5" src="{{asset('storage/images/icons/image-plus.svg')}}" alt="Добавить больше изображений">
                                    <input type='file' name="images[]" class="sec-img hidden" accept="image/jpeg, image/png" multiple />
                                </label>
                            </div>
                        </div>
                    </div>
    {{--                ISBN, Название, Количество страниц, Год издания и Возрастное ограничение--}}
                    <div class="md:w-2/5 p-4 bg-gray-200">
                        <div class="flex flex-col">
                                <div>
                                    <x-label for="ISBN" :value="__('ISBN:')" />
                                    <x-input class="block mt-1 w-full" type="text" name="ISBN" maxLength="17" minLength="17" pattern="[0-9]{3}-[0-9]{1}-[0-9]{3}-[0-9]{5}-[0-9]{1}" value="" required placeholder="ISBN"/>
                                </div>
                                <div class="mt-4">
                                    <x-label for="name" :value="__('Название:')" />
                                    <x-input class="block mt-1 w-full" type="text" name="name" :value="old('email')" required placeholder="Почта"/>
                                </div>
                                <div class="mt-4 md:flex flex-row justify-around">
                                    <div class="md:inline-flex mr-3">
                                        <label for="price"  class="mr-3 text-xs">Цена</label>
                                        <x-input class="w-full"
                                                 type="number"
                                                 name="price"
                                                 required placeholder="Стоимость" min="0" />
                                    </div>
                                    <div class="md:inline-flex">
                                        <label for="pages"  class="mr-3 text-xs">Кол-во<p>страниц</p></label>
                                        <x-input class="w-full"
                                                 type="number"
                                                 name="pages"
                                                 required placeholder="Кол-во страниц" min="0" />
                                    </div>
                                </div>
                                <div class="mt-4 md:flex flex-row justify-around">
                                    <div class="md:inline-flex mr-3">
                                        <label for="year_release" class="mr-3 text-xs" >Год</label>
                                        <x-input class="w-full"
                                                 type="number" :value="__(date('Y'))" name="year_release"
                                                 placeholder="Год издания"  min="1900" max="2100" pattern="[0-9]{4}" required/>
                                    </div>
                                    <div class="md:inline-flex">
                                        <label for="limit" class="mr-3 text-xs" >0+</label>
                                        <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="limit" required>
                                            @foreach($limits as $limit)
                                                <option value="{{$limit->id}}" @if($limit->id===1) selected @endif>{{$limit->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                        </div>
                    </div>
    {{--                Автор, Жанры и Издатель--}}
                    <div class="md:w-2/5 p-4 md:mr-2 bg-gray-200 rounded-r-xl">
                        <div class="flex flex-col">
                            <div>
                                <x-label for="author" :value="__('Автор:')" />
                                <div class="inline-flex mt-1 flex-row w-full ">
                                    <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="author" required>
                                        <option value="">Выберите автора</option>
                                        @foreach($authors as $author)
                                            <option value="{{$author->id}}">{{$author->last_name." ".$author->first_name." ".$author->father_name}}</option>
                                        @endforeach
                                    </select>
                                    <x-btn.primary data-toggle="#authorCreate" title="Добавить автора">
                                        <img class="w-7" src="{{asset('storage/images/icons/author-plus.svg')}}" alt="Добавить автора">
                                    </x-btn.primary>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="publisher" :value="__('Издательство:')" />
                                <div class="inline-flex mt-1 flex-row w-full ">
                                    <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="publisher" required>
                                        <option value="">Выберите издательство</option>
                                        @foreach($publishers as $publisher)
                                            <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-btn.primary class="pt-0" data-toggle="#publisherCreate" title="Добавить издательство">
                                        <img class="w-7" src="{{asset('storage/images/icons/publisher-plus.svg')}}" alt="Добавить издательство">
                                    </x-btn.primary>
                                </div>
                            </div>
                            <div class="mt-4">
                                <x-label for="genres" :value="__('Жанры:')" />
                                <div class="inline-flex mt-1 flex-row w-full">
                                    <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="genre[]" required >
                                        <option value="">Выберите жанр</option>
                                        @foreach($genres as $genre)
                                            <option value="{{$genre->id}}">{{$genre->name}}</option>
                                        @endforeach
                                    </select>
                                    <x-btn.primary data-toggle="#genreCreate" title="Добавить новый жанр">
                                        <img class="w-7" src="{{asset('storage/images/icons/genre-plus.svg')}}" alt="Добавить жанр">
                                    </x-btn.primary>
                                    <x-btn.primary class="addGenre" title="Добавить eшё один жанр">+</x-btn.primary>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content">

            </div>
            <div class="flex items-center justify-center mb-4">
                <x-btn.primary class="addClone">
                    {{ __('Добавить ещё') }}
                </x-btn.primary>
                <x-btn.primary type="submit">
                    {{ __('Сохранить') }}
                </x-btn.primary>
            </div>
        </form>
        @foreach($products as $key=>$product)
            {{--        Данные продукта--}}
            <div class="flex items-center justify-center mb-4">
                <p class="num font-semibold italic"># {{$key}}</p>
            </div>
            <div class="block md:flex md:flex-row w-full my-5 mx-auto">
                {{--                Главное изображение + доп изображения--}}
                <div class="md:w-1/4 p-4 md:ml-2 bg-gray-100 rounded-l-xl">
                    <div class="flex flex-col">
                        <div class="inline-flex justify-center">
                            <img class="main-img h-72" src="{{$product->main_img}}" alt="">
                        </div>
                        <div class="sec-hid-img inline-flex justify-start mt-2 ">

                        </div>
                        @can('product-edit')
                            <div class="inline-flex items-center justify-center mt-2 ">
                                <label class="w-1/6 md:w-1/3 flex flex-col p-2 mr-2 rounded-full text-blue-200 cursor-pointer bg-blue-200" title="Добавить изображение">
                                    <svg height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                                    </svg>
                                    <input type='file' name="main_img" class="main-img hidden" />
                                </label>
                                <label class="flex flex-col p-2 rounded-full cursor-pointer bg-blue-600" title="Добавить больше изображений">
                                    <img class="w-5" src="{{asset('storage/images/icons/image-plus.svg')}}" alt="Добавить больше изображений">
                                    <input type='file' name="images[]" class="sec-img hidden" multiple />
                                </label>
                            </div>
                        @endcan
                    </div>
                </div>
                {{--                ISBN, Название, Количество страниц, Год издания и Возрастное ограничение--}}
                <div class="md:w-2/5 p-4 bg-gray-200">
                    <div class="flex flex-col">
                        <div>
                            <x-label for="ISBN" :value="__('ISBN:')" />
                            <x-input class="block mt-1 w-full" type="text" name="ISBN[]" maxLength="17" minLength="17" pattern="[0-9]{3}-[0-9]{1}-[0-9]{3}-[0-9]{5}-[0-9]{1}" value="" required placeholder="ISBN"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="name" :value="__('Название:')" />
                            <x-input class="block mt-1 w-full" type="text" name="name[]" :value="old('email')" required placeholder="Почта"/>
                        </div>
                        <div class="mt-4 flex flex-row justify-between">
                            <div class="inline-flex">
                                <label for="pages"  class="mr-1 text-xs">Кол-во<p>страниц</p></label>
                                <x-input class="w-20"
                                         type="number"
                                         name="pages[]"
                                         required placeholder="Кол-во страниц" min="0" />
                            </div>
                            <div class="inline-flex">
                                <label for="year_release" class="mr-1 text-xs" >Год</label>
                                <x-input class="w-20"
                                         type="number" :value="__(date('Y'))" name="year_release[]"
                                         placeholder="Год издания"  min="1900" max="2100" pattern="[0-9]{4}" required/>
                            </div>
                            <div class="inline-flex">
                                <label for="limit" class="mr-1 text-xs" >0+</label>
                                <select class="w-13 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="limit[]" >
                                    @foreach($limits as $limit)
                                        <option value="{{$limit->id}}">{{$limit->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                Автор, Жанры и Издатель--}}
                <div class="md:w-2/5 p-4 md:mr-2 bg-gray-200 rounded-r-xl">
                    <div class="flex flex-col">
                        <div>
                            <x-label for="author" :value="__('Автор:')" />
                            <div class="inline-flex flex-row w-full ">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="author[]" >
                                    @foreach($authors as $author)
                                        <option value="{{$author->id}}">{{$author->last_name." ".$author->first_name." ".$author->father_name}}</option>
                                    @endforeach
                                </select>
                                <x-btn.primary data-toggle="#authorPlus" title="Добавить автора">
                                    <img class="w-7" src="{{asset('storage/images/icons/author-plus.svg')}}" alt="Добавить автора">
                                </x-btn.primary>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="publisher" :value="__('Издательство:')" />
                            <div class="inline-flex flex-row w-full ">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="publisher[]" >
                                    @foreach($publishers as $publisher)
                                        <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                                <x-btn.primary class="pt-0" data-toggle="#publisherPlus" title="Добавить издательство">
                                    <img class="w-7" src="{{asset('storage/images/icons/publisher-plus.svg')}}" alt="Добавить издательство">
                                </x-btn.primary>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="genres" :value="__('Жанры:')" />
                            <div class="inline-flex flex-row w-full">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="genre[]" >
                                    @foreach($genres as $genre)
                                        <option value="{{$genre->id}}">{{$genre->name}}</option>
                                    @endforeach
                                </select>
                                <x-btn.primary data-toggle="#genrePlus" title="Добавить новый жанр">
                                    <img class="w-7" src="{{asset('storage/images/icons/genre-plus.svg')}}" alt="Добавить жанр">
                                </x-btn.primary>
                                <x-btn.primary title="Добавить eшё один жанр">+</x-btn.primary>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('modal')
<script src="{{asset('js/img.js')}}"></script>
<script src="{{asset('js/products.js')}}"></script>
</x-app-layout>
