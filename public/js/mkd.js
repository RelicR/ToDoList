function makeDates()
        {
            var timeCells = document.getElementsByName("tz");
            timeCells.forEach((item)=>{
                item.innerText=new Date(item.innerText*1000).toLocaleString();
            });
        }