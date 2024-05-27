let exerciesBoxIndex = 0;
let exerciseQuantity = 0;
let removedIndexes = [];
let removedString = "";
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

function alternativeAppending(){
    const holder = document.getElementById("exerciseHolder");

    let br0 = document.createElement("br");
    let br1 = document.createElement("br");
    let br2 = document.createElement("br");
    let br3 = document.createElement("br");
    let br4 = document.createElement("br");
    let br5 = document.createElement("br");
    let br6 = document.createElement("br");

    let rowMain = document.createElement("div");
    rowMain.className = "row";
    rowMain.id = "EB" + exerciesBoxIndex;
    let rowBtn = document.createElement("div");
    rowBtn.className = "row";
    let rowContent = document.createElement("div");
    rowContent.className = "row";

    let exerciseBoxHolder = document.createElement("div");
    exerciseBoxHolder.className = "col-sm-12 exerciseBox";

    let exerciseFormHolder = document.createElement("div");
    exerciseFormHolder.className = "col-sm-12";

    let closer = document.createElement("div");
    closer.className = "col-sm-12 closer";

    let closeBtn = document.createElement("button");
    closeBtn.className = "btn-private-negative";
    closeBtn.setAttribute("onClick", "deleteExerciseBox(" + exerciesBoxIndex + ")")
    closeBtn.textContent = "X";

    let exerciseHead = document.createElement("h5");
    exerciseHead.textContent = "Pytanie " + (exerciesBoxIndex+1);
    exerciseHead.className = "questionFont";
    
    let questionInput = document.createElement("input");
    questionInput.type = "text";
    questionInput.className = "quizInput";
    questionInput.id = "questionInput" + exerciesBoxIndex;
    questionInput.name = "questionHeader" + exerciesBoxIndex;
    questionInput.placeholder = "Pytanie, które będzie się pojawiać";

    let answer1Input = document.createElement("input");
    answer1Input.type = "text";
    answer1Input.className = "quizInput";
    answer1Input.id = "Answer1EB" + exerciesBoxIndex;
    answer1Input.name = "Answer1name" + exerciesBoxIndex;
    answer1Input.placeholder = "Odpowiedź A";

    let answer2Input = document.createElement("input");
    answer2Input.type = "text";
    answer2Input.className = "quizInput";
    answer2Input.id = "Answer2EB" + exerciesBoxIndex;
    answer2Input.name = "Answer2name" + exerciesBoxIndex;
    answer2Input.placeholder = "Odpowiedź B";

    let answer3Input = document.createElement("input");
    answer3Input.type = "text";
    answer3Input.className = "quizInput";
    answer3Input.id = "Answer3EB" + exerciesBoxIndex;
    answer3Input.name = "Answer3name" + exerciesBoxIndex;
    answer3Input.placeholder = "Odpowiedź C";

    let answer4Input = document.createElement("input");
    answer4Input.type = "text";
    answer4Input.className = "quizInput";
    answer4Input.id = "Answer4EB" + exerciesBoxIndex;
    answer4Input.name = "Answer4name" + exerciesBoxIndex;
    answer4Input.placeholder = "Odpowiedź D";

    let explanaitionInput = document.createElement("input");
    explanaitionInput.className = "quizInput";
    explanaitionInput.type = "text";
    explanaitionInput.id = "explanationEB" + exerciesBoxIndex;
    explanaitionInput.name = "explanationName" + exerciesBoxIndex;
    explanaitionInput.placeholder = "Podaj wyjaśnienie zagadnienia, które będzie pokazywało się na stronie";

    let correctLabel = document.createElement("label")
    correctLabel.textContent = "Porawna odpowiedź:";

    let selectForm = document.createElement("select");
    selectForm.id = "trueAnswerEB" + exerciesBoxIndex;
    selectForm.name = "trueAnswerName" + exerciesBoxIndex;

    for (var i = 1; i < 5; i++) {
        var option = document.createElement("option");
        option.value = i;
        option.text = i;
        selectForm.appendChild(option);
    }

    holder.appendChild(rowMain);
    
    rowMain.appendChild(exerciseBoxHolder);

    exerciseBoxHolder.appendChild(rowBtn);
    rowBtn.appendChild(closer);
    closer.appendChild(closeBtn);

    exerciseBoxHolder.appendChild(rowContent);
    rowContent.appendChild(exerciseFormHolder);

    exerciseFormHolder.appendChild(exerciseHead);
    exerciseFormHolder.appendChild(br0);

    exerciseFormHolder.appendChild(questionInput);
    exerciseFormHolder.appendChild(br1);

    exerciseFormHolder.appendChild(answer1Input);
    exerciseFormHolder.appendChild(br2);

    exerciseFormHolder.appendChild(answer2Input);
    exerciseFormHolder.appendChild(br3);

    exerciseFormHolder.appendChild(answer3Input);
    exerciseFormHolder.appendChild(br4);

    exerciseFormHolder.appendChild(answer4Input);
    exerciseFormHolder.appendChild(br5);

    exerciseFormHolder.appendChild(explanaitionInput);
    exerciseFormHolder.appendChild(br6);

    exerciseFormHolder.appendChild(correctLabel);
    exerciseFormHolder.appendChild(selectForm);

    exerciesBoxIndex += 1;
    exerciseQuantity += 1;
    document.getElementById("hiddenValue").value = exerciesBoxIndex;
}

