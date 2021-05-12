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
                const genres = document.querySelectorAll('select.genre')
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

//Функция изменения жанра
function genreEditHandler(e){
    e.preventDefault()
    const form=document.querySelector('#genreEditForm')
    const modal = document.querySelector('#genreEdit')
    const formData = new FormData(form)
    fetch('/api/genre/update',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.genres){
                const genres = document.querySelectorAll('select[name="genre[][]"]')
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
                const genre = document.querySelectorAll('select[name="genre[]"]')
                genre.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.genres.forEach(function (el){
                        const option = document.createElement('option')
                        option.value= el.id
                        option.innerHTML = el.name
                        item.append(option)
                    })
                })
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
            modal.querySelector('a[data-hystclose]').click()
            displaying(error)
        })
}

//Функция удаления жанра
function genreDeleteHandler(e){
    e.preventDefault()
    const form=document.querySelector('#genreDeleteForm')
    const modal = document.querySelector('#genreDelete')
    const formData = new FormData(form)
    fetch('/api/genre/delete',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.genres){
                const genres = document.querySelectorAll('select[name="genre[][]"]')
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
                const genre = document.querySelectorAll('select[name="genre[]"]')
                genre.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.genres.forEach(function (el){
                        const option = document.createElement('option')
                        option.value= el.id
                        option.innerHTML = el.name
                        item.append(option)
                    })
                })
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
            modal.querySelector('a[data-hystclose]').click()
            displaying(error)
        })
}

function init(){
    const genreCreateForm = document.querySelector('#genreCreateForm')
    const genreEditForm = document.querySelector('#genreEditForm')
    const genreDeleteForm = document.querySelector('#genreDeleteForm')
    genreCreateForm.addEventListener('submit',genreCreateHandler)
    genreEditForm.addEventListener('submit',genreEditHandler)
    genreDeleteForm.addEventListener('submit',genreDeleteHandler)
}

init()
