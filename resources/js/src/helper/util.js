import { showError, successMsg } from "./toast-notification"

export function ShowErrorResponse(error){
    if(Array.isArray(error.errors)){
        for(const message of error.errors){
            showError(message)
        }
    }else{
        showError(error.message)
    }

}

export function myDebounce(func, delay) {
    let timer;

    return function() {
        clearTimeout(timer);
        timer = setTimeout(() => func(), delay);
    };
}

export function openModal(element){
     return new Promise((resolve) => {
        var modal = document.getElementById(element)

        if(modal){
            setTimeout(() => {
                modal.classList.add('fade','show')
                modal.style.display = 'block'
                modal.classList.add('in')
            },200)

            document.body.classList.add('modal-open')
    
            var modalBackdrop = document.createElement('div')
            modalBackdrop.className = 'modal-backdrop fade show'
            document.body.appendChild(modalBackdrop)
        }
        resolve(modal)
     })
}

export function closeModal(element){
    var modal = document.getElementById(element)
    var modalBackdrop = document.querySelector('.modal-backdrop')

    if (modal) {
        // Remove added classes
        modal.classList.remove('in', 'show', 'fade')
        modal.style.display = ''
    
        document.body.classList.remove('modal-open')
    
        // Remove the modal backdrop element
        if (modalBackdrop) {
          document.body.removeChild(modalBackdrop)
        }
      }
}

export function getChar(str){
    if(typeof str !== 'undefined'){
        const index = 1
        if(index >= 0 && index < str.length){
            return str.charAt(index).toLocaleUpperCase()
        }else{
            return ''
        }
    }
}