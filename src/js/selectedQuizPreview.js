let i = 0;
let goodAnswers = 0;
let wrongAnswers = 0;
let notAnswered = 0;
let wrongAnswersList = [];
let answered = false;

document.addEventListener("load", readDataFromServer());

function readDataFromServer(){
    let container = document.getElementById('quizSpace');
    container.innerHTML = "";

    let quizName = document.getElementById('quizName').value;
    let path = document.getElementById('path');
    path.textContent = quizName;

    let categoryToDisplay = document.getElementById("categoryToDisplay").value;
    let categorySpan = document.getElementById('quizPather');
    categorySpan.textContent = categoryToDisplay;

    let questionsContent = document.getElementById("hiddenQuestion").value;
    let questionsValues = questionsContent.split("|");

    let firstAnswersContent = document.getElementById("hiddenFirstAnswer").value;
    let firstAnswerValue = firstAnswersContent.split("|");

    let secondAnswerContent = document.getElementById("hiddenSecondAnswer").value;
    let secondAnswerValue = secondAnswerContent.split("|");

    let thirdAnswerContent = document.getElementById("hiddenThirdAnswer").value;
    let thirdAnswerValue = thirdAnswerContent.split("|");

    let fourthAnswerContent = document.getElementById("hiddenfourthAnswer").value;
    let fourthAnswerValue = fourthAnswerContent.split("|");

    let categoryID = document.getElementById("category").value;

    let quizPather = document.getElementById('quizPather');
    quizPather.href = "quizy.php?id=" + categoryID;

    answered = false;    

    if(i != questionsValues.length){            
        let br1 = document.createElement("br");
        let br2 = document.createElement("br");
        let br3 = document.createElement("br");
                
        let collumnFull1 = document.createElement("div");
        collumnFull1.className = "col-sm-12 quizSeparator";
                
        let collumnFull2 = document.createElement("div");
        collumnFull2.className = "col-sm-12 quizSeparator";
                
        let collumnFull3 = document.createElement("div");
        collumnFull3.className = "col-sm-12 quizSeparator";
                
        let collumnFull4 = document.createElement("div");
        collumnFull4.className = "col-sm-12 quizSeparator";
                
        let question = document.createElement("h1");
        question.id = "questionSpace";
        question.className = "writtenTittle";
        question.textContent = (i+1) + ". " + questionsValues[i];
            
        let timerLabel = document.createElement("p");
        timerLabel.id = "timer";
        timerLabel.textContent = "Czas na odpowiedź: x sekund";
                            
        let answerBtn1 = document.createElement("button");
        answerBtn1.id = "answer1Space";
        answerBtn1.className = "btn-quiz";
        answerBtn1.textContent = firstAnswerValue[i];
        answerBtn1.setAttribute("onclick", "checkIfAnswerIsGood(1)");
                
        let answerBtn2 = document.createElement("button");
        answerBtn2.id = "answer2Space";
        answerBtn2.className = "btn-quiz";
        answerBtn2.textContent = secondAnswerValue[i];
        answerBtn2.setAttribute("onclick", "checkIfAnswerIsGood(2)");
                
        let answerBtn3 = document.createElement("button");
        answerBtn3.id = "answer3Space";
        answerBtn3.className = "btn-quiz";
        answerBtn3.textContent = thirdAnswerValue[i];
        answerBtn3.setAttribute("onclick", "checkIfAnswerIsGood(3)");
                
        let answerBtn4 = document.createElement("button");
        answerBtn4.id = "answer4Space";
        answerBtn4.className = "btn-quiz";
        answerBtn4.textContent = fourthAnswerValue[i];
        answerBtn4.setAttribute("onclick", "checkIfAnswerIsGood(4)");
                            
        container.appendChild(br1);
        container.appendChild(question);
        container.appendChild(br2);
        container.appendChild(timerLabel);
        container.appendChild(br3);
                
        container.appendChild(collumnFull1);
        collumnFull1.appendChild(answerBtn1);
                
        container.appendChild(collumnFull2);
        collumnFull2.appendChild(answerBtn2);
                
        container.appendChild(collumnFull3);
        collumnFull3.appendChild(answerBtn3);
                
        container.appendChild(collumnFull4);
        collumnFull4.appendChild(answerBtn4);
            
        quizTimer(false);
    }
    else{
        container.innerHTML = "";
            
        let titleBr = document.createElement("br");
            
        let greetingBox = document.createElement("div");
        greetingBox.className = "explanaitionBox";
            
        let finishHeader = document.createElement("h3");
        finishHeader.textContent = "Quiz skończony!\nOto twój wynik:";
        finishHeader.className = "writtenTittle";
                            
        let scoreGood = document.createElement("p");
        scoreGood.textContent = "Poprawne odpowiedzi: " + goodAnswers;
            
        let scoreBad = document.createElement("p");
        scoreBad.textContent = "Błędne odpowiedzi: " + wrongAnswers;
            
        let scoreNotAnswered = document.createElement("p");
        scoreNotAnswered.textContent = "Ilość pytań bez odpowiedzi: " + notAnswered;
            
        let greetings = document.createElement("p");
        greetings.textContent = "Pytania, na które podaną złą odpowiedź, lub nie podano jej wcale: ["
        for(let k=0; k<wrongAnswersList.length; k++){
            if(k == wrongAnswersList.length-1)
                greetings.textContent += wrongAnswersList[k] + "]";
            else
                greetings.textContent += wrongAnswersList[k] + ", ";
        }
            
        let backBtnBox = document.createElement("div");
        backBtnBox.className = "nextBoxInside";
            
        let backBtn = document.createElement("button");
        backBtn.setAttribute("onclick", "goTo(" + categoryID + ")");
        backBtn.className = "btn-next";
        backBtn.textContent = "Wróć do pozostałych quizów";
                            
        container.appendChild(greetingBox);
            
        greetingBox.appendChild(finishHeader);
        greetingBox.appendChild(titleBr);
            
        greetingBox.appendChild(scoreGood);
        greetingBox.appendChild(scoreBad);
        greetingBox.appendChild(scoreNotAnswered);
            
        greetingBox.appendChild(greetings);
        greetingBox.appendChild(backBtnBox);
        backBtnBox.appendChild(backBtn);
    }
}

