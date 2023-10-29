window.addEventListener("DOMContentLoaded", function () {
    let styleEl = document.createElement("style");
    let css = `
        *{
         box-sizing:border-box;
         margin:0;
         padding:0;
        }
        #app{
         position:relative;
         background-color:#eee;
         height:100vh;
         width:100vw;
        }
        .search-bar-container{
         position:absolute;
         left:10px;
         display:flex;
         flex-direction:column;
         align-items:center;
         min-width:250px;
         z-index:1000;
        }
        .input-wrapper{
         background-color:white;
         width:100%;
         border-radius:10px;
         height:2.5rem;
         padding: 0 15px;
         box-shadow: 0px 0px 8px #ddd;
         display:flex;
         align-items:center;
        }
         .input-wrapper input{
            background-color:transparent;
            border:none;
            height:100%;
            font-size:1.25rem;
            width:100%;
            margin-left:5px;
        }
        .input-wrapper input:focus{
         outline:none;
        }
        .input-wrapper #searchIcon{
         color:blue;
        }
        #map{
         position:absolute;
         height:100vh;
         width:75vw;
        }
        .result-list{
         width:100%;
         background-color:white;
         display:flex;
         flex-direction:column;
         box-shadow: 0px 0px 8px #ddd;
         border-radius:10px;
         margin-top:1rem;
         max-height:300px;
         overflow-y:scroll;
        }
        .result-list .search-result{
         padding:5px 10px;
        }
        .result-list .search-result:hover {
         background-color:#77db77;
        }
    `;
    styleEl.appendChild(document.createTextNode(css));

    document.head.appendChild(styleEl);


    const nameList = this.document.getElementById('nameList');

    fetch('api/get/users/names')
        .then(response => response.json())
        .then(data => {
            const names = data.data;
            for (const userCode in names) {
                if (names.hasOwnProperty(userCode)) {
                    const name = names[userCode];
                    const listItem = document.createElement("div");
                    listItem.className = "search-result";
                    listItem.textContent = name;
                    nameList.appendChild(listItem);
                }
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});