function deleteExerciseBox(providedIndex){
    document.getElementById('EB' + providedIndex).remove();
    removedIndexes.push(providedIndex);

    exerciseQuantity -= 1;
    document.getElementById("hiddenValue").value = exerciesBoxIndex;

    removedString += providedIndex + "|";
    document.getElementById('hiddenRemoved').value = removedIndexes;

    console.log("indexes to skip: " + document.getElementById('hiddenRemoved').value);
}

function formGenerator(titleOnPage, submitLink){
    let formHolder = document.getElementById("infos");
    formHolder.innerHTML = "";
    
    let br1 = document.createElement("br");
    let br7 = document.createElement("br");

    let pageTitle = document.createElement("h1");
    pageTitle.textContent = titleOnPage;
    pageTitle.className = "writtenTitle";

    let newForm = document.createElement("form");
    newForm.id = "exerciseFormHolder";
    newForm.method = "POST";
    newForm.action = "../php/" + submitLink;

    let initQuizSpace = document.createElement("div");
    initQuizSpace.className = "col-sm-12 initSpace";

    let hiddenValue = document.createElement("input");
    hiddenValue.type = "hidden";
    hiddenValue.id = "hiddenValue";
    hiddenValue.name = "hiddenValue";
    hiddenValue.value = exerciseQuantity;

    let removedIndexesNumber = document.createElement('input');
    removedIndexesNumber.type = "hidden";
    removedIndexesNumber.id = "hiddenRemoved";
    removedIndexesNumber.name = "hiddenRemoved";
    removedIndexesNumber.value = "-1";
    
    let quizNameLable = document.createElement("label");
    quizNameLable.textContent = "Tytuł quizu:";
    
    let quizNameInput = document.createElement("input");
    quizNameInput.type = "text";
    quizNameInput.placeholder = "np. Nieoczywiste idiomy w angielskim";
    quizNameInput.className = "quizInput";
    quizNameInput.id = "quizTitle";
    quizNameInput.name = "quizTitle";

    let categoryLabel = document.createElement("label");
    categoryLabel.textContent = "Kategoria quizu:";
    
    let categorySelect = document.createElement("select");
    categorySelect.id = "quizCategory";
    categorySelect.name = "quizCategory";

    let collectedCategory = document.getElementById('hiddenCategories').value;
    let collectedCategorySplitted = collectedCategory.split("|");

    for (var i = 0; i < collectedCategorySplitted.length; i++) {
        var optionForCategory = document.createElement("option");
        optionForCategory.value = collectedCategorySplitted[i];
        optionForCategory.text = collectedCategorySplitted[i];
        categorySelect.appendChild(optionForCategory);
    }
    
    let informationText = document.createElement("p");
    informationText.textContent = 'Kliknij "+", aby dodać pytanie i odpowiedzi';
    
    let additionalOperationsHolder = document.createElement("div");
    additionalOperationsHolder.className = "col-sm-12 addSpace";

    let addButtonHolder = document.createElement("div");
    addButtonHolder.className = "additionalOperations";
    addButtonHolder.id = "additionalOperations";
    
    let addButton = document.createElement("input");
    addButton.type = "button";
    addButton.className = "btn-private";
    addButton.setAttribute("onclick", "alternativeAppending()");
    addButton.value = "+";
    
    let exerciseRow = document.createElement("div");
    exerciseRow.className = "row exerciseSpace";

    let singleCol1 = document.createElement("div");
    singleCol1.className = "col-sm-1";

    let singleCol2 = document.createElement("div");
    singleCol2.className = "col-sm-1";

    let exerciseSpace = document.createElement("div")
    exerciseSpace.className = "col-sm-10";
    exerciseSpace.id = "exerciseHolder";

    let finalizationSpace = document.createElement("div");
    finalizationSpace.className = "col-sm-12 finalSpace";

    let sendDataOnServerButtonn = document.createElement("input");
    sendDataOnServerButtonn.type = "submit";
    sendDataOnServerButtonn.className = "btn-private";
    sendDataOnServerButtonn.name = "dataTransfer";
    sendDataOnServerButtonn.value = "Wyślij dane na serwer";

    formHolder.appendChild(pageTitle);
    formHolder.appendChild(newForm);

    newForm.appendChild(initQuizSpace);
    initQuizSpace.appendChild(hiddenValue);
    initQuizSpace.appendChild(removedIndexesNumber);
    initQuizSpace.appendChild(quizNameLable);
    initQuizSpace.appendChild(quizNameInput);
    initQuizSpace.appendChild(br1);
    initQuizSpace.appendChild(categoryLabel);
    initQuizSpace.appendChild(categorySelect);
    initQuizSpace.appendChild(br7);
    initQuizSpace.appendChild(informationText);

    newForm.appendChild(exerciseRow);
    exerciseRow.appendChild(singleCol1);
    exerciseRow.appendChild(exerciseSpace);
    exerciseRow.appendChild(singleCol2);
    
    newForm.appendChild(additionalOperationsHolder);
    additionalOperationsHolder.appendChild(addButtonHolder);
    addButtonHolder.appendChild(addButton);

    newForm.appendChild(finalizationSpace);
    finalizationSpace.appendChild(sendDataOnServerButtonn);
}

