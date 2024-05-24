let i = 0;
let goodAnswers = 0;
let wrongAnswers = 0;
let notAnswered = 0;
let wrongAnswersList = [];
let answered = false;

document.addEventListener("load", quizPreviewGenerator());

function quizPreviewGenerator(){
    let contentHolder = document.getElementById("quizSpace");
    
    let br1 = document.createElement("br");

    let pageTitle = document.createElement("h1");
    pageTitle.textContent = "Lista kategorii quizów - po kliknięciu zostanie otworzona lista quizów danej kategorii";
    pageTitle.className = "writtenTitleQuiz";

    contentHolder.appendChild(pageTitle);
    contentHolder.appendChild(br1);

    let numberOfQuizes = document.getElementById("hiddenValue").value;
    let categoriesData = document.getElementById("categoryData").value;
    let categoryNames = categoriesData.split("|");

    let categoriesIDData = document.getElementById("categoryIDData").value;
    let categoryIDValues = categoriesIDData.split("|");

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

        let activeArea = document.createElement("div");
        activeArea.className = "col-sm-12 activePane";
        activeArea.setAttribute("onclick", "openQuiz(" + categoryIDValues[i] + ")");
        
        let boxTitle = document.createElement("h5");
        boxTitle.id = "boxTitle" + i;
        boxTitle.className = "description-primary";
        boxTitle.textContent = categoryNames[i];

        if(i%3 == 0 && i != 0){
            numberOfRowHolder += 1;
        }

        document.getElementById('quizesRow' + numberOfRowHolder).appendChild(newBox);
        newBox.appendChild(activeArea);
        activeArea.appendChild(boxTitle);
    }
}

function openQuiz(id){
    window.location = "../php/quizy.php?id=" + id;
}