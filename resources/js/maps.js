window.addEventListener("DOMContentLoaded", function () {
   let styleEl = document.createElement("style");
   let css = `
        #map-container {
            display: flex;
            background-color: #ffffff;
        }

        #customer-list-container {
            position: relative;
            width: 200px;
            background-color: transparent;
        }

        #customer-list {
            list-style: none;
            padding: 0;
            margin: 0;
            width: 250px;
            background-color: transparent;
            overflow-y: auto;
        }

        .hidden {
            display: none;
        }

        #customer-counter {
            position: absolute;
            top: 0;
            right: 0;
            background-color: #ccc;
            color: #333;
            padding: 4px 8px;
            font-size: 12px;
        }

        #search-input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        #map {
            flex: 1;
            width: 100%;
            height: 800px;
        }

        #customer-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .customer-item {
            padding: 5px;
            padding-left: 10px;
            border-bottom: 1px solid #ccc;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .customer-item:hover {
            background-color: #f2f2f2;
        }

        #customer-list-container {
            max-height: 800px;
            max-width: 200px;
            overflow-y: auto;
        }

        #toggleButton {
            float: right;
            margin-top: 5px;
        }

        #customer-counter {
            float: right;
            margin-top: 12px;
            margin-right: 10px;
            font-size: 14px;
        }
    `;
   styleEl.appendChild(document.createTextNode(css));

   document.head.appendChild(styleEl);
});
