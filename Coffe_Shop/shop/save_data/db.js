window.onload = function() {
    function showCurrentDate() {
        let today = new Date();
        let day = String(today.getDate()).padStart(2, '0');
        let month = String(today.getMonth() + 1).padStart(2, '0'); 
        let year = today.getFullYear();
    
        let currentDate = day + '/' + month + '/' + year;
        document.getElementById("currentDate").innerText = currentDate;
    }
    
    showCurrentDate();

}