function quizTimer(){
    let time = 15;
    const timeInterval = setInterval(function() {
        if(time > 0 && answered == false){
            document.getElementById("timer").textContent = "Czas na odpowiedź: " + time + " sekund";
            time -= 1;
        }
        else{
            clearInterval(timeInterval);
            
            if(time == 0)
            {
                document.getElementById("timer").textContent = "Czas na odpowiedź upłynął. Przejdź do następnego pytania.";

                let nextBox = document.createElement("div");
                nextBox.className = "nextBox";
    
                let nextQuestionButton = document.createElement("button");
                nextQuestionButton.className = "btn-next";
                nextQuestionButton.textContent = "Następne pytanie";
                nextQuestionButton.setAttribute("onclick", "nextQuestion()");
    
                document.getElementById("quizSpace").appendChild(nextBox);
                nextBox.appendChild(nextQuestionButton);
            }
            else
                document.getElementById("timer").textContent = "Odpowiedź podana na " + (time+1) + " sekund przed końcem czasu!";

            document.getElementById("answer1Space").setAttribute("disabled", "true");
            document.getElementById("answer2Space").setAttribute("disabled", "true");
            document.getElementById("answer3Space").setAttribute("disabled", "true");
            document.getElementById("answer4Space").setAttribute("disabled", "true");
            
            if(answered == false){
                wrongAnswersList.push(i+1);
                notAnswered += 1;
            }
        }
    }, 1000);
}

function checkIfAnswerIsGood(providedAnswer){
    let explanationBox = document.createElement("div");
    explanationBox.className = "col-sm-12 explanaitionBox";

    document.getElementById("quizSpace").appendChild(explanationBox);

    let correctAnswerContent = document.getElementById("hiddenCorrect").value;
    let correctAnswerValue = correctAnswerContent.split("|");

    let explanationContent = document.getElementById("hiddenExplanation").value;
    let explanationValue = explanationContent.split("|");
        
    if(providedAnswer == correctAnswerValue[i]){
        let goodHeader = document.createElement("h3");
        goodHeader.className = "writtenTittle";
        goodHeader.style.color = "#1f6373";
        goodHeader.textContent = "Zgadza się!";
            
        let explanaitionSpace = document.createElement("p");
        explanaitionSpace.textContent = explanationValue[i];
            
        explanationBox.appendChild(goodHeader);
        explanationBox.appendChild(explanaitionSpace)

        document.getElementById('answer' + providedAnswer + 'Space').style.backgroundColor = "#1f6373";
        document.getElementById('answer' + providedAnswer + 'Space').style.color = "#f6f6f6";

        goodAnswers += 1;
        answered = true;
    }
    else{
        let badHeader = document.createElement("h3");
        badHeader.className = "writtenTittle";
        badHeader.style.color = "#511816";
        badHeader.textContent = "Niestety nie...";
            
        let explanaitionSpace = document.createElement("p");
        explanaitionSpace.textContent = explanationValue[i];
            
        explanationBox.appendChild(badHeader);
        explanationBox.appendChild(explanaitionSpace)

        document.getElementById('answer' + providedAnswer + 'Space').style.backgroundColor = "#511816"
        document.getElementById('answer' + providedAnswer + 'Space').style.color = "#f6f6f6";

        wrongAnswers += 1;
        wrongAnswersList.push(i+1);

        answered = true;
    }

    document.getElementById("answer1Space").setAttribute("disabled", "true");
    document.getElementById("answer2Space").setAttribute("disabled", "true");
    document.getElementById("answer3Space").setAttribute("disabled", "true");
    document.getElementById("answer4Space").setAttribute("disabled", "true");

    let nextBox = document.createElement("div");
    nextBox.className = "nextBox";

    let nextQuestionButton = document.createElement("button");
    nextQuestionButton.className = "btn-next";
    nextQuestionButton.textContent = "Następne pytanie";
    nextQuestionButton.setAttribute("onclick", "nextQuestion()");

    let pageUp = document.createElement("a");
    pageUp.href = "#navigation";

    document.getElementById("quizSpace").appendChild(nextBox);
    nextBox.appendChild(pageUp);
    pageUp.appendChild(nextQuestionButton);
}

function nextQuestion(){
    i += 1;
    readDataFromServer();
}

function goTo(categoryNumber){
    window.location = "../php/quizy.php?id=" + categoryNumber;
}