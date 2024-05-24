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
    pageTitle.textContent = "Lista obecnie dostępnych quizów";
    pageTitle.className = "writtenTitle";

    let informationText = document.createElement("p");
    informationText.textContent = 'Kliknij dowolny quiz, w celu edytowania go. Klikając krzyżyk - usuniesz quiz! (nie ma opcji odwrócenia operacji)';

    contentHolder.appendChild(pageTitle);
    contentHolder.appendChild(informationText);
    contentHolder.appendChild(br1);

    //sprawdzić co jest dzielone przecinkiem
    let numberOfQuizes = document.getElementById("hiddenValue").value;
    let quizData = document.getElementById("quizData").value;
    let quizNames = quizData.split(",");

    let quizIDData = document.getElementById("quizIDData").value;
    let quizIDValues = quizIDData.split(",");

    let boxesHolder = document.createElement("div");
    boxesHolder.className = "col-sm-12 boxes";
    boxesHolder.id = "boxes";

    contentHolder.appendChild(boxesHolder);

    for(let j=0; j < (numberOfQuizes/3); j += 1){
        let rowHolder = document.createElement("div");
        rowHolder.className = "row";
        rowHolder.id = "quizesRow" + j;

        boxesHolder.appendChild(rowHolder);
    }

    let numberOfRowHolder = 0;
    for(let i=0; i<numberOfQuizes; i += 1){

        let newBox = document.createElement("div");
        newBox.className = "col-sm-4 quizBox";
        newBox.id = "quizBox" + i;

        let closer = document.createElement("div");
        closer.className = "col-sm-12 closer";

        let activeArea = document.createElement("div");
        activeArea.className = "col-sm-12 activePane";
        activeArea.setAttribute("onclick", "updateQuiz(" + quizIDValues[i] + ")");

        let closeBtn = document.createElement("button");
        closeBtn.className = "btn-private-negative";
        closeBtn.setAttribute("onClick", "deleteQuizHTTPRequest(" + quizIDValues[i] + ")");
        closeBtn.textContent = "X";
        
        let boxTitle = document.createElement("h5");
        boxTitle.id = "boxTitle" + i;
        boxTitle.className = "description-primary";
        boxTitle.textContent = quizNames[i];

        if(i%3 == 0 && i != 0){
            numberOfRowHolder += 1;
        }

        document.getElementById('quizesRow' + numberOfRowHolder).appendChild(newBox);

        newBox.appendChild(closer);
        closer.appendChild(closeBtn);
        newBox.appendChild(activeArea);
        activeArea.appendChild(boxTitle);
    }
}

document.addEventListener("onload", quizPreviewGenerator());

function updateQuiz(quizNumber){
    window.location = "../php/adminPanelEdit.php?quizID=" + quizNumber;
}

function deleteQuizHTTPRequest(quizNumber){
    window.location = "../php/deleteQuiz.php?id=" + quizNumber;
}