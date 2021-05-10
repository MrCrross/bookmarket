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
        .then(res=> res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.authors){
                const authors = document.querySelectorAll('select[name="author[]"]')
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
                const author = document.querySelectorAll('select[name="author"]')
                author.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.authors.forEach(function (el){
                        const option = document.createElement('option')
                        option.value= el.id
                        option.innerHTML = el.last_name+' '+el.first_name+" "
                        if(el.father_name) option.innerHTML+=el.father_name
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

//Функция удаления автора
function authorEditHandler(e){
    e.preventDefault()
    const form=document.querySelector('#authorEditForm')
    const modal = document.querySelector('#authorEdit')
    const formData = new FormData(form)
    fetch('/api/author/update',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.authors){
                const authors = document.querySelectorAll('select[name="author[]"]')
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
                const author = document.querySelectorAll('select[name="author"]')
                author.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.authors.forEach(function (el){
                        const option = document.createElement('option')
                        option.value= el.id
                        option.innerHTML = el.last_name+' '+el.first_name+" "
                        if(el.father_name) option.innerHTML+=el.father_name
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

//Функция изменения автора
function authorDeleteHandler(e){
    e.preventDefault()
    const form=document.querySelector('#authorDeleteForm')
    const modal = document.querySelector('#authorDelete')
    const formData = new FormData(form)
    fetch('/api/author/delete',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.authors){
                const authors = document.querySelectorAll('select[name="author[]"]')
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
                const author = document.querySelectorAll('select[name="author"]')
                author.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.authors.forEach(function (el){
                        const option = document.createElement('option')
                        option.value= el.id
                        option.innerHTML = el.last_name+' '+el.first_name+" "
                        if(el.father_name) option.innerHTML+=el.father_name
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
    const authorCreateForm = document.querySelector('#authorCreateForm')
    const authorEditForm = document.querySelector('#authorEditForm')
    const authorDeleteForm = document.querySelector('#authorDeleteForm')
    authorCreateForm.addEventListener('submit',authorCreateHandler)
    authorEditForm.addEventListener('submit',authorEditHandler)
    authorDeleteForm.addEventListener('submit',authorDeleteHandler)
}
init()
