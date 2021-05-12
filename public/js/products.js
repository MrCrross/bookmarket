//Функция добавления новой книги
function productCreateHandler(e){
    e.preventDefault()
    const form=document.querySelector('#productCreateForm')
    const clone = form.querySelector('.clone')
    const formData = new FormData(form)
    fetch('/api/product',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            if(res.products){
                const content = document.querySelector('#productCreateForm')
                content.querySelectorAll('.cloneObj').forEach(function (form){
                    form.remove()
                })
                content.querySelectorAll('input').forEach(function (item){
                    item.value=''
                })
                const main_img = content.querySelector('.main-img[src]')// IMG
                main_img.src = ''
                main_img.alt = ''
                main_img.title = ''
                main_img.classList.add('hidden')
                content.querySelector('.main-hid-img').classList.remove('hidden')
                content.querySelector('.sec-hid-img').querySelectorAll('span').forEach(function (item){
                    item.remove()
                })
                content.querySelector('.sec-hid-img').classList.add('hidden')
                const contentProducts = document.querySelector('.contentProducts')
                contentProducts.querySelectorAll('form').forEach(function (form){
                    form.remove()
                })
                res.products.forEach(function (product){
                    updateContent(product)
                })
                displaying(res.result,'success')
            }else{
                displaying(res.result)
            }
        })
        .catch(error=>{
            displaying(error)
        })
}
//Функция редактирования книги
function productEditHandler(e){
    e.preventDefault()
    const form=e.target
    const formData = new FormData(form)
    fetch('/api/product/update',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            if(res.products){
                const content = document.querySelector('.contentProducts')
                content.querySelectorAll('form').forEach(function (form){
                    form.remove()
                })
                res.products.forEach(function (product){
                    updateContent(product)
                })
                displaying(res.result,'success')
            }else{
                displaying(res.result)
            }
        })
        .catch(error=>{
            displaying(error)
        })
}
// Расскрытие и скрытие элементов редактирования
function productEditOpenHandler(target){
    const contentEdit=target.parentNode.parentNode.querySelector('.product-contentEdit')
    const id = target.dataset.id
    const name = target.dataset.name
    if(id){
        contentEdit.querySelector('select').required= contentEdit.querySelector('select').required ? false: true
        contentEdit.querySelector('select').querySelectorAll('option').forEach(function (item){
            if(item.value === id){
                item.selected=true
                return
            }
        })
    }
    if(name) {
        if(contentEdit.querySelector('input')){
            contentEdit.querySelector('input').required= contentEdit.querySelector('input').required ? false: true
            contentEdit.querySelector('input').value = name
        }
        if(contentEdit.querySelector('textarea')){
            contentEdit.querySelector('textarea').required= contentEdit.querySelector('textarea').required ? false: true
            contentEdit.querySelector('textarea').value = name
        }
    }
    contentEdit.classList.toggle('hidden')
}

