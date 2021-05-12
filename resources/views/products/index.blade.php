<x-app-layout>
<x-slot name="header">
    <div class="mb-10">
        <div class="float-left">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mr-5">Продукты</h2>
        </div>
        <div class="float-right">
            <div class="inline-flex flex-row justify-start items-center">
                <x-input class="rounded-r-none" type="search" placeholder="Найти"/>
                <x-btn id="search" body="gray" class="ml-0 rounded-l-none" title="Найти">
                    <img class="w-7" src="{{asset('storage/images/icons/search.svg')}}" alt="Найти">
                </x-btn>
            </div>
        </div>
    </div>
</x-slot>
{{--Окно для вывода сообщений пользователю--}}
<div class="message hidden w-full px-10 py-5" >
    <p></p>
</div>
{{-- Контейнер для данных--}}
<div class="container mx-auto mt-5 mb-7 md:rounded-xl bg-white">
{{--        Форма для добавления данных в базу--}}
    {{Form::open(['class'=>'md:rounded-t-xl bg-gray-300 py-2','id'=>'productCreateForm','enctype'=>'multipart/form-data'])}}
        <div class="clone">
            <div class="flex items-center justify-center">
                <p class="num font-semibold italic">Новая книга # 1</p>
            </div>
            <div class="block md:flex md:flex-row w-full my-5 mx-auto">
    {{--                Главное изображение + доп изображения--}}
                <div class="md:w-1/4 p-4 md:ml-2 bg-gray-100 md:rounded-l-xl">
                    <div class="flex flex-col">
                        <div class="inline-flex justify-center">
                            <div class="main-hid-img w-4/6 h-72 flex items-center justify-center border-2 border-gray-400 border-dashed">
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
                                <input type='file' name="main_img[]" class="absolute top-1 main-img w-1 -z-1" accept="image/jpeg, image/png" required/>
                            </label>
                            <label class="flex flex-col p-2 rounded-full cursor-pointer bg-green-600" title="Добавить больше изображений">
                                <img class="w-5" src="{{asset('storage/images/icons/image-plus.svg')}}" alt="Добавить больше изображений">
                                <input type='file' name="images[0][]" class="sec-img hidden" accept="image/jpeg, image/png" multiple />
                            </label>
                        </div>
                    </div>
                </div>
    {{--                ISBN, Название, Количество страниц, Год издания и Возрастное ограничение--}}
                <div class="md:w-2/5 p-4 bg-gray-200">
                    <div class="flex flex-col">
                        <div>
                            <x-label for="ISBN" :value="__('ISBN:')" />
                            <x-input class="block mt-1 w-full" type="text" name="ISBN[]" maxLength="17" minLength="17" pattern="[0-9]{3}-[0-9]{1}-[0-9]{2,3}-[0-9]{5,6}-[0-9]{1}" value="" required placeholder="ISBN"/>
                        </div>
                        <div class="mt-4">
                            <x-label for="name" :value="__('Название:')" />
                            <x-input class="block mt-1 w-full" type="text" name="name[]" :value="old('email')" required placeholder="Название"/>
                        </div>
                        <div class="mt-4 md:flex flex-row justify-around">
                            <div class="md:inline-flex mr-3">
                                <label for="price"  class="mr-3 text-xs">Цена</label>
                                <x-input class="w-full"
                                         type="number"
                                         name="price[]"
                                         required placeholder="Стоимость" min="99" />
                            </div>
                            <div class="md:inline-flex">
                                <label for="pages"  class="mr-3 text-xs">Кол-во<p>страниц</p></label>
                                <x-input class="w-full"
                                         type="number"
                                         name="pages[]"
                                         required placeholder="Кол-во страниц" min="0" />
                            </div>
                        </div>
                        <div class="mt-4 md:flex flex-row justify-around">
                            <div class="md:inline-flex mr-3">
                                <label for="year_release" class="mr-3 text-xs" >Год</label>
                                <x-input class="w-full"
                                         type="number" :value="__(date('Y'))" name="year_release[]"
                                         placeholder="Год издания"  min="1900" max="2100" pattern="[0-9]{4}" required/>
                            </div>
                            <div class="md:inline-flex">
                                <label for="limit" class="mr-3 text-xs" >Возрастные<p>ограничения</p></label>
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="limit[]" required>
                                    @foreach($limits as $limit)
                                        <option value="{{$limit->id}}" @if($limit->id===1) selected @endif>{{$limit->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="description" :value="__('Описание:')" />
                            <x-textarea class="block mt-1 w-full" type="text" name="description[]" rows="5" placeholder="Описание" required></x-textarea>
                        </div>
                    </div>
                </div>
    {{--                Автор, Жанры и Издатель--}}
                <div class="md:w-2/5 p-4 md:mr-2 bg-gray-200 md:rounded-r-xl">
                    <div class="flex flex-col">
                        <div>
                            <x-label for="author" :value="__('Автор:')" />
                            <div class="inline-flex mt-1 flex-row w-full ">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="author[]" required>
                                    <option value="">Выберите автора</option>
                                    @foreach($authors as $author)
                                        <option value="{{$author->id}}">{{$author->last_name." ".$author->first_name." ".$author->father_name}}</option>
                                    @endforeach
                                </select>
                                @can('author-create')
                                <x-a body="success" data-toggle="#authorCreate" title="Добавить автора">
                                    <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить автора">
                                </x-a>
                                @endcan
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="publisher" :value="__('Издательство:')" />
                            <div class="inline-flex mt-1 flex-row w-full ">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="publisher[]" required>
                                    <option value="">Выберите издательство</option>
                                    @foreach($publishers as $publisher)
                                        <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                                @can('publisher-create')
                                <x-a body="success" data-toggle="#publisherCreate" title="Добавить издательство">
                                    <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить издательство">
                                </x-a>
                                @endcan
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-label for="genres" :value="__('Жанры:')" />
                            <div class="inline-flex mt-1 flex-row w-full">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 genre" name="genre[0][]" required >
                                    <option value="">Выберите жанр</option>
                                    @foreach($genres as $genre)
                                        <option value="{{$genre->id}}">{{$genre->name}}</option>
                                    @endforeach
                                </select>
                                @can('genre-create')
                                <x-a body="success" data-toggle="#genreCreate" title="Добавить новый жанр">
                                    <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить жанр">
                                </x-a>
                                @endcan
                                <x-btn class="addGenre" title="Добавить eшё один жанр">+</x-btn>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content">

        </div>
        <div class="flex items-center justify-center mb-4">
            <x-btn class="addClone">
                {{ __('Добавить ещё') }}
            </x-btn>
            <x-btn type="submit">
                {{ __('Сохранить') }}
            </x-btn>
        </div>
    {{Form::close()}}
{{-- Заготовка для обновления страницы--}}
{{Form::open(['class'=>'productEditForm clone hidden py-2','enctype'=>'multipart/form-data','method'=>'POST'])}}
    {{--        Данные продукта--}}
    <div class="flex items-center justify-center mt-2">
        <p class="num font-semibold italic"></p>
        <x-a body="danger" title="Удалить товар" data-toggle="#productDelete">
            <img class="w-3" data-toggle="#productDelete" src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить товар">
        </x-a>
        <input type="text" name="id" class="hidden" value="" readonly required>
    </div>
    <div class="block md:flex md:flex-row w-full mt-5 mx-auto">
        {{--                Главное изображение + доп изображения--}}
        <div class="md:w-1/4 p-4 md:ml-2 bg-blue-300 md:rounded-l-xl">
            <input type="text" name="old_main_img" class="hidden" value="" required>
            <select name="old_images[]" class="hidden" multiple></select>
            <div class="flex flex-col">
                <div class="inline-flex justify-center">
                    <img class="main_img h-72 cursor-pointer" src="" title=""  data-toggle="#imgModal">
                </div>
                <div class="sec-hid-img inline-flex justify-start mt-2 ">
                    <span>
                        <img data-toggle="#imgModal" src="" title="" class="h-12 w-12 cursor-pointer">
                    </span>
                </div>
                @can('product-edit')
                    <x-btn class="product-edit w-full md:w-8 my-2">&#128393;</x-btn>
                    <div class="product-contentEdit inline-flex items-center justify-center mt-2 hidden">
                        <label class="w-1/6 md:w-1/3 flex flex-col p-2 mr-2 rounded-full text-blue-200 cursor-pointer bg-blue-200" title="Добавить изображение">
                            <svg height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                            </svg>
                            <input type='file' name="main_img" class="absolute top-1 main-img w-1 -z-1" accept="image/jpeg, image/png"/>
                        </label>
                        <label class="flex flex-col p-2 rounded-full cursor-pointer bg-green-600" title="Добавить больше изображений">
                            <img class="w-5" src="{{asset('storage/images/icons/image-plus.svg')}}" alt="Добавить больше изображений">
                            <input type='file' name="images[]" class="sec-img hidden" accept="image/jpeg, image/png" multiple />
                        </label>
                        <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                    </div>
                @endcan
            </div>
        </div>
        {{--                ISBN, Название, Количество страниц, Год издания и Возрастное ограничение--}}
        <div class="md:w-4/5 p-4 bg-blue-200 md:rounded-r-xl md:mr-2">
            <div class="flex flex-col">
                <div class="md:inline-flex flex-row justify-between items-center">
                    <label for="ISBN" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">ISBN: </span>
                        <span class="isbn"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                            <x-input class="w-full" type="text" name="ISBN"
                                     maxLength="17" minLength="17" value=""
                                     pattern="[0-9]{3}-[0-9]{1}-[0-9]{2,3}-[0-9]{5,6}-[0-9]{1}"
                                     placeholder="ISBN" />
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="name" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Название: </span>
                        <span class="name"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                            <x-input class="w-full" type="text" name="name" value="" placeholder="Название"/>
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="price" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Стоимость: </span>
                        <span class="price"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                            <x-input class="w-full" type="number" name="price"
                                     placeholder="Стоимость" min="0" value="" />
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="pages" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Кол-во страниц: </span>
                        <span class="pages"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                            <x-input class="w-full" type="number" name="pages"
                                     placeholder="Кол-во страниц" min="0" value="" />
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="year_release" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Год: </span>
                        <span class="year_release"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                            <x-input class="w-full" type="number" name="year_release"
                                     placeholder="Год издания" min="1900" max="2100" pattern="[0-9]{4}"
                                     value=""/>
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="limit" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Возрастные ограничения: </span>
                        <span class="limit"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                            <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="limit" >
                                <option value="" class="hidden"></option>
                                @foreach($limits as $limit)
                                    <option value="{{$limit->id}}">{{$limit->name}}</option>
                                @endforeach
                            </select>
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="author" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Автор: </span>
                        <span class="author"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="product-contentEdit inline-flex w-full md:w-1/2 hidden">
                            <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="author" >
                                <option value="" class="hidden"></option>
                                @foreach($authors as $author)
                                    <option value="{{$author->id}}" >{{$author->last_name." ".$author->first_name." ".$author->father_name}}</option>
                                @endforeach
                            </select>
                            @can('author-delete')
                                <x-a body="danger" data-toggle="#authorDelete" class="mx-0" title="Удалить автора">
                                    <img class="w-7" data-toggle="#authorDelete"
                                         src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить автора">
                                </x-a>
                            @endcan
                            @can('author-edit')
                                <x-a body="gray" data-toggle="#authorEdit" class="mx-0" title="Изменить автора">
                                    <img class="w-7" data-toggle="#authorEdit"
                                         src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить автора">
                                </x-a>
                            @endcan
                            @can('author-create')
                                <x-a body="success" class="mx-0" data-toggle="#authorCreate" title="Добавить автора">
                                    <img class="w-7" data-toggle="#authorCreate" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить автора">
                                </x-a>
                            @endcan
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                    <label for="publisher" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Издательство: </span>
                        <span class="publisher"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="product-contentEdit inline-flex flex-row w-full md:w-1/2 hidden">
                            <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="publisher" >
                                <option value="" class="hidden"></option>
                                @foreach($publishers as $publisher)
                                    <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                @endforeach
                            </select>
                            @can('publisher-delete')
                                <x-a body="danger" data-toggle="#publisherDelete" class="mx-0" title="Удалить издательство">
                                    <img class="w-7" data-toggle="#publisherDelete"
                                         src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить издательство">
                                </x-a>
                            @endcan
                            @can('publisher-edit')
                                <x-a body="gray" data-toggle="#publisherEdit" class="mx-0" title="Изменить издательство">
                                    <img class="w-7" data-toggle="#publisherEdit"
                                         src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить издательство">
                                </x-a>
                            @endcan
                            @can('publisher-create')
                                <x-a body="success" class="mx-0" data-toggle="#publisherCreate" title="Добавить издательство">
                                    <img class="w-7" data-toggle="#publisherCreate" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить издательство">
                                </x-a>
                            @endcan
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
                <div class="mt-2 md:inline-flex flex-row">
                    <label for="genre" class="inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Жанры: </span>
                        <select name="old_genre[]" class="hidden" multiple required></select>
                    </label>
                    <div class="genreContent flex flex-col w-full">
                        <div class="genreClone md:inline-flex flex-row justify-between">
                                <span class="genreLabel md:inline text-sm">
                                    <span class="genre"></span>
                                    <span class="inline product-edit ml-1">&#128393;</span>
                                </span>
                            @can('product-edit')
                                <div class="product-contentEdit inline-flex flex-row w-full md:w-1/2 hidden">
                                    <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 genre" name="genre[]" >
                                        <option value="" class="hidden"></option>
                                        @foreach($genres as $genre)
                                            <option value="{{$genre->id}}" >{{$genre->name}}</option>
                                        @endforeach
                                    </select>
                                    @can('genre-delete')
                                        <x-a body="danger" data-toggle="#genreDelete" class="mx-0" title="Удалить жанр">
                                            <img class="w-7 " data-toggle="#genreDelete"
                                                 src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить жанр">
                                        </x-a>
                                    @endcan
                                    @can('genre-edit')
                                        <x-a body="gray" data-toggle="#genreEdit" class="mx-0" title="Изменить жанр">
                                            <img class="w-7 " data-toggle="#genreEdit"
                                                 src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить жанр">
                                        </x-a>
                                    @endcan
                                    @can('genre-create')
                                        <x-a body="success" class="mx-0" data-toggle="#genreCreate" title="Добавить жанр">
                                            <img class="w-7" data-toggle="#genreCreate" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить жанр">
                                        </x-a>
                                    @endcan
                                    <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                                </div>
                            @endcan
                        </div>
                        <div class="md:inline-flex flex-row justify-between">
                                <span class="genreLabel md:inline text-sm">
                                    <x-btn class="inline product-edit ml-1 " title="Добавить eшё один жанр">+</x-btn>
                                </span>
                            @can('product-edit')
                                <div class="product-contentEdit inline-flex flex-row w-full md:w-1/2 hidden">
                                    <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 genre" name="genre[]" >
                                        <option value="" class="hidden"></option>
                                        @foreach($genres as $el)
                                            <option value="{{$el->id}}" >{{$el->name}}</option>
                                        @endforeach
                                    </select>
                                    @can('genre-delete')
                                        <x-a body="danger" class="mx-0" title="Удалить жанр" data-toggle="#genreDelete"
                                              data-id="" data-name="">
                                            <img class="w-7 " data-toggle="#genreDelete" src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить жанр">
                                        </x-a>
                                    @endcan
                                    @can('genre-edit')
                                        <x-a body="gray" class="mx-0" title="Изменить жанр" data-toggle="#genreEdit"
                                              data-id="" data-name="">
                                            <img class="w-7 " data-toggle="#genreEdit" src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить жанр">
                                        </x-a>
                                    @endcan
                                    @can('genre-create')
                                        <x-a body="success" class="mx-0" data-toggle="#genreCreate" title="Добавить жанр">
                                            <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить жанр">
                                        </x-a>
                                    @endcan
                                    <x-btn class="addGenre" title="Добавить eшё один жанр">+</x-btn>
                                    <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <label for="description" class="md:inline text-sm">
                        <span class="font-semibold px-2 text-gray-500">Описание: </span>
                        <span class="description"></span>
                        @can('product-edit')
                            <span class="inline product-edit ml-1">&#128393;</span>
                        @endcan
                    </label>
                    @can('product-edit')
                        <div class="w-full inline-flex product-contentEdit hidden">
                            <x-textarea class="w-full" name="description" placeholder="Описание" cols="30" rows="5"></x-textarea>
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
{{Form::close() }}
{{--    Продукты--}}
    <div class="contentProducts">
    @foreach($products as $key=>$product)
        {{Form::open(['class'=>'productEditForm py-2','enctype'=>'multipart/form-data'])}}
        {{--        Данные продукта--}}
        <div class="flex items-center justify-center mt-2">
            <p class="num font-semibold italic"># {{++$key}}</p>
            <x-a body="danger" title="Удалить товар" data-toggle="#productDelete" data-id="{{$product->id}}" data-name="{{$product->name}}">
                <img class="w-3" data-toggle="#productDelete"
                     src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить товар">
            </x-a>
            <input type="text" name="id" class="hidden" value="{{$product->id}}" readonly required>
        </div>
        <div class="block md:flex md:flex-row w-full mt-5 mx-auto">
            {{--                Главное изображение + доп изображения--}}
            <div class="md:w-1/4 p-4 md:ml-2 bg-blue-300 md:rounded-l-xl">
                <input type="text" name="old_main_img" class="hidden" value="{{$product->image}}" required>
                <select name="old_images[]" class="hidden" multiple>
                    @foreach($product->images as $image)
                        <option value="{{$image->image}}" selected></option>
                    @endforeach
                </select>
                <div class="flex flex-col">
                    <div class="inline-flex justify-center">
                        <img class="main-img h-72 cursor-pointer" src="{{asset('storage/'.$product->image)}}" title="Гл. изображение книги {{$product->name}}"  data-toggle="#imgModal">
                    </div>
                    <div class="sec-hid-img inline-flex justify-start mt-2 ">
                        @foreach($product->images as $image)
                            <span>
                                <img data-toggle="#imgModal" src="{{asset('storage/'.$image->image)}}" title="Доп. изображение книги {{$product->name}} № {{$image->id}}" class="h-12 w-12 cursor-pointer">
                            </span>
                        @endforeach
                    </div>
                    @can('product-edit')
                        <x-btn class="product-edit w-full md:w-8 my-2">&#128393;</x-btn>
                        <div class="product-contentEdit inline-flex items-center justify-center mt-2 hidden">
                            <label class="w-1/6 relative md:w-1/3 flex flex-col p-2 mr-2 rounded-full text-blue-200 cursor-pointer bg-blue-200" title="Добавить изображение">
                                <svg height="18" viewBox="0 0 24 24" width="18" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M9 16h6v-6h4l-7-7-7 7h4zm-4 2h14v2H5z"/>
                                </svg>
                                <input type='file' name="main_img" class="absolute top-1 main-img w-1 -z-1" accept="image/jpeg, image/png"/>
                            </label>
                            <label class="flex flex-col p-2 rounded-full cursor-pointer bg-green-600" title="Добавить больше изображений">
                                <img class="w-5" src="{{asset('storage/images/icons/image-plus.svg')}}" alt="Добавить больше изображений">
                                <input type='file' name="images[]" class="sec-img hidden" accept="image/jpeg, image/png" multiple />
                            </label>
                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                        </div>
                    @endcan
                </div>
            </div>
            {{--                ISBN, Название, Количество страниц, Год издания и Возрастное ограничение--}}
            <div class="md:w-4/5 p-4 bg-blue-200 md:rounded-r-xl md:mr-2">
                <div class="flex flex-col">
                    <div class="md:inline-flex flex-row justify-between items-center">
                        <label for="ISBN" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">ISBN: </span>
                            <span>{{$product->ISBN}}</span>
                            @can('product-edit')
                            <span class="inline product-edit ml-1" data-name="{{$product->ISBN}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                                <x-input class="w-full" type="text" name="ISBN"
                                         maxLength="17" minLength="17" value=""
                                         pattern="[0-9]{3}-[0-9]{1}-[0-9]{2,3}-[0-9]{5,6}-[0-9]{1}"
                                         placeholder="ISBN"/>
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="name" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Название: </span>
                            <span>{{$product->name}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-name="{{$product->name}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                                <x-input class="w-full" type="text" name="name" value="" placeholder="Название"/>
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="price" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Стоимость: </span>
                            <span>{{$product->price}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-name="{{$product->price}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                                <x-input class="w-full" type="number" name="price"
                                        placeholder="Стоимость" min="0" value="" />
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="pages" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Кол-во страниц: </span>
                            <span>{{$product->pages}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-name="{{$product->pages}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                                <x-input class="w-full" type="number" name="pages"
                                         placeholder="Кол-во страниц" min="0" value="" />
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="year_release" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Год: </span>
                            <span>{{$product->year_release}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-name="{{$product->year_release}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                                <x-input class="w-full" type="number" name="year_release"
                                         placeholder="Год издания" min="1900" max="2100" pattern="[0-9]{4}"
                                         value=""/>
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="limit" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Возрастные ограничения: </span>
                            <span>{{$product->limit->name}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-id="{{$product->limit->id}}" >&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full md:w-1/2 inline-flex product-contentEdit hidden">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="limit" >
                                    <option value="" class="hidden"></option>
                                    @foreach($limits as $limit)
                                        <option value="{{$limit->id}}">{{$limit->name}}</option>
                                    @endforeach
                                </select>
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="author" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Автор: </span>
                            <span>{{$product->author->last_name." ".$product->author->initials}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-id="{{$product->author->id}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="product-contentEdit inline-flex w-full md:w-1/2 hidden">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="author" >
                                    <option value="" class="hidden"></option>
                                    @foreach($authors as $author)
                                        <option value="{{$author->id}}" >{{$author->last_name." ".$author->first_name." ".$author->father_name}}</option>
                                    @endforeach
                                </select>
                                @can('author-delete')
                                    <x-a body="danger" class="mx-0" title="Удалить автора"
                                            data-toggle="#authorDelete" data-id="{{$product->author->id}}"
                                            data-first_name="{{$product->author->first_name}}"
                                            data-last_name="{{$product->author->last_name}}"
                                            data-father_name="{{$product->author->father_name}}">
                                        <img class="w-7" data-toggle="#authorDelete" src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить автора">
                                    </x-a>
                                @endcan
                                @can('author-edit')
                                <x-a body="gray" class="mx-0" title="Изменить автора"
                                        data-toggle="#authorEdit" data-id="{{$product->author->id}}"
                                        data-first_name="{{$product->author->first_name}}"
                                        data-last_name="{{$product->author->last_name}}"
                                        data-father_name="{{$product->author->father_name}}">
                                    <img class="w-7" data-toggle="#authorEdit" src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить автора">
                                </x-a>
                                @endcan
                                @can('author-create')
                                <x-a body="success" class="mx-0" data-toggle="#authorCreate" title="Добавить автора">
                                    <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить автора">
                                </x-a>
                                @endcan
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row justify-between items-center">
                        <label for="publisher" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Издательство: </span>
                            <span>{{$product->publisher->name}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-id="{{$product->publisher->id}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="product-contentEdit inline-flex flex-row w-full md:w-1/2 hidden">
                                <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="publisher" >
                                    <option value="" class="hidden"></option>
                                    @foreach($publishers as $publisher)
                                        <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                                @can('publisher-delete')
                                    <x-a body="danger" class="mx-0" title="Удалить издательство"
                                            data-toggle="#publisherDelete" data-id="{{$product->publisher->id}}"
                                            data-name="{{$product->publisher->name}}">
                                        <img class="w-7" data-toggle="#publisherDelete" src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить издательство">
                                    </x-a>
                                @endcan
                                @can('publisher-edit')
                                <x-a body="gray" class="mx-0" title="Изменить издательство"
                                        data-toggle="#publisherEdit" data-id="{{$product->publisher->id}}"
                                        data-name="{{$product->publisher->name}}">
                                    <img class="w-7" data-toggle="#publisherEdit" src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить издательство">
                                </x-a>
                                @endcan
                                @can('publisher-create')
                                <x-a body="success" class="mx-0" data-toggle="#publisherCreate" title="Добавить издательство">
                                    <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить издательство">
                                </x-a>
                                @endcan
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                    <div class="mt-2 md:inline-flex flex-row">
                        <label for="genre" class="inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Жанры: </span>
                            <select name="old_genre[]" class="hidden" multiple >
                                @foreach($product->genres as $genre)
                                    <option value="{{$genre->genre->id}}" selected></option>
                                @endforeach
                            </select>
                        </label>
                        <div class="flex flex-col w-full">
                            @foreach($product->genres as $genre)
                                <div class="md:inline-flex flex-row justify-between">
                                    <span class="genreLabel md:inline text-sm">
                                        <span>{{$genre->genre->name}}</span>
                                        <span class="inline product-edit ml-1" data-id="{{$genre->genre->id}}">&#128393;</span>
                                    </span>
                                    @can('product-edit')
                                        <div class="product-contentEdit inline-flex flex-row w-full md:w-1/2 hidden">
                                            <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 genre" name="genre[]" >
                                                <option value="" class="hidden"></option>
                                                @foreach($genres as $el)
                                                    <option value="{{$el->id}}" >{{$el->name}}</option>
                                                @endforeach
                                            </select>
                                            @can('genre-delete')
                                                <x-a body="danger" class="mx-0" title="Удалить жанр" data-toggle="#genreDelete"
                                                        data-id="{{$genre->genre->id}}" data-name="{{$genre->genre->name}}">
                                                    <img class="w-7 " data-toggle="#genreDelete" src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить жанр">
                                                </x-a>
                                            @endcan
                                            @can('genre-edit')
                                            <x-a body="gray" class="mx-0" title="Изменить жанр" data-toggle="#genreEdit"
                                                    data-id="{{$genre->genre->id}}" data-name="{{$genre->genre->name}}">
                                                <img class="w-7 " data-toggle="#genreEdit" src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить жанр">
                                            </x-a>
                                            @endcan
                                            @can('genre-create')
                                            <x-a body="success" class="mx-0" data-toggle="#genreCreate" title="Добавить жанр">
                                                <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить жанр">
                                            </x-a>
                                            @endcan
                                            <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                                        </div>
                                    @endcan
                                </div>
                            @endforeach
                            @can('genre-create')
                            <div class="md:inline-flex flex-row justify-between">
                                <span class="genreLabel md:inline text-sm">
                                    <x-btn class="inline product-edit ml-1 " title="Добавить eшё один жанр">+</x-btn>
                                </span>
                                @can('product-edit')
                                    <div class="product-contentEdit inline-flex flex-row w-full md:w-1/2 hidden">
                                        <select class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 genre" name="genre[]" >
                                            <option value="" class="hidden"></option>
                                            @foreach($genres as $el)
                                                <option value="{{$el->id}}" >{{$el->name}}</option>
                                            @endforeach
                                        </select>
                                        @can('genre-delete')
                                            <x-a body="danger" class="mx-0" title="Удалить жанр" data-toggle="#genreDelete"
                                                  data-id="" data-name="">
                                                <img class="w-7 " data-toggle="#genreDelete" src="{{asset('storage/images/icons/delete.svg')}}" alt="Удалить жанр">
                                            </x-a>
                                        @endcan
                                        @can('genre-edit')
                                            <x-a body="gray" class="mx-0" title="Изменить жанр" data-toggle="#genreEdit"
                                                  data-id="" data-name="">
                                                <img class="w-7 " data-toggle="#genreEdit" src="{{asset('storage/images/icons/edit.svg')}}" alt="Изменить жанр">
                                            </x-a>
                                        @endcan
                                        @can('genre-create')
                                            <x-a body="success" class="mx-0" data-toggle="#genreCreate" title="Добавить жанр">
                                                <img class="w-7" src="{{asset('storage/images/icons/plus.svg')}}" alt="Добавить жанр">
                                            </x-a>
                                        @endcan
                                        <x-btn class="addGenre" title="Добавить eшё один жанр">+</x-btn>
                                        <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                                    </div>
                                @endcan
                            </div>
                            @endcan
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="description" class="md:inline text-sm">
                            <span class="font-semibold px-2 text-gray-500">Описание: </span>
                            <span class="description">{{$product->description}}</span>
                            @can('product-edit')
                                <span class="inline product-edit ml-1" data-name="{{$product->description}}">&#128393;</span>
                            @endcan
                        </label>
                        @can('product-edit')
                            <div class="w-full inline-flex product-contentEdit hidden">
                                <x-textarea class="w-full" name="description" placeholder="Описание" cols="30" rows="5"></x-textarea>
                                <x-btn class="productEditSubmit" type="submit" title="Сохранить изменения">&#10003;</x-btn>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}
    @endforeach
    </div>
</div>
@include('modal')
<script src="{{asset('js/img.js')}}"></script>
<script src="{{asset('js/products.js')}}"></script>
<script src="{{asset('js/genre.js')}}"></script>
<script src="{{asset('js/author.js')}}"></script>
<script src="{{asset('js/publisher.js')}}"></script>
</x-app-layout>
