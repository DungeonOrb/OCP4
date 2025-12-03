<!DOCTYPE html>
<html>
<link rel="stylesheet" href="./css/style.css">

<body>
    <?php
    /*$data = [
    ["id" => 1, "name" => "Alice",   "score" => 88, "date" => "2024-03-04"],
    ["id" => 2, "name" => "Bob",     "score" => 92, "date" => "2024-01-18"],
    ["id" => 3, "name" => "Charlie", "score" => 75, "date" => "2024-02-10"],
    ["id" => 4, "name" => "Diana",   "score" => 95, "date" => "2024-03-01"],
];*/
    $articleManager = new ArticleManager();
    $articles = $articleManager->getAllArticles();


    $sort = $_GET['sort']  ?? 'title';
    $order = $_GET['order'] ?? 'asc';

    $allowed = ['title', 'content', 'date_creation', 'views'];
    if (!in_array($sort, $allowed)) {
        $sort = 'title';
    }

    $nextOrder = ($order === 'asc') ? 'desc' : 'asc';


    usort($articles, function ($a, $b) use ($sort, $order) {

        $method = [
            'title'         => 'getTitle',
            'content'       => 'getContent',
            'date_creation' => 'getDateCreation',
            'views'         => 'getViews'
        ];

        $m = $method[$sort];

        $valA = $a->$m();
        $valB = $b->$m();

        if ($valA == $valB) return 0;

        return ($order === 'asc')
            ? (($valA < $valB) ? -1 : 1)
            : (($valA > $valB) ? -1 : 1);
    });

    function sortArrow($column, $sort, $order)
    {
        if ($column !== $sort) {
            return " <span style='color:#999'>▲▼</span>";
        }
        return $order === "asc"
            ? " <span style='color:black'>▲</span>"
            : " <span style='color:black'>▼</span>";
    }
    ?>


    <table>
        <thead>
            <tr>
                <th><a href="?action=monitoring&sort=titre&order=<?= $nextOrder ?>">Titre</a><?= sortArrow("titre", $sort, $order) ?></th>
                <th><a href="?action=monitoring&sort=date&order=<?= $nextOrder ?>">Date</a><?= sortArrow("date", $sort, $order) ?></th>
                <th><a href="?action=monitoring&sort=views&order=<?= $nextOrder ?>">Vues</a><?= sortArrow("views", $sort, $order) ?></th>
                <th><a href="?action=monitoring&sort=nbcomment&order=<?= $nextOrder ?>">Commentaires</a><?= sortArrow("nbcomment", $sort, $order) ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article):
                $id = $article->getId();
                $commentManager = new CommentManager();
                $comments = $commentManager->countAllCommentsByArticleId($id);
            ?>
                <tr>
                    <td><?= htmlspecialchars($article->getTitle()) ?></td>
                    <?php $date = $article->getDateCreation()->format('d-m-Y'); ?>
                    <td><?= htmlspecialchars($date) ?></td>
                    <td><?= htmlspecialchars($article->getViews()) ?> </td>
                    <td><?= $comments ?> <a class="submit" href="http://localhost/Projet2-2/index.php?action=showArticle&id=<?=$id?>" >Voir</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>