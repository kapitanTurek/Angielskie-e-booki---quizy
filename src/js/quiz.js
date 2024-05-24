let i = 0;
let goodAnswers = 0;
let wrongAnswers = 0;
let notAnswered = 0;
let wrongAnswersList = [];
let answered = false;

document.addEventListener("load", quizPreviewGenerator());

function quizPreviewGenerator(){
    let contentHolder = document.getElementById("quizSpace");

    let categoryID = document.getElementById("category").value;
    
    let br1 = document.createElement("br");
    
    let numberOfQuizes = document.getElementById("hiddenValue").value;
    let quizData = document.getElementById("quizData").value;
    let quizNames = quizData.split("|");

    let categoryToDisplay = document.getElementById("categoryToDisplay").value;
    let categorySpan = document.getElementById('quizCategory');
    categorySpan.textContent += categoryToDisplay;
    
    if(numberOfQuizes != 0){
        let pageTitle = document.createElement("h1");
        pageTitle.textContent = "Lista obecnie dostępnych quizów";
        pageTitle.className = "writtenTitleQuiz";

        contentHolder.appendChild(pageTitle);
        contentHolder.appendChild(br1);

        let quizIDData = document.getElementById("quizIDData").value;
        let quizIDValues = quizIDData.split("|");

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
            activeArea.setAttribute("onclick", "openQuiz(" + quizIDValues[i] + ", " + categoryID + ")");
            
            let boxTitle = document.createElement("h5");
            boxTitle.id = "boxTitle" + i;
            boxTitle.className = "description-primary";
            boxTitle.textContent = quizNames[i];

            if(i%3 == 0 && i != 0){
                numberOfRowHolder += 1;
            }

            document.getElementById('quizesRow' + numberOfRowHolder).appendChild(newBox);
            newBox.appendChild(activeArea);
            activeArea.appendChild(boxTitle);
        }
    }
    else{
        let pageTitle = document.createElement("h1");
        pageTitle.textContent = "Wygląda na to, że żaden quiz w tej kategorii jeszcze nie powstał... Wierzymy, że autor ciężko pracuje, żeby to zmienić!";
        pageTitle.className = "writtenTitleQuiz";

        //zmienić grafike - użycie dozwolone tylko w sposób niekomercyjny... chujnia
        // let workmanImage = document.createElement("img");
        // workmanImage.src = "../../icons/workman_alpha.gif";
        // workmanImage.alt = "work in progress...";

        contentHolder.appendChild(pageTitle);
        // contentHolder.appendChild(workmanImage);
    }
}

function openQuiz(id, category){
    window.location = "../php/selectedQuiz.php?id=" + id + "&category=" + category;
}