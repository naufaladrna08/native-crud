const questionNumber = document.querySelector(".question-number");
const questionText = document.querySelector(".question-text");
const optionContainer = document.querySelector(".option-container");
const answersIndicatorContainer = document.querySelector(".answers-indicator");
let questionCounter = 0;
let currentQuestion;
let availableQuestions = [];
let availableOptions = [];
// push the question into availableQuestions Array
function setAvailableQuestions() {
    const totalQuestion = quiz.length;
    for (let i = 0; i < totalQuestion; i++) {
        availableQuestions.push(quiz[i]);
    }
}
// set question number and question and options
function getNewQuestion() {
    // set question number
    questionNumber.innerHTML = " Question " + (questionCounter + 1) + " of " + quiz.length;

    // set question text
    // get random question
    const questionIndex = availableQuestions[Math.floor(Math.random() * availableQuestions.length)];
    currentQuestion = questionIndex;
    questionText.innerHTML = currentQuestion.q;
    // get the position of 'questionIndex' from the availableQuestion Array
    const index1 = availableQuestions.indexOf(questionIndex);
    // remove the 'questionIndex' from the availableQuestion Array, so that the question does not reapet
    availableQuestions.splice(index1, 1);

    // set options
    // get the lenght of options
    const optionLen = currentQuestion.options.length;
    // push options into availableOption Array
    for (let i = 0; i < optionLen; i++) {
        availableOptions.push(i);
    }
    optionContainer.innerHTML = '';
    let animationDelay = 0.15;
    // create option in html
    for (let i = 0; i < optionLen; i++) {
        // random option
        const optionIndex = availableOptions[Math.floor(Math.random() * availableOptions.length)];
        // get the position of 'optonIndex' from the availableOptions
        const index2 = availableOptions.indexOf(optionIndex);
        // remove the 'optonIndex' from the availableOptions, so that the option does not reapet
        availableOptions.splice(index2, 1);
        const option = document.createElement("div");
        option.innerHTML = currentQuestion.options[optionIndex];
        option.id = optionIndex;
        option.style.animationDelay = animationDelay + 's';
        animationDelay = animationDelay + 0.15;
        option.className = "option";
        optionContainer.appendChild(option);
        option.setAttribute("onclick", "getResult(this)");
    }

    questionCounter++;
}
// get the result of current attempt question
function getResult(element) {
    const id = parseInt(element.id);
    // get answer by comparing the id of clicked option
    if (id === currentQuestion.answer) {
        // set the green color to the corect option
        element.classList.add("correct");
        // add the indicator to the correct mark
        updateAnswerIndicator("correct");
    }
    else {
        // set the red color to the incorect option
        element.classList.add("wrong");
        // add the indicator to the wrong mark
        updateAnswerIndicator("wrong");

        // if the answer is incorrect the show the correct option by adding green color the correct option
        const optionLen = optionContainer.children.lenght;
        for (let i = 0; i < optionLen; i++) {
            if (parseInt(optionContainer.children[i].id) === currentQuestion.answer) {
                optionContainer.children[i].classList.add("correct");
            }
        }
    }

    unclickableOptions();
}
// make all the options unclikable one the user select a option (RESTRICT TH USER TO CHANGE THE OPTION AGAIN)
function unclickableOptions() {
    const optionLen = optionContainer.children.length;
    for (let i = 0; i < optionLen; i++) {
        optionContainer.children[i].classList.add("already-answered");
    }
}
function answersIndicator() {
    const totalQuestion = quiz.length;
    for (let i = 0; i < totalQuestion; i++) {
        const indicator = document.createElement("div");
        answersIndicatorContainer.appendChild(indicator);
    }
}
function updateAnswerIndicator(markType) {
    answersIndicatorContainer.children[questionCounter - 1].classList.add(markType);
}
function next() {
    if (questionCounter === quiz.length) {
        console.log("quiz over");
    }
    else {
        getNewQuestion();
    }
}
window.onload = function () {
    // firts set all questions in availableQuestions Array
    setAvailableQuestions();
    // second call getNewQuestion(); function
    getNewQuestion();
    // to create indicator of answers
    answersIndicator();
};
