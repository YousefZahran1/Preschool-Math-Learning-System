document.addEventListener('DOMContentLoaded', function() {
    console.log("JavaScript loaded!");
});

let currentQuestion = 0;
let correctAnswers = 0;
let questions = [];
let gameType = '';

function startGame(type) {
    gameType = type;
    currentQuestion = 0;
    correctAnswers = 0;
    questions = generateQuestions(type, 10);
    showQuestion();
}

function generateQuestions(type, numQuestions) {
    const questions = [];
    for (let i = 0; i < numQuestions; i++) {
        let num1 = Math.floor(Math.random() * 10) + 1;
        let num2 = Math.floor(Math.random() * 10) + 1;
        let question, answer;
        switch (type) {
            case 'addition':
                question = `What is ${num1} + ${num2}?`;
                answer = num1 + num2;
                break;
            case 'subtraction':
                question = `What is ${num1} - ${num2}?`;
                answer = num1 - num2;
                break;
            case 'multiplication':
                question = `What is ${num1} * ${num2}?`;
                answer = num1 * num2;
                break;
            case 'division':
                num1 = num1 * num2; // Ensure it's divisible
                question = `What is ${num1} / ${num2}?`;
                answer = num1 / num2;
                break;
        }
        questions.push({ question, answer });
    }
    return questions;
}

function showQuestion() {
    if (currentQuestion < questions.length) {
        const question = questions[currentQuestion].question;
        document.getElementById('game-selection').style.display = 'none';
        document.getElementById('questions').innerHTML = `
            <div class="question-container">
                <p>${question}</p>
                <input type="number" id="answer" />
                <button onclick="checkAnswer()">Submit</button>
                <button class="go-back" onclick="goBack()">Go Back</button>
            </div>
        `;
    } else {
        document.getElementById('questions').innerHTML = `
            <div class="question-container">
                <p>You've completed the game! You got ${correctAnswers} out of ${questions.length} correct.</p>
            </div>
        `;
        document.getElementById('home-button').style.display = 'block';
        saveProgress(gameType, correctAnswers, questions.length);
    }
}

function checkAnswer() {
    const userAnswer = parseInt(document.getElementById('answer').value);
    const correctAnswer = questions[currentQuestion].answer;
    if (userAnswer === correctAnswer) {
        correctAnswers++;
    }
    currentQuestion++;
    showQuestion();
}

function goBack() {
    window.history.back();
}

function saveProgress(activity, score, total) {
    fetch('saveProgress.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ activity, score, total, type: 'game', completed: score === total })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log('Progress saved successfully');
        } else {
            console.error('Failed to save progress:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function completeLesson(activity) {
    fetch('saveProgress.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ activity, score: 1, total: 1, type: 'lesson', completed: true })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Lesson completed!');
        } else {
            console.error('Failed to complete lesson:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
