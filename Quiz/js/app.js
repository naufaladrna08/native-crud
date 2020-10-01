

const questionNumber = document.querySelector(".question-number");
const questionText = document.querySelector(".question-text");
const optionContainer = document.querySelector(".option-container");
const answersIndicatorContainer = document.querySelector(".answers-indicator");
const homeBox = document.querySelector(".home-box");
const quizBox = document.querySelector(".quiz-box");
const resultBox = document.querySelector(".result-box");

let questionCounter = 0;
let currentQuestion;
let availableQuestions = [];
let availableOptions = [];
let correctAnswers = 0;
let attempt = 0;
let quiz = []

// push the question into availableQuestions Array
function setAvailableQuestions(){
    const totalQuestion = quiz.length;
    for(let i=0; i<totalQuestion; i++){
        availableQuestions.push(quiz[i])
        console.log("A")
    }
}

// set question number and question and options
function getNewQuestion(){
    // set question number
    questionNumber.innerHTML = " Question " + (questionCounter + 1) + " of " + quiz.length;

    // set question text
    // get random question
    const questionIndex = availableQuestions[Math.floor(Math.random() * availableQuestions.length)]
    currentQuestion = questionIndex;
    questionText.innerHTML = currentQuestion.question;
    // get the position of 'questionIndex' from the availableQuestion Array
    const index1 = availableQuestions.indexOf(questionIndex);
    // remove the 'questionIndex' from the availableQuestion Array, so that the question does not reapet
    availableQuestions.splice(index1,1);

    // set options
    // get the length of options
    const optionLen = currentQuestion.options.length
    // push options into availableOption Array
    for(let i=0; i<optionLen; i++){
        availableOptions.push(i)
    }
    optionContainer.innerHTML = '';
    let animationDelay = 0.15;
    // create option in html
    for(let i=0; i<optionLen; i++){
        // random option
        const optionIndex = availableOptions[Math.floor(Math.random() * availableOptions.length)];
        // get the position of 'optonIndex' from the availableOptions
        const index2 = availableOptions.indexOf(optionIndex);
        // remove the 'optonIndex' from the availableOptions, so that the option does not reapet
        availableOptions.splice(index2,1);
        const option = document.createElement("div");
        option.innerHTML = currentQuestion.options[optionIndex];
        option.id = optionIndex;
        option.style.animationDelay = animationDelay + 's';
        animationDelay = animationDelay + 0.15;
        option.className = "option";
        optionContainer.appendChild(option)
        option.setAttribute("onclick","getResult(this)");
    }

    questionCounter++
}

// get the result of current attempt question
function getResult(element){
    const id = parseInt(element.id);
    // get answer by comparing the id of clicked option
    if(id === currentQuestion.answer){
        // set the green color to the corect option
        element.classList.add("correct");
        // add the indicator to the correct mark
        updateAnswerIndicator("correct");
        correctAnswers++;
    }
    else{
        // set the red color to the incorect option
        element.classList.add("wrong");
        // add the indicator to the wrong mark
        updateAnswerIndicator("wrong");
        
        // if the answer is incorrect the show the correct option by adding green color the correct option
        const optionLen = optionContainer.children.length;
        for(let i=0; i<optionLen; i++){
            if(parseInt(optionContainer.children[i].id) === currentQuestion.answer){
                optionContainer.children[i].classList.add("correct");
            }
        }
    }
    attempt++;
    unclickableOptions();
}

// make all the options unclikable one the user select a option (RESTRICT TH USER TO CHANGE THE OPTION AGAIN)
function unclickableOptions(){
    const optionLen = optionContainer.children.length;
    for(let i=0; i<optionLen; i++){
        optionContainer.children[i].classList.add("already-answered");
    }
}

function answersIndicator(){
    answersIndicatorContainer.innerHTML = '';
    const totalQuestion = quiz.length;
        for(let i=0; i<totalQuestion; i++){
        const indicator = document.createElement("div");
        answersIndicatorContainer.appendChild(indicator);
    }
}
function updateAnswerIndicator(markType){
    answersIndicatorContainer.children[questionCounter-1].classList.add(markType)
}

function next() {
    if(questionCounter === quiz.length){
        quizOver();
    }
    else{
        getNewQuestion();
    }
}

function quizOver(){
    // hide quiz quizBox
    quizBox.classList.add("hide");
    // show result Box
    resultBox.classList.remove("hide");
    quizResult();

}

// get the quiz Result
function quizResult(){
    resultBox.querySelector(".total-question").innerHTML = quiz.length;
    resultBox.querySelector(".total-attempt").innerHTML = attempt;
    resultBox.querySelector(".total-correct").innerHTML = correctAnswers;
    resultBox.querySelector(".total-wrong").innerHTML = attempt - correctAnswers;
    const percentage = (correctAnswers/quiz.length)*100;
    resultBox.querySelector(".percentage").innerHTML = percentage.toFixed(2) + "%";
    resultBox.querySelector(".total-score").innerHTML = correctAnswers +" / " + quiz.length;
}

function resetQuiz(){
    questionCounter = 0;
    correctAnswers = 0;
    attempt = 0;
}

function tryAgainQuiz(){
    //hide the ResultBox
    resultBox.classList.add("hide");
    //show the quizBox
    quizBox.classList.remove("hide");
    resetQuiz();
    startQuiz();
}

function goToHome(){
    let attempt = resultBox.querySelector(".total-attempt").innerHTML
    let correct = resultBox.querySelector(".total-correct").innerHTML
    let incorrect = attempt - correct
    const percentage = (correctAnswers/quiz.length)*100;
    let percent = percentage.toFixed(2) + "%";
    

    let AJAX = new XMLHttpRequest()
    AJAX.open("POST", "http://localhost/web/FinishAttempt.php")
    AJAX.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    AJAX.onreadystatechange = () => {
        if (AJAX.readyState == 4 && AJAX.status == 200) {
            if (AJAX.responseText == "success") {
            
            } else {
                console.log(AJAX.responseText)
            }
        }
    }
    
    AJAX.send("attempt=" + attempt + "&correct=" + correct + "&incorrect=" + incorrect + "&percent=" + percent)

    // hide resultBox
    resultBox.classList.add("hide");
    // show homeBox
    homeBox.classList.remove("hide");
    resetQuiz();
}

function startQuiz(code){
    let AJAX = new XMLHttpRequest()
    AJAX.open("POST", "http://localhost/web/GetQuestions.php")
    AJAX.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
    AJAX.onreadystatechange = () => {
        if (AJAX.readyState == 4 && AJAX.status == 200) {
            if (AJAX.responseText == "success") {
                quiz = JSON.parse(AJAX.responseText)
                console.log(quiz)
            } else {
                console.log(AJAX.responseText)
            }
        }
    }
    AJAX.send("c=" + code)

    console.log("A")
    // firts set all questions in availableQuestions Array
    setAvailableQuestions();
    // second call getNewQuestion(); function
    getNewQuestion();
    // to create indicator of answers
    answersIndicator();
}