//Обновление контента страницы
function updateContent(product){
    const content = document.querySelector('.contentProducts')
    const clone = document.querySelector('.productEditForm.clone').cloneNode(true)
    const sec_img =clone.querySelector('.sec-hid-img').querySelector('span').cloneNode(true)
    const genreClone =clone.querySelector('.genreClone').cloneNode(true)
    clone.querySelector('.sec-hid-img').querySelector('span').remove()
    clone.querySelector('.genreContent').querySelector('.genreClone').remove()
    clone.classList.remove('hidden')
    clone.classList.remove('clone')
    let num =0
    if(content.querySelectorAll('.num').length>0){
        const lastHead =content.querySelectorAll('.num')[content.querySelectorAll('.num').length-1]
        num = Number(lastHead.innerHTML.slice(-1))
    }
    clone.querySelector('.num').innerHTML="# "+(num+1)
    clone.querySelector('input[name="id"]').value=product.id
    clone.querySelector('[data-toggle="#productDelete"]').dataset.id =product.id
    clone.querySelector('[data-toggle="#productDelete"]').dataset.name =product.name
    clone.querySelector('input[name="old_main_img"]').value=product.image
    clone.querySelector('.main_img[src]').src='storage/'+product.image
    clone.querySelector('.main_img[src]').title='Гл. изображение книги '+product.name
    product.images.forEach(function (image){
        const option = document.createElement('option')
        const clonSec=sec_img.cloneNode(true)
        option.value=image.image
        option.selected=true
        clone.querySelector('select[name="old_images[]"]').append(option)
        clonSec.querySelector('img').src= 'storage/'+image.image
        clonSec.querySelector('img').title ='Доп. изображение книги '+product.name+' № '+image.id
        clone.querySelector('.sec-hid-img').append(clonSec)
    })
    clone.querySelector('.isbn').innerHTML=product.ISBN
    clone.querySelector('label[for="ISBN"]').querySelector('.product-edit').dataset.name=product.ISBN
    clone.querySelector('.name').innerHTML=product.name
    clone.querySelector('label[for="name"]').querySelector('.product-edit').dataset.name=product.name
    clone.querySelector('.price').innerHTML=product.price
    clone.querySelector('label[for="price"]').querySelector('.product-edit').dataset.name=product.price
    clone.querySelector('.pages').innerHTML=product.pages
    clone.querySelector('label[for="pages"]').querySelector('.product-edit').dataset.name=product.pages
    clone.querySelector('.year_release').innerHTML=product.year_release
    clone.querySelector('label[for="year_release"]').querySelector('.product-edit').dataset.name=product.year_release
    clone.querySelector('.limit').innerHTML=product.limit.name
    clone.querySelector('label[for="limit"]').querySelector('.product-edit').dataset.id=product.limit.id
    clone.querySelector('label[for="description"]').querySelector('.product-edit').dataset.name=product.description
    clone.querySelector('.description').innerHTML=product.description
    clone.querySelector('.author').innerHTML=product.author.last_name+" "+product.author.initials
    clone.querySelector('[data-toggle="#authorDelete"]').dataset.id =product.author.id
    clone.querySelector('[data-toggle="#authorDelete"]').dataset.first_name =product.author.first_name
    clone.querySelector('[data-toggle="#authorDelete"]').dataset.last_name =product.author.last_name
    clone.querySelector('[data-toggle="#authorDelete"]').dataset.father_name =product.author.father_name
    clone.querySelector('[data-toggle="#authorEdit"]').dataset.id =product.author.id
    clone.querySelector('[data-toggle="#authorEdit"]').dataset.first_name =product.author.first_name
    clone.querySelector('[data-toggle="#authorEdit"]').dataset.last_name =product.author.last_name
    clone.querySelector('[data-toggle="#authorEdit"]').dataset.father_name =product.author.father_name
    clone.querySelector('label[for="author"]')
        .querySelector('.product-edit').dataset.id=product.author.id
    clone.querySelector('.publisher').innerHTML=product.publisher.name
    clone.querySelector('[data-toggle="#publisherDelete"]').dataset.id =product.publisher.id
    clone.querySelector('[data-toggle="#publisherDelete"]').dataset.name =product.publisher.name
    clone.querySelector('[data-toggle="#publisherEdit"]').dataset.id =product.publisher.id
    clone.querySelector('[data-toggle="#publisherEdit"]').dataset.name =product.publisher.name
    clone.querySelector('label[for="publisher"]')
        .querySelector('.product-edit').dataset.id=product.publisher.id
    if(product.genres.length===0){
        clone.querySelector('label[for="genre"]').querySelector('.product-edit').classList.remove('hidden')
    }
    product.genres.forEach(function(genre){
        const option = document.createElement('option')
        option.value=genre.genre.id
        option.selected=true
        clone.querySelector('select[name="old_genre[]"]').append(option)
        genreClone.querySelector('.genre').innerHTML= genre.genre.name
        genreClone.querySelector('.genreLabel').querySelector('.product-edit').dataset.id =genre.genre.id
        genreClone.querySelector('[data-toggle="#genreDelete"]').dataset.id=genre.genre.id
        genreClone.querySelector('[data-toggle="#genreDelete"]').dataset.name=genre.genre.name
        genreClone.querySelector('[data-toggle="#genreEdit"]').dataset.id=genre.genre.id
        genreClone.querySelector('[data-toggle="#genreEdit"]').dataset.name=genre.genre.name
        clone.querySelector('.genreContent').append(genreClone)
    })
    clone.addEventListener('submit',productEditHandler)
    content.append(clone)
}
//Вывод сообщения на страницу
function displaying(message,result='danger'){
    const mes = document.querySelector('.message')
    mes.className='message w-full px-10 py-5'
    let bg=''
    switch (result){
        case "danger":
            bg='bg-red-500'
            break;
        case "success":
            bg='bg-green-500'
            break;
        case "primary":
            bg='bg-blue-500'
            break;
    }
    mes.classList.add(bg)
    mes.innerHTML=message
}

