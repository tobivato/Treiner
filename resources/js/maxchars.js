document.querySelectorAll('[data-length-indicator]').forEach(element => {
    element.oninput = function() {
        let length = element.value.length;        
        let indicator = document.getElementById(element.dataset.lengthIndicator);        
        indicator.innerHTML = element.maxLength - length;
    };
});