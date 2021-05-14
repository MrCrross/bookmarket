function ajaxClearCart(user_id)
{
    const token= document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    fetch('/api/cart/clear',{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
            user_id:user_id
        })
    })
}

function ajax(productId, count=1)
{
    const token= document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    fetch('/api/cart',{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token
        },
        method: "post",
        credentials: "same-origin",
        body: JSON.stringify({
            productId: productId,
            count: count
        })
    })
}

function ajaxUpdate(productId, count=1)
{
    const token= document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    fetch('/api/cart/update',{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token
        },
        method: "POST",
        credentials: "same-origin",
        body: JSON.stringify({
            productId: productId,
            count: count
        })
    })
}

function cartHandler(e){
    const product= e.target.dataset.id
    const carts= localStorage.getItem('carts')
    let data = []
    if(carts){
        if(carts.indexOf('\\"product_id\\":'+product)===-1
            && carts.indexOf('\\"product_id\\":'+'\\"'+product+'\\"')===-1) {
            data = JSON.parse(JSON.parse(carts))
            data.push({
                product_id:product,
                count:1
            })
            localStorage.setItem('carts',JSON.stringify(JSON.stringify(data)))
            if(window.isLogin!=='0') ajax(product)
        }
    }else{
        data.push({
            product_id:product,
            count:1
        })
        localStorage.setItem('carts',JSON.stringify(JSON.stringify(data)))
        if(window.isLogin!=='0') ajax(product)
    }
    location.reload()
}

function countHandler(e){
    let cart =localStorage.getItem('carts')
    let data = JSON.parse(JSON.parse(cart))
    data.forEach(function (el){
        if(el.product_id === e.target.dataset.id){
            el.count=e.target.value
            return
        }
    })
    localStorage.setItem('carts',JSON.stringify(JSON.stringify(data)))
    if(window.isLogin!=='0') ajaxUpdate(e.target.dataset.id,e.target.value)
    calcToPay()
}

function calcToPay(){
    const count = document.querySelectorAll('input[name="count[]"]')
    const to_pay =document.querySelector('.to_pay')
    let price =0
    let pay=0
    count.forEach(function(item){
        price=Number(item.value) * Number(item.dataset.price)
        pay+=price
        item.parentNode.parentNode.parentNode.querySelector('.price').innerHTML=price+' руб.'
    })
    to_pay.innerHTML=pay+' руб.'
}

function cartSubmitHandler(e){
    e.preventDefault()
    localStorage.removeItem('carts')
    ajaxClearCart(window.isLogin)
    e.target.submit()
}

function init(){
    const cartBtns = document.querySelectorAll('.cartBuy')
    const navCart = document.querySelectorAll('.navCart')
    const count = document.querySelectorAll('input[name="count[]"]')
    const cartForm = document.querySelector('#cartForm')
    const cart = localStorage.getItem('carts')
    if(navCart.length!==0){
        navCart.forEach(function (item){
            let data =[]
            if(cart){
                data = JSON.parse(JSON.parse(cart))
                item.parentNode.querySelector('input[name="products"]').value =JSON.parse(cart)
            }
            item.innerHTML='Корзина '+data.length
        })
        cartBtns.forEach(function (item){
            item.addEventListener('click',cartHandler)
            if(cart) {
                if (cart.indexOf('\\"product_id\\":'+item.dataset.id) !== -1
                    || cart.indexOf('\\"product_id\\":'+'\\"'+item.dataset.id+'\\"') !== -1) {
                    item.classList.toggle('hidden')
                    item.parentNode.querySelector('.cart').classList.toggle('hidden')
                }
            }
        })
    }
    if(count.length!==0){
        let data=[]
        count.forEach(function(item){
            item.addEventListener('change',countHandler)
            if(cart){
                data = JSON.parse(JSON.parse(cart))
                data.forEach(function (el){
                    if(el.product_id === item.dataset.id){
                        item.value=el.count
                        return
                    }
                })
            }
        })
        calcToPay()
    }
    if(cartForm){
        cartForm.addEventListener('submit',cartSubmitHandler)
    }
}

init()