//Заполнение модальных окон редактирования
function editModalHandler(target){
    const modal=document.querySelector(target.dataset.toggle)
    let id = ''
    let name = ''
    let first_name =''
    let last_name =''
    let father_name =''
    if(!!target.dataset.id){
         id = target.dataset.id
         name = target.dataset.name
         first_name =target.dataset.first_name
         last_name =target.dataset.last_name
         father_name =target.dataset.father_name
    }else{
        id = target.parentNode.dataset.id
        name = target.parentNode.dataset.name
        first_name =target.parentNode.dataset.first_name
        last_name =target.parentNode.dataset.last_name
        father_name =target.parentNode.dataset.father_name
    }
    modal.querySelector('input[name="id"]').value=id
    if(!!name) modal.querySelector('input[name="name"]').value=name
    if(!!first_name) {
        modal.querySelector('input[name="first_name"]').value = first_name
        modal.querySelector('input[name="last_name"]').value = last_name
        modal.querySelector('input[name="father_name"]').value = father_name
    }
}
//Заполнение модальных окон уаления
function deleteModalHandler(target){
    const modal=document.querySelector(target.dataset.toggle)
    let id = ''
    let name = ''
    let first_name =''
    let last_name =''
    let father_name =''
    if(!!target.dataset.id){
        id = target.dataset.id
        name = target.dataset.name
        first_name =target.dataset.first_name
        last_name =target.dataset.last_name
        father_name =target.dataset.father_name
    }else{
        id = target.parentNode.dataset.id
        name = target.parentNode.dataset.name
        first_name =target.parentNode.dataset.first_name
        last_name =target.parentNode.dataset.last_name
        father_name =target.parentNode.dataset.father_name
    }
    modal.querySelector('input[name="id"]').value=id
    if(!!name)
        modal.querySelector('label').innerHTML='Действительно удалить '+name+'?'
    if(!!first_name)
        modal.querySelector('label').innerHTML='Действительно удалить '+first_name+" "+last_name+" "+father_name+"?"

}
//Добавление ещё одного поля жанра
function addGenreHandler(target){
    let content = target.parentNode.parentNode
    let cloneGenre = target.parentNode.cloneNode(true)
    if(cloneGenre.classList.contains('product-contentEdit')){
        content = target.parentNode.parentNode.parentNode
        cloneGenre = target.parentNode.parentNode.cloneNode(true)
        cloneGenre.querySelector('.genreLabel').querySelectorAll('span').forEach(function (item){
            item.remove()
        })
    }
    const btn=cloneGenre.querySelector('.addGenre')
    btn.className='remGenre text-black ring-red-600 active:bg-red-800 focus:border-red-900 hover:bg-red-700 bg-red-600 inline-flex mx-1 items-center p-1.5 border border-transparent rounded-md focus:outline-none focus:ring disabled:opacity-25 transition ease-in-out duration-150'
    btn.title='Удалить строку'
    btn.innerHTML='-'
    content.append(cloneGenre)
}
//Добавление ещё одного поля жанра
function removeGenreHandler(target){
    let cloneGenre = target.parentNode
    if(cloneGenre.classList.contains('product-contentEdit')){
        cloneGenre = target.parentNode.parentNode
    }
    cloneGenre.remove()
}
//Изменение кнопок редактирования и удаления жанров при изменении списка
function editGenreHandler(target){
    const content = target.parentNode
    const btnDelete = content.querySelector('[data-toggle="#genreDelete"]')
    const btnEdit = content.querySelector('[data-toggle="#genreEdit"]')
    btnDelete.dataset.id = target.options[target.selectedIndex].value
    btnEdit.dataset.id = target.options[target.selectedIndex].value
    btnDelete.dataset.name = target.options[target.selectedIndex].innerHTML
    btnEdit.dataset.name = target.options[target.selectedIndex].innerHTML
}

