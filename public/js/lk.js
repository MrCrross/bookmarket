function getLog(){
    const token= document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    return fetch('/api/user/log',{
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-Requested-With": "XMLHttpRequest",
            "X-CSRF-Token": token
        },
        method: "post",
        credentials: "same-origin",
    })
        .then(res=>res.json())
}

function submitHandler(e){
    e.target.submit()
}
function init(){
    document.querySelector('.personal').addEventListener('click',function (){
        document.querySelector('.passwordForm').classList.add('hidden')
        document.querySelector('.ordersForm').classList.add('hidden')
        if( document.querySelector('.logsForm'))  document.querySelector('.logsForm').classList.add('hidden')
        document.querySelector('.personalForm').classList.toggle('hidden')
    })
    document.querySelector('.password').addEventListener('click',function (){
        document.querySelector('.ordersForm').classList.add('hidden')
        document.querySelector('.personalForm').classList.add('hidden')
        if( document.querySelector('.logsForm'))  document.querySelector('.logsForm').classList.add('hidden')
        document.querySelector('.passwordForm').classList.toggle('hidden')
    })
    document.querySelector('.orders').addEventListener('click',function (){
        document.querySelector('.personalForm').classList.add('hidden')
        document.querySelector('.passwordForm').classList.add('hidden')
        if( document.querySelector('.logsForm'))  document.querySelector('.logsForm').classList.add('hidden')
        document.querySelector('.ordersForm').classList.toggle('hidden')
    })
    if(document.querySelector('.logs')){
        document.querySelector('.logs').addEventListener('click',function (){
            document.querySelector('.personalForm').classList.add('hidden')
            document.querySelector('.passwordForm').classList.add('hidden')
            document.querySelector('.ordersForm').classList.add('hidden')
            document.querySelector('.logsForm').classList.toggle('hidden')
        })
    }
}

init()
