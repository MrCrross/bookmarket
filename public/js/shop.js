function dropdownHandler(e){
    let i=1
    let content= e.target
    while (i>0){
        content = content.parentNode
        if(content.querySelector('.dropdown_content')){
            break
        }
    }
    content.querySelector('.dropdown_content').classList.toggle('hidden')
}


function descHandler(e){
    if(e.target.classList.contains('descOpen')){
        e.target.parentNode.classList.toggle('hidden')
        e.target.parentNode.parentNode.querySelector('.descClose').parentNode.classList.toggle('hidden')
    }
    if(e.target.classList.contains('descClose')){
        e.target.parentNode.classList.toggle('hidden')
        e.target.parentNode.parentNode.querySelector('.descOpen').parentNode.classList.toggle('hidden')
    }
}

function init(){
    const dropdown = document.querySelectorAll('.dropdown')
    const descOpen = document.querySelectorAll('.descOpen')
    const descClose = document.querySelectorAll('.descClose')
    dropdown.forEach(function (item){
        item.addEventListener('click',dropdownHandler)
    })
    descOpen.forEach(function (item){
        item.addEventListener('click',descHandler)
    })
    descClose.forEach(function (item){
        item.addEventListener('click',descHandler)
    })
}
init()
