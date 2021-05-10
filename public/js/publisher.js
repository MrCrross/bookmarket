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
                const publishers = document.querySelectorAll('select[name="publisher[]"]')
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
                const publisher = document.querySelectorAll('select[name="publisher"]')
                publisher.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.publishers.forEach(function (el){
                        const option = document.createElement('option')
                        option.value= el.id
                        option.innerHTML = el.name
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

//Функция изменения издательства
function publisherEditHandler(e){
    e.preventDefault()
    const form=document.querySelector('#publisherEditForm')
    const modal = document.querySelector('#publisherEdit')
    const formData = new FormData(form)
    fetch('/api/publisher/update',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.publishers){
                const publishers = document.querySelectorAll('select[name="publisher[]"]')
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
                const publisher = document.querySelectorAll('select[name="publisher"]')
                publisher.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.publishers.forEach(function (el){
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

//Функция удаления издательства
function publisherDeleteHandler(e){
    e.preventDefault()
    const form=document.querySelector('#publisherDeleteForm')
    const modal = document.querySelector('#publisherDelete')
    const formData = new FormData(form)
    fetch('/api/publisher/delete',{
        method: "POST",
        credentials: "same-origin",
        body: formData
    })
        .then(res=>res.json())
        .then(res=>{
            modal.querySelector('a[data-hystclose]').click()
            if(res.publishers){
                const publishers = document.querySelectorAll('select[name="publisher[]"]')
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
                const publisher = document.querySelectorAll('select[name="publisher"]')
                publisher.forEach(function (item){
                    item.querySelectorAll('option').forEach(function (option){
                        option.remove()
                    })
                    res.publishers.forEach(function (el){
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
    const publisherCreateForm = document.querySelector('#publisherCreateForm')
    const publisherEditForm = document.querySelector('#publisherEditForm')
    const publisherDeleteForm = document.querySelector('#publisherDeleteForm')
    publisherCreateForm.addEventListener('submit',publisherCreateHandler)
    publisherEditForm.addEventListener('submit',publisherEditHandler)
    publisherDeleteForm.addEventListener('submit',publisherDeleteHandler)
}
init()
