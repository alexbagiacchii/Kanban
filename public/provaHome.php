<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>KanBoard - Home</title>
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/logo.png">
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
        }
    </style>
</head>

<body onload="carica()">
    <div class="board">
        <div class="column">
            <h2>To-Do</h2>
            <div id="todo"></div>
        </div>
        <div class="column">
            <h2>Doing</h2>
            <div id="doing"></div>
        </div>
        <div class="column">
            <h2>Done</h2>
            <div id="done"></div>
        </div>
        <div class="column">
            <h2>Archived</h2>
            <div id="archived"></div>
        </div>
    </div>
    <script>
        async function carica() {
            const response = await fetch("../private/home/elenco_attivita.php");
            const data = await response.json();
            console.log(data);

            const todo = document.getElementById('todo');
            const doing = document.getElementById('doing');
            const done = document.getElementById('done');
            const archived = document.getElementById('archived');

            data.forEach(task => {
                const taskElement = document.createElement('div');
                taskElement.classList.add('task');
                taskElement.innerHTML = `<h3>${task.titolo}</h3><p>${task.descrizione}</p><p>Priorità: ${task.priorita}</p><p>Data Inizio: ${task.data_inizio}</p>`;

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
            });
        }
    </script>
    <script src="../private/home.js"></script>
</body>

</html>
