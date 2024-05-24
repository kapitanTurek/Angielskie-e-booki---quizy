let clickCounter = 0;

function menuExpander(){
    if(clickCounter == 0){
        document.getElementById('listMenu').style.display = "block";
        document.getElementById('downArrowIcon').style.transform = "rotate(180deg)";
        clickCounter = 1;
    }
    else{
        document.getElementById('listMenu').style.display = "none";
        document.getElementById('downArrowIcon').style.transform = "rotate(0deg)";
        clickCounter = 0;
    }
}

function quizPreviewGenerator(){
    let contentHolder = document.getElementById("infos");
    
    let br1 = document.createElement("br");

    let pageTitle = document.createElement("h1");
    pageTitle.textContent = "Zarządzaj kategoriami w jednym miejscu";
    pageTitle.className = "writtenTitle";

    let informationText = document.createElement("p");
    informationText.textContent = 'Kliknij "+" w celu dodania nowej kategorii, "x" w celu usunięcia istniejącej już kategorii';

    contentHolder.appendChild(pageTitle);
    contentHolder.appendChild(informationText);
    contentHolder.appendChild(br1);

    let categoryData = document.getElementById('hiddenCategories').value;
    let categoriesString = categoryData.split('|');

    let categoriesQuantity = document.getElementById('hiddenQuantities').value;
    let quantityString = categoriesQuantity.split('|');

    let categorieID = document.getElementById('hiddenIDs').value;
    let categoriesIDString = categorieID.split('|');

    let categoryHolder = document.createElement("table");
    categoryHolder.className = "col-sm-12 dataTable";
    categoryHolder.id = "dataTable";

    contentHolder.appendChild(categoryHolder);

    let counter = 0;

    nameArray = ['Lp', 'Name', 'Quantity', 'DelButton']
    for(let j=0; j < categoriesString.length+1; j += 1){
        let rowHolder = document.createElement("tr");
        if(counter == 1){
            rowHolder.className = "tableRowColored";
            counter = 0;
        }
        else{
            rowHolder.className = "tableRow";
            counter += 1;
        }

        for(let k = 0; k < 4; k += 1){
            if(j == 0){
                let cellHolder = document.createElement("th");
                cellHolder.className = "tableCell" + nameArray[k];
                cellHolder.id = "tableCell" + nameArray[k] + j;

                rowHolder.appendChild(cellHolder);
            }
            else{
                let cellHolder = document.createElement("td");
                cellHolder.className = "tableCell" + nameArray[k];
                cellHolder.id = "tableCell" + nameArray[k] + j;

                rowHolder.appendChild(cellHolder);
            }
        }

        categoryHolder.appendChild(rowHolder);
    }

    for(let j=0; j<categoriesString.length+1; j += 1){
        let lpCell = document.getElementById('tableCellLp' + j)
        let nameCell = document.getElementById('tableCellName' + j);
        let quantityCell = document.getElementById('tableCellQuantity' + j);
        let buttonCell = document.getElementById('tableCellDelButton' + j);

        if(j != 0){
            let LpHolder = document.createElement("span");
            LpHolder.textContent = (j) + ".";

            let categoryNameHolder = document.createElement("span");
            categoryNameHolder.textContent = categoriesString[j-1];

            let categoryQuantityHolder = document.createElement("span");
            if(quantityString != ""){
                categoryQuantityHolder.textContent = quantityString[j-1];
            }
            else{
                categoryQuantityHolder.textContent = 0;
            }

            let closeBtn = document.createElement("button");
            closeBtn.className = "btn-private-negative";
            closeBtn.setAttribute("onClick", "deleteCategoryHTTPRequest(" + categoriesIDString[j-1] + ")");
            closeBtn.textContent = "X";

            lpCell.appendChild(LpHolder);
            nameCell.appendChild(categoryNameHolder);
            quantityCell.appendChild(categoryQuantityHolder);
            buttonCell.appendChild(closeBtn);
        }
        else{
            let LpHolder = document.createElement("span");
            LpHolder.textContent = "Lp.";

            let categoryNameHolder = document.createElement("span");
            categoryNameHolder.textContent = "Nazwa kategorii";

            let categoryQuantityHolder = document.createElement("span");
            categoryQuantityHolder.textContent = "Ilość quizów danej kategorii";

            let closeBtn = document.createElement("span");
            closeBtn.textContent = "Usuń kategorię";

            lpCell.appendChild(LpHolder);
            nameCell.appendChild(categoryNameHolder);
            quantityCell.appendChild(categoryQuantityHolder);
            buttonCell.appendChild(closeBtn);
        }
    }

    let newCategoryBox = document.createElement("div");
    newCategoryBox.className = "col-sm-12";
    newCategoryBox.id = "newCategoryHolder";

    let br2 = document.createElement("br");
    let br3 = document.createElement("br");

    let addButton = document.createElement("input");
    addButton.type = "button";
    addButton.className = "btn-private";
    addButton.id = "addCategory";
    addButton.setAttribute("onclick", "addCategory()");
    addButton.value = "+";

    contentHolder.appendChild(br2);
    contentHolder.appendChild(newCategoryBox);
    contentHolder.appendChild(br3);
    contentHolder.appendChild(addButton);
}

document.addEventListener("onload", quizPreviewGenerator());

function deleteCategoryHTTPRequest(categoryNumber){
    window.location = "../php/deleteCategory.php?id=" + categoryNumber;
}

function addCategory(){
    let inputHolder = document.getElementById("newCategoryHolder");

    let newForm = document.createElement("form");
    newForm.id = "exerciseFormHolder";
    newForm.method = "POST";
    newForm.action = "../php/addCategory.php";

    let newCategoryInput = document.createElement("input");
    newCategoryInput.type = "text";
    newCategoryInput.className = "quizInput";
    newCategoryInput.id = "categoryName";
    newCategoryInput.name = "categoryName";
    newCategoryInput.placeholder = "Nazwa nowej kategorii";

    let sendDataOnServerButtonn = document.createElement("input");
    sendDataOnServerButtonn.type = "submit";
    sendDataOnServerButtonn.className = "btn-private";
    sendDataOnServerButtonn.name = "dataTransfer";
    sendDataOnServerButtonn.value = "Stwórz kategorię";

    inputHolder.appendChild(newForm);
    newForm.appendChild(newCategoryInput);
    newForm.appendChild(sendDataOnServerButtonn);

    let addButton = document.getElementById('addCategory');
    addButton.style.display = "none";
}