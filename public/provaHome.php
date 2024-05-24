<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>KanBoard - Home</title>
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        .board {
            display: flex;
            justify-content: space-between;
        }

        .column {
            width: 23%;
            padding: 10px;
            border: 1px solid #ccc;
        }

        .task {
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #000;
            cursor: pointer;
        }
    </style>
</head>

<body onload="carica()">
    <div class="board" ondragover="allowDrop(event)" ondrop="drop(event)">
        <div class="column" ondragover="allowDrop(event)" ondrop="drop(event)">
            <h2>To-Do</h2>
            <div id="todo" ondragstart="drag(event)" draggable="true"></div>
        </div>
        <div class="column" ondragover="allowDrop(event)" ondrop="drop(event)">
            <h2>Doing</h2>
            <div id="doing" ondragstart="drag(event)" draggable="true"></div>
        </div>
        <div class="column" ondragover="allowDrop(event)" ondrop="drop(event)">
            <h2>Done</h2>
            <div id="done" ondragstart="drag(event)" draggable="true"></div>
        </div>
        <div class="column" ondragover="allowDrop(event)" ondrop="drop(event)">
            <h2>Archived</h2>
            <div id="archived" ondragstart="drag(event)" draggable="true"></div>
        </div>
    </div>
    <script>
        async function carica() {
            const response = await fetch("../private/home/elenco_attivita.php");
            const data = await response.json();

            const todo = document.getElementById('todo');
            const doing = document.getElementById('doing');
            const done = document.getElementById('done');
            const archived = document.getElementById('archived');

            for (let i = 0; i < data.length; i++) {
                const task = data[i];
                const taskElement = document.createElement('div');
                taskElement.classList.add('task');
                taskElement.innerHTML = `<h3>${task.titolo}</h3>`;
                taskElement.setAttribute('data-id', task.id); // Aggiungiamo un attributo con l'id dell'attività

                switch (task.stato) {
                    case 'To-Do':
                        todo.appendChild(taskElement);
                        break;
                    case 'Doing':
                        doing.appendChild(taskElement);
                        break;
                    case 'Done':
                        done.appendChild(taskElement);
                        break;
                    case 'Archived':
                        archived.appendChild(taskElement);
                        break;
                }
            }
        }

        function allowDrop(event) {
            event.preventDefault();
        }

        function drag(event) {
            event.dataTransfer.setData("text", event.target.getAttribute('data-id'));
        }

        async function drop(event) {
        event.preventDefault();
        const taskId = event.dataTransfer.getData("text");
        const newState = event.target.closest('.column').querySelector('h2').textContent.trim();

        const response = await fetch('aggiorna_attivita.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                taskId: taskId,
                newState: newState
            })
        });
            const result = await response.json();
            console.log(result);
            carica();
    }
    </script>
</body>

</html>
