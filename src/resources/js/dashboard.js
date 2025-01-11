document.querySelectorAll(".edit").forEach(btn => {
    btn.onclick = function () {
        const tr = this.parentElement.parentElement;
        const form = document.querySelector("form");
        if (!form.classList.contains("shown")) {
            form.classList.add("shown");
            form.classList.remove("hidden");
        }
        //document.getElementById("input-vinyl_stock").value = tr.childNodes[1].dataset.stock;
        console.log(tr.childNodes[1]);
    }   
})