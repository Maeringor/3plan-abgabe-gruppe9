function startTimer(){
    setInterval(function(){

        const dateTimeField = document.querySelector('.time-date');
        const date = new Date();
        
        let h = formatDateTime(date.getHours());
        let min = formatDateTime(date.getMinutes());
        
        let day = formatDateTime(date.getDate());
        let month = formatDateTime(date.getMonth()+1);
        
        function formatDateTime(val,
             format = val < 10 ? "0"+val : val) {
            return format;
        }
        
        dateTimeField.innerHTML= h+":"+min +" "+day+"."+month+"."+date.getFullYear();
        }, 1000);
}

startTimer();
