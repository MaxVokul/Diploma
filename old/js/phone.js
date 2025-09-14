let input = document.querySelector('.phone');
input.addEventListener('input', function(e){
    if(e.inputType === 'deleteContentForward' || e.inputType === 'deleteContentBackward') return false
    this.value = this.value.replace(/\D/g,'')
    if(/^[8]/.test(this.value)){
        this.value = this.value.replace(/^[8]/, '+7')
    }else{
        this.value = '+' + this.value
    }
    let start = 2;
    let max = 14
    let obj = {
        0: '(',
        4: ')',
        8: '-',
        11: '-',
    }
    for (let char in obj){
        if(this.value[start+(+char)]) {
            this.value = this.value.substring(0, start+(+char)) + obj[char] + this.value.substring(start+(+char))
        }
    }
    if(this.value[max+start]){
        this.value = this.value.substring(0, start + max)
    }
})
