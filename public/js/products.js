//Функция добавления нового автора
function authorCreateHandler(e){
    e.preventDefault()
    const form=document.querySelector('#authorCreateForm')
    const modal = document.querySelector('#authorCreate')
    const formData = new FormData(form)
    fetch('/api/author',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.authors){
                const authors = document.querySelectorAll('select[name="author"]')
                authors.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.authors.forEach(function (author){
                        const option = document.createElement('option')
                        option.value= author.id
                        option.innerHTML = author.last_name+' '+author.first_name+" "
                        if(author.father_name) option.innerHTML+=author.father_name
                        item.append(option)
                    })
                })
                displaying(res.result,'success')
            }else{
                displaying(res.result)
            }
        })
        .catch(error=>{
            modal.querySelector('a[data-hystclose]').click()
            displaying(error)
         })
}

//Функция добавления нового издательства
function publisherCreateHandler(e){
    e.preventDefault()
    const form=document.querySelector('#publisherCreateForm')
    const modal = document.querySelector('#publisherCreate')
    const formData = new FormData(form)
    fetch('/api/publisher',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.publishers){
                const publishers = document.querySelectorAll('select[name="publisher"]')
                publishers.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.publishers.forEach(function (publisher){
                        const option = document.createElement('option')
                        option.value= publisher.id
                        option.innerHTML = publisher.name
                        item.append(option)
                    })
                })
                displaying(res.result,'success')
            }else{
                displaying(res.result)
            }
        })
        .catch(error=>{
            modal.querySelector('a[data-hystclose]').click()
            displaying(error)
        })
}

//Функция добавления нового жанра
function genreCreateHandler(e){
    e.preventDefault()
    const form=document.querySelector('#genreCreateForm')
    const modal = document.querySelector('#genreCreate')
    const formData = new FormData(form)
    fetch('/api/genre',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.genres){
                const genres = document.querySelectorAll('select[name="genre[]"]')
                genres.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.genres.forEach(function (genre){
                        const option = document.createElement('option')
                        option.value= genre.id
                        option.innerHTML = genre.name
                        item.append(option)
                    })
                })
                displaying(res.result,'success')
            }else{
                displaying(res.result)
            }
        })
        .catch(error=>{
            modal.querySelector('a[data-hystclose]').click()
            displaying(error)
        })
}

//Функция добавления нового жанра
function productCreateHandler(e){
    e.preventDefault()
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    const form=document.querySelector('#productCreateForm')
    const formData = form.querySelectorAll('.formData')
    let products=[]
    formData.forEach(function (item){
        const main_img = item.querySelector('input[type="file"][name="main_img"]').files[0]
        const images = item.querySelector('input[type="file"][name="images[]"]').files
        const ISBN = item.querySelector('input[name="ISBN"]').value
        const name = item.querySelector('input[name="name"]').value
        const price = item.querySelector('input[name="price"]').value
        const pages = item.querySelector('input[name="pages"]').value
        const year = item.querySelector('input[name="year_release"]').value
        const limit = item.querySelector('select[name="limit"]').value
        const author = item.querySelector('select[name="author"]').value
        const publisher = item.querySelector('select[name="publisher"]').value
        const genres = item.querySelectorAll('select[name="genre[]"]')
        let genre=[],image=[]
        genres.forEach(function (element){
            genre.push(element.value)
        })
        for(let i=0;i< images.length;i++){
            image.push(images[i])
        }
        products.push({
            main_img:main_img,
            ISBN,
            name,
            price,
            pages,
            year,
            limit,
            author,
            publisher,
            genres:genre,
            images:image
        })
    })
    fetch('/api/product',{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token
        },
        method: "POST",
        credentials: "same-origin",
        body: JSON.stringify({
            products:products
        })
    })
        .then(res=>res.json())
        .then(res=>{
            console.log(res)
            // if(res.genres){
            //     const genres = document.querySelectorAll('select[name="genre[]"]')
            //     genres.forEach(function (item){
            //         item.querySelectorAll('option').forEach(function (option){
            //             option.remove()
            //         })
            //         res.genres.forEach(function (genre){
            //             const option = document.createElement('option')
            //             option.value= genre.id
            //             option.innerHTML = genre.name
            //             item.append(option)
            //         })
            //     })
            //     displaying(res.result,'success')
            // }else{
            //     displaying(res.result)
            // }
        })
        .catch(error=>{
            displaying(error)
        })
}

//Вывод сообщения на страницу
function displaying(message,result='danger'){
    const mes = document.querySelector('.message')
    mes.classList.remove('hidden')
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

//Иниализация прослушиваний
function init(){
    const container = document.querySelector('.container')
    const productForm = document.querySelector('#productCreateForm')
    const authorForm = document.querySelector('#authorCreateForm')
    const publisherForm = document.querySelector('#publisherCreateForm')
    const genreForm = document.querySelector('#genreCreateForm')
    container.addEventListener('click',function (e){
        if(e.target && e.target.matches('button[type="submit"]')){

        }
    })
    productForm.addEventListener('submit',productCreateHandler)
    authorForm.addEventListener('submit',authorCreateHandler)
    publisherForm.addEventListener('submit',publisherCreateHandler)
    genreForm.addEventListener('submit',genreCreateHandler)
}
init()
