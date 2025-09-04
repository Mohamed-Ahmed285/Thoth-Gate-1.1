if (document.getElementById('add-question-btn')) {
    let questionCount = 0;
    const questionsList = document.getElementById('questions-list');
    const addQuestionBtn = document.getElementById('add-question-btn');

    addQuestionBtn.addEventListener('click', function() {
        questionCount++;
        const qDiv = document.createElement('div');
        qDiv.className = 'exam-question-box';
        qDiv.innerHTML = `
            <div class="question-header">
                <button type="button" class="remove-question-btn" title="Remove this question">&times;</button>
            </div>
            <div class="form-group">
                <input type="text" name="questions[${questionCount}][text]" required placeholder="Enter question text">
            </div>
            <div class="choices-list"></div>
            <button type="button" class="add-choice-btn"><i class='fas fa-plus'></i> Add Choice</button>
        `;
        questionsList.appendChild(qDiv);

        const choicesListDiv = qDiv.querySelector('.choices-list');
        addChoice(choicesListDiv, questionCount);
        addChoice(choicesListDiv, questionCount);

        qDiv.querySelector('.add-choice-btn').addEventListener('click', function() {
            addChoice(choicesListDiv, questionCount);
        });

        qDiv.querySelector('.remove-question-btn').addEventListener('click', function() {
            qDiv.remove();
        });
    });

    function addChoice(choicesList, qNum) {
        const choiceCount = choicesList.querySelectorAll('.form-group-choice').length;

        const cDiv = document.createElement('div');
        cDiv.className = 'form-group-choice';
        cDiv.innerHTML = `
            <input type="radio" name="questions[${qNum}][correct_choice]" value="${choiceCount}" class="correct-choice-radio" title="Mark as correct" required>
            <input type="text" name="questions[${qNum}][choices][]" required placeholder="Enter choice text" class="choice-input">
            <button type="button" class="remove-choice-btn" title="Remove choice">&times;</button>
        `;
        choicesList.appendChild(cDiv);

        // Add remove choice functionality
        cDiv.querySelector('.remove-choice-btn').addEventListener('click', function() {
            cDiv.remove();
        });
    }
}
