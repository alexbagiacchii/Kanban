<!DOCTYPE html>

<head>
    <meta charset="UTF-8" />
    <title>KanBoard - Home</title>
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="img/logo.png">

</head>

<body onload="carica()">
    <div id="todo" class="tab">
        <h2>To-Do</h2>
        <div id="todoTasks" class="tasks"></div>
    </div>
    <div id="doing" class="tab">
        <h2>Doing</h2>
        <div id="doingTasks" class="tasks"></div>
    </div>
    <div id="done" class="tab">
        <h2>Done</h2>
        <div id="doneTasks" class="tasks"></div>
    </div>
    <div id="archived" class="tab">
        <h2>Archived</h2>
        <div id="archivedTasks" class="tasks"></div>
    </div>
    <script>
        async function carica() {
            const response = await fetch("../private/home/elenco_attivita.php");
            const data = await response.json();
            console.log(data);

        }
    </script>
    </section>
    <script src="../private/home.js"></script>
</body>

</html>