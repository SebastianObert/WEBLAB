<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

include '../config/database.php';

$user_id = $_SESSION['user_id'];

$stmt = $mysqli->prepare("SELECT username FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$filter_sql = "
    SELECT tl.id AS todo_id, tl.title, tl.description, tl.due_date, tl.priority, tl.color, t.status 
    FROM todo_lists tl 
    LEFT JOIN tasks t ON tl.id = t.todo_id 
    WHERE tl.user_id = ?
";

$params = [$user_id];

    if (!empty($search)) {
    $filter_sql .= " AND (tl.title LIKE ? OR tl.description LIKE ?)";
    $params[] = '%' . $search . '%'; 
    $params[] = '%' . $search . '%'; 
}

if ($filter !== 'all') {
    $filter_sql .= " AND t.status = ?";
     $params[] = $filter;
}

$stmt = $mysqli->prepare($filter_sql);

if (count($params) > 0) {
    $types = str_repeat('i', 1); 
    if (!empty($search)) {
        $types .= str_repeat('s', 2); 
    }
    if ($filter !== 'all') {
        $types .= 's'; 
    }
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param('i', $user_id);
}

$stmt->execute();
$stmt->bind_result($todo_id, $title, $description, $due_date, $priority, $color, $status);
$todos = [];

while ($stmt->fetch()) {
    $todos[] = [
        'id' => $todo_id,
        'title' => $title,
        'description' => $description,
        'due_date' => $due_date,
        'priority' => $priority,
        'color' => $color,
        'status' => $status,
    ];
}

$stmt->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-l from-slate-600 to-slate-800 text-white font-[poppins]">


<nav class="p-4">
    <div class="container mx-auto w-10/12 flex justify-between items-center">
        <a href="#" class="text-2xl font-bold text-indigo-400">Dailyze</a>
        <div class="flex space-x-4">
            <a href="../logout.php" class="flex items-center border border-violet-600 bg-violet-600 hover:bg-white text-white hover:text-black px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> Logout
            </a>
            <a href="profile.php" class="flex items-center border border-black bg-zinc-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
                <i class="fa-solid fa-user mr-2"></i> Profile
            </a>
        </div>
    </div>
</nav>


<div class="container mx-auto mt-10 p-6">
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold mb-2">Welcome, <span class="text-indigo-400"><?php echo htmlspecialchars($username); ?></span></h1>
        <p class="text-gray-400">Your personalized to-do list dashboard</p>
    </div>

     <div class="mb-4 text-center">
       <form method="GET" class="mb-4">
    <input type="text" name="search" placeholder="Search tasks..." class="bg-gray-200 text-black rounded-md p-2">
    <button type="submit" class="bg-violet-600 text-white rounded-md px-4">Search</button>
    </form>
    </div>
    
    <div class="mb-4 text-center">
        <a href="?filter=all" class="bg-violet-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">All Tasks</a>
        <a href="?filter=incomplete" class="bg-violet-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">Incomplete</a>
        <a href="?filter=complete" class="bg-violet-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">Complete</a>
        <a href="?filter=in progress" class="bg-violet-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">In Progress</a>
        <a href="?filter=overdue" class="bg-violet-600 hover:bg-white hover:text-black text-white px-4 py-2 rounded-md shadow-lg transition ease-in-out delay-75">Overdue</a>
    </div>

    <div class="flex items-center justify-center">
        <div class="bg-zinc-50 w-1/2 p-6 border-2 text-black border-violet-800 rounded-lg shadow-md shadow-violet-200 hover:shadow-violet-500 transition ease-in-out delay-75">
            <h2 class="text-2xl font-semibold mb-4 text-black">Your To-Do Lists</h2>
            <ul class="space-y-4">
                <?php if (empty($todos)): ?>
                    <li class="bg-zinc-100 p-4 text-center border border-black">
                        No to-do lists available.
                        <a href="create_todo.php" class="bg-violet-600 hover:bg-white hover:text-black text-white px-6 py-2 rounded-md shadow-lg transition ease-in-out delay-75">
                            Create New To-Do List
                        </a>
                    </li>
                <?php else: ?>
                    <?php foreach ($todos as $todo): ?>
                        <li class="bg-zinc-100 p-4 flex justify-between items-center border border-black" style="border-left: 5px solid <?php echo htmlspecialchars($todo['color']); ?>">
                            <div>
                                <a href="view_tasks.php?id=<?php echo $todo['id']; ?>" class="text-lg font-semibold hover:text-violet-300 transition ease-in-out delay-75"><?php echo htmlspecialchars($todo['title']); ?></a>
                                <p class="text-gray-600"><?php echo htmlspecialchars($todo['description']); ?></p>
                                <p class="text-gray-500">Due: <?php echo htmlspecialchars($todo['due_date']); ?></p>
                                <p class="text-gray-500">Priority: <?php echo htmlspecialchars($todo['priority']); ?></p>
                            </div>
                            <div>
 
                                <form action="update_task_status.php" method="post" class="inline">
                                    <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                    <select name="status" onchange="this.form.submit()" class="bg-gray-700 text-white rounded-md">
                                        <option value="incomplete" <?php echo ($todo['status'] === 'incomplete') ? 'selected' : ''; ?>>Incomplete</option>
                                        <option value="in progress" <?php echo ($todo['status'] === 'in progress') ? 'selected' : ''; ?>>In Progress</option>
                                        <option value="complete" <?php echo ($todo['status'] === 'complete') ? 'selected' : ''; ?>>Complete</option>
                                        <option value="overdue" <?php echo ($todo['status'] === 'overdue') ? 'selected' : ''; ?>>Overdue</option>
                                    </select>
                                </form>
                              
                                <form action="delete_todo.php" method="post" class="inline ml-2">
                                    <input type="hidden" name="todo_id" value="<?php echo $todo['id']; ?>">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this list?');" class="text-red-400 hover:text-red-600 transition ease-in-out delay-75">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <div class="mt-6 flex justify-center gap-4">
        <a href="create_todo.php" class="bg-violet-600 hover:bg-white hover:text-black text-white px-6 py-2 rounded-md shadow-lg transition ease-in-out delay-75">Create New To-Do List</a>
    </div>
</div>

</body>
</html>