function editQuiz(){
    let quantityOfQuestions = document.getElementById('questionsQuantity').value;
    let quizName = document.getElementById('quizName').value;
    let quizCategory = document.getElementById('quizCategoryReached').value;
    let quizIDToEdit = document.getElementById('quizID').value;

    formGenerator("Edytuj wybrany przez siebie quiz", "editQuizHandler.php?quantity=" + quantityOfQuestions + "&quizID=" + quizIDToEdit);

    document.getElementById('quizTitle').value = quizName;
    document.getElementById('quizCategory').value = quizCategory;

    for(let i = 0; i < quantityOfQuestions; i += 1){
        alternativeAppending();
    }

    let collectedQuestions = document.getElementById('hiddenQuestion').value;
    let collectedQuestionsSplitted = collectedQuestions.split("|");

    let collectedFirstAnswers = document.getElementById('hiddenFirstAnswer').value;
    let collectedFirstAnswersSplitted = collectedFirstAnswers.split("|");

    let collectedSecondAnswers = document.getElementById('hiddenSecondAnswer').value;
    let collectedSecondAnswersSplitted = collectedSecondAnswers.split("|");

    let collectedThirdAnswers = document.getElementById('hiddenThirdAnswer').value;
    let collectedThirdAnswersSplitted = collectedThirdAnswers.split("|");

    let collectedFourthAnswers = document.getElementById('hiddenfourthAnswer').value;
    let collectedFourthAnswersSplitted = collectedFourthAnswers.split("|");

    let collectedCorrectAnswers = document.getElementById('hiddenCorrect').value;
    let collectedCorrectAnswersSplitted = collectedCorrectAnswers.split("|");

    let collectedExplanations = document.getElementById('hiddenExplanation').value;
    let collectedExplanationsSplitted = collectedExplanations.split("|");

    for(let i=0; i<quantityOfQuestions; i+=1){
        document.getElementById('questionInput' + i).value = collectedQuestionsSplitted[i];
        document.getElementById('Answer1EB' + i).value = collectedFirstAnswersSplitted[i];
        document.getElementById('Answer2EB' + i).value = collectedSecondAnswersSplitted[i];
        document.getElementById('Answer3EB' + i).value = collectedThirdAnswersSplitted[i];
        document.getElementById('Answer4EB' + i).value = collectedFourthAnswersSplitted[i];
        document.getElementById('explanationEB' + i).value = collectedExplanationsSplitted[i];
        document.getElementById('trueAnswerEB' + i).value = collectedCorrectAnswersSplitted[i];
    }
}