//Удаление товара
function productDeleteHandler(e){
    e.preventDefault()
    const form=document.querySelector('#productDeleteForm')
    const modal = document.querySelector('#productDelete')
    const formData = new FormData(form)
    fetch('/api/product/delete',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    }).then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.products){
                const content = document.querySelector('.contentProducts')
                content.querySelectorAll('form').forEach(function (form){
                    form.remove()
                })
                res.products.forEach(function (product){
                    updateContent(product)
                })
                displaying(res.result,'success')
            }else{
                displaying(res.result)
            }
        })
        .catch(error=>{
            displaying(error)
        })
}

//Запрос данных из поисковой строки
function searchHandler(e){
    const textSearch = document.querySelector('input[type="search"]').value
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    fetch("/api/product/search", {
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
            search: textSearch
        })
    }).then(res=>res.json())
        .then(res=>{
            if(res.products){
                const content = document.querySelector('.contentProducts')
                content.querySelectorAll('form').forEach(function (form){
                    form.remove()
                })
                res.products.forEach(function (product){
                    updateContent(product)
                })
            }else{
                displaying(res)
            }
        })
        .catch(error=>{
            displaying(error)
        })
}

//Иниализация прослушиваний
function init(){
    const container = document.querySelector('.container')
    const search = document.querySelector('#search');
    const productCreateForm = document.querySelector('#productCreateForm')
    const productEditForm = document.querySelectorAll('.productEditForm')
    const productDeleteForm = document.querySelector('#productDeleteForm')
    container.addEventListener('click',function (e){
        if(e.target && e.target.matches('.product-edit')){
            productEditOpenHandler(e.target)
        }
        if(e.target && ((e.target.matches('[data-toggle="#genreEdit"]'))
            || (e.target.matches('[data-toggle="#authorEdit"]'))
            || (e.target.matches('[data-toggle="#publisherEdit"]'))
            )){
            editModalHandler(e.target)
        }
        if(e.target && ((e.target.matches('[data-toggle="#genreDelete"]'))
            || (e.target.matches('[data-toggle="#authorDelete"]'))
            || (e.target.matches('[data-toggle="#publisherDelete"]'))
            || (e.target.matches('[data-toggle="#productDelete"]'))
        )){
            deleteModalHandler(e.target)
        }
        if(e.target && e.target.matches('.addGenre')){
            addGenreHandler(e.target)
        }
        if(e.target && e.target.matches('.remGenre')){
            removeGenreHandler(e.target)
        }
    })
    container.addEventListener('change',function (e){
        if(e.target && e.target.matches('select[name="genre[]"]')){
            editGenreHandler(e.target)
        }
    })
    productCreateForm.addEventListener('submit',productCreateHandler)
    productEditForm.forEach(function(item){
        item.addEventListener('submit',productEditHandler)
    })
    productDeleteForm.addEventListener('submit',productDeleteHandler)
    search.addEventListener('click',searchHandler)
}
init()